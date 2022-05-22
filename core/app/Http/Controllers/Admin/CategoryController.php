<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Rules\FileTypeValidate;
use Illuminate\Http\Request;

class CategoryController extends Controller {

    public function index(Request $request) {
        $pageTitle  = 'All Categories';
        $categories = Category::query();

        if ($request->search) {
            $categories->where('name', 'LIKE', "%$request->search%");
        }

        $categories = $categories->latest()->paginate(getPaginate());
        return view('admin.category.index', compact('pageTitle', 'categories'));
    }

    public function store(Request $request, $id = 0) {
        $imageValidation = $id?'nullable':'required';

        $validate = [
            'name'  => 'required|max: 40|unique:categories,name,'.$id,
            'image' => [$imageValidation, 'image', new FileTypeValidate(['jpeg', 'jpg', 'png'])]
        ];

        $request->validate($validate);

        if($id == 0){
            $category = new Category();
            $notification = 'Category added successfully.';
        }else{
            $category = Category::findOrFail($id);
            $category->status   = $request->status ? 1 : 0;
            $notification = 'Category updated successfully';
        }

        if ($request->hasFile('image')) {
            try {
                $category->image = fileUploader($request->image, getFilePath('category'), getFileSize('category'), $category->image);
            } catch (\Exception $exp) {
                $notify[] = ['error', 'Couldn\'t upload your image'];
                return back()->withNotify($notify);
            }
        }

        $category->name         = $request->name;
        $category->featured     = $request->featured ? 1 : 0;
        $category->save();

        $notify[] = ['success', $notification];
        return back()->withNotify($notify);
    }

}
