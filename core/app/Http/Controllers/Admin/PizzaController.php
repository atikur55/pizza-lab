<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Pizza;
use App\Models\PizzaGallery;
use App\Models\PizzaSize;
use App\Models\Review;
use App\Rules\FileTypeValidate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PizzaController extends Controller
{

    public function index(Request $request)
    {
        $pageTitle  = 'All Pizzas';

        $pizzas = Pizza::query();

        if ($request->search) {
            $search     = $request->search;
            $pizzas = $pizzas->where(function ($q) use ($search) {
                $q->where('name', 'like', "%$search%")->orWhereHas('category', function ($query) use ($search) {
                    $query->where('name', 'like', "%$search%");
                });
            });
        }

        $pizzas = $pizzas->latest()->with('category', 'pizzaSize')->paginate(getPaginate());
        return view('admin.pizza.index', compact('pageTitle', 'pizzas'));
    }

    public function create()
    {
        $pageTitle  = 'Add New Pizza';
        $categories = Category::where('status', 1)->orderBy('name')->get();
        return view('admin.pizza.create', compact('pageTitle', 'categories'));
    }

    public function store(Request $request)
    {

        $this->validator($request->all(), $id = 0)->validate();
        $pizza = $this->insertPizza($request, $id = 0);
        $this->pizzaSize($pizza, $request, $id = 0);
        $this->pizzaImages($pizza, $request, $id = 0);
        $notify[] = ['success', 'New pizza added successfully'];
        return back()->withNotify($notify);
    }

    public function edit($id)
    {
        $pizza      = Pizza::with('category', 'pizzaGallery', 'pizzaSize')->findOrFail($id);
        $pageTitle  = 'Edit Pizza';
        $categories = Category::where('status', 1)->orderBy('name')->get();
        return view('admin.pizza.edit', compact('pageTitle', 'pizza', 'categories'));
    }

    public function update(Request $request, $id)
    {

        $this->validator($request->all(), $id)->validate();
        $pizza       = $this->insertPizza($request, $id);
        $this->pizzaSize($pizza, $request, $id);

        $oldImages   = $pizza->pizzaGallery->pluck('id')->toArray();
        $imageRemove = array_values(array_diff($oldImages, $request->imageId ?? []));

        foreach ($imageRemove as $remove) {
            $singleImage = PizzaGallery::find($remove);
            $location    = getFilePath('pizza');
            fileManager()->removeFile($location . '/' . $singleImage->image);
            fileManager()->removeFile($location . '/thumb_' . $singleImage->image);
            $singleImage->delete();
        }
        $this->pizzaImages($pizza, $request, $id);
        $notify[] = ['success', 'Pizza menu updated successfully.'];
        return back()->withNotify($notify);
    }

    protected function validator(array $data, $id)
    {
        $imageValidation = ($id == 0) ? 'required' : 'nullable';
        $validate = Validator::make($data, [
            'name'              => 'required|max:40',
            'category_id'       => 'required|integer',
            'short_description' => 'required|string',
            'description'       => 'required|string',
            'ingredients'       => 'required|array|min:1',
            'ingredients.*'     => 'required|string',
            'size'              => 'required|array',
            "size.*"            => "required|integer|gt:0",
            "price"             => 'required|array',
            "price.*"           => 'required|numeric|gt:0',
            'image'             => [$imageValidation, 'image', new FileTypeValidate(['jpeg', 'jpg', 'png'])],
        ]);
        return $validate;
    }

    protected function insertPizza($request, $id)
    {
        if ($id == 0) {
            $pizza = new Pizza();
            $oldFile = null;
        } else {
            $pizza = Pizza::with('category', 'pizzaGallery', 'pizzaSize')->findOrFail($id);
            $oldFile   = $pizza->image;
            $pizza->status = $request->status ? 1 : 0;
        }
        if ($request->hasFile('image')) {
            try {
                $pizza->image = fileUploader($request->image, getFilePath('pizza'), getFileSize('pizza'), $oldFile, getFileThumb('pizza'));
            } catch (\Exception $exp) {
                $notify[] = ['error', 'Couldn\'t upload your image'];
                return back()->withNotify($notify);
            }
        }

        $pizza->category_id       = $request->category_id;
        $pizza->name              = $request->name;
        $pizza->short_description = $request->short_description;
        $pizza->description       = $request->description;
        $pizza->featured          = $request->featured ? 1 : 0;
        $pizza->ingredients       = json_encode($request->ingredients);
        $pizza->save();

        return $pizza;
    }

    protected function pizzaSize($pizza, $request, $id)
    {

        if ($id != 0) {
            $oldSize    = $pizza->pizzaSize->pluck('id')->toArray();
            $sizeRemove = array_values(array_diff($oldSize, $request->sizeId ?? []));

            foreach ($sizeRemove as $size) {
                $removeSize = PizzaSize::find($size);
                $removeSize->delete();
            }
        }

        for ($i = 0; $i < count($request->size); $i++) {

            if (isset($request->sizeId[$i])) {
                $size = PizzaSize::find($request->sizeId[$i]);
            } else {
                $size = new PizzaSize();
            }

            $size->pizza_id = $pizza->id;
            $size->price    = $request->price[$i];
            $size->size     = $request->size[$i];
            $size->save();
        }
    }

    protected function pizzaImages($pizza, $request, $id)
    {
        if ($request->hasFile('gallery_image')) {
            foreach ($request->file('gallery_image') as $key => $image) {
                if (isset($request->imageId[$key])) {
                    $singleImage = PizzaGallery::find($request->imageId[$key]);
                    $location    = getFilePath('pizza');
                    fileManager()->removeFile($location . '/' . $singleImage->image);
                    fileManager()->removeFile($location . '/thumb_' . $singleImage->image);
                    $singleImage->delete();

                    $newImage           = fileUploader($image, getFilePath('pizza'), getFileSize('pizza'), null, getFileThumb('pizza'));
                    $singleImage->image = $newImage;
                    $singleImage->save();
                } else {
                    try {
                        $newImage = fileUploader($image, getFilePath('pizza'), getFileSize('pizza'), null, getFileThumb('pizza'));
                    } catch (\Exception $exp) {
                        $notify[] = ['error', 'Couldn\'t upload your image.'];
                        return back()->withNotify($notify);
                    }
                    $gallery           = new PizzaGallery();
                    $gallery->pizza_id = $pizza->id;
                    $gallery->image    = $newImage;
                    $gallery->save();
                }
            }
        }
    }

    public function reviews($id)
    {
        $pizza     = Pizza::findOrFail($id);
        $pageTitle = 'Reviews of ' . $pizza->name;
        $reviews   = Review::where('pizza_id', $id)->with('user')->paginate(getPaginate());
        return view('admin.pizza.reviews', compact('pageTitle', 'reviews'));
    }

    public function reviewRemove($id)
    {
        $review = Review::findOrFail($id);
        $review->delete();

        $pizza = Pizza::with('reviews')->findOrFail($review->pizza_id);
        if ($pizza->reviews->count() > 0) {
            $totalReview = $pizza->reviews->count();
            $totalStar   = $pizza->reviews->sum('stars');
            $avgRating   = $totalStar / $totalReview;
        } else {
            $avgRating = 0;
        }

        $pizza->avg_rating = $avgRating;
        $pizza->save();

        $notify[] = ['success', 'Review removed successfully'];
        return back()->withNotify($notify);
    }

    public function changeStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|integer|in:0,1'
        ]);


        $pizza = Pizza::findOrFail($id);
        $status = ($request->status == 1) ? 0 : 1;
        $pizza->status = $status;
        $pizza->save();

        $notify[] = ['success', 'Pizza status changed successfully'];
        return back()->withNotify($notify);
    }
}
