<?php

namespace App\Http\Controllers;

use App\Models\AdminNotification;
use App\Models\Cart;
use App\Models\Category;
use App\Models\Frontend;
use App\Models\GeneralSetting;
use App\Models\Language;
use App\Models\Order;
use App\Models\Page;
use App\Models\Pizza;
use App\Models\PizzaSize;
use App\Models\SupportMessage;
use App\Models\SupportTicket;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Validator;

class SiteController extends Controller
{
    public function index()
    {
        $reference = @$_GET['reference'];

        if ($reference) {
            session()->put('reference', $reference);
        }

        $pageTitle  = 'Home';
        $sections   = Page::where('tempname', $this->activeTemplate)->where('slug', '/')->first();
        return view($this->activeTemplate . 'home', compact('pageTitle', 'sections'));
    }

    public function pages($slug)
    {
        $page      = Page::where('tempname', $this->activeTemplate)->where('slug', $slug)->firstOrFail();
        $pageTitle = $page->name;
        $sections  = $page->secs;
        return view($this->activeTemplate . 'pages', compact('pageTitle', 'sections'));
    }

    public function contact()
    {
        $pageTitle = "Contact Us";
        $sections  = Page::where('tempname', $this->activeTemplate)->where('slug', 'contact')->first();
        return view($this->activeTemplate . 'contact', compact('pageTitle', 'sections'));
    }

    public function contactSubmit(Request $request)
    {
        $this->validate($request, [
            'name'    => 'required',
            'email'   => 'required',
            'subject' => 'required|string|max:255',
            'message' => 'required',
        ]);

        if (!verifyCaptcha()) {
            $notify[] = ['error', 'Invalid captcha provided'];
            return back()->withNotify($notify);
        }

        $request->session()->regenerateToken();

        $random = getNumber();

        $ticket             = new SupportTicket();
        $ticket->user_id    = auth()->id() ?? 0;
        $ticket->name       = $request->name;
        $ticket->email      = $request->email;
        $ticket->priority   = 2;
        $ticket->ticket     = $random;
        $ticket->subject    = $request->subject;
        $ticket->last_reply = Carbon::now();
        $ticket->status     = 0;
        $ticket->save();

        $adminNotification            = new AdminNotification();
        $adminNotification->user_id   = auth()->user() ? auth()->user()->id : 0;
        $adminNotification->title     = 'A new support ticket has opened ';
        $adminNotification->click_url = urlPath('admin.ticket.view', $ticket->id);
        $adminNotification->save();

        $message                      = new SupportMessage();
        $message->support_ticket_id   = $ticket->id;
        $message->message             = $request->message;
        $message->save();

        $notify[] = ['success', 'Ticket created successfully!'];

        return to_route('ticket.view', [$ticket->ticket])->withNotify($notify);
    }

    public function policyPages($slug, $id)
    {
        $policy    = Frontend::where('id', $id)->where('data_keys', 'policy_pages.element')->firstOrFail();
        $pageTitle = $policy->data_values->title;
        return view($this->activeTemplate . 'policy', compact('policy', 'pageTitle'));
    }

    public function changeLanguage($lang = null)
    {
        $language = Language::where('code', $lang)->first();

        if (!$language) {
            $lang = 'en';
        }

        session()->put('lang', $lang);
        $notify[] = ['info', 'Admin can translate every word from the admin panel.'];
        $notify[] = ['warning', 'All Language keywords are not implemented in the demo version.'];
        return back()->withNotify($notify);
    }

    public function blog()
    {
        $blogs     = Frontend::where('data_keys', 'blog.element')->paginate(getPaginate(9));
        $pageTitle = 'Blog';
        $sections  = Page::where('tempname', $this->activeTemplate)->where('slug', 'blog')->first();
        return view($this->activeTemplate . 'blog', compact('blogs', 'pageTitle', 'sections'));
    }

    public function blogDetails($slug, $id)
    {
        $blog        = Frontend::where('id', $id)->where('data_keys', 'blog.element')->firstOrFail();
        $pageTitle   = 'Blog Detail';
        $latestBlogs = Frontend::where('id', '!=', $id)->where('data_keys', 'blog.element')->orderBy('id', 'desc')->limit(10)->get();
        return view($this->activeTemplate . 'blog_details', compact('blog', 'pageTitle', 'latestBlogs'));
    }

    public function cookieAccept()
    {
        $general = GeneralSetting::first();
        Cookie::queue('gdpr_cookie', $general->site_name, 43200);
        return back();
    }

    public function cookiePolicy()
    {
        $pageTitle = 'Cookie Policy';
        $cookie    = Frontend::where('data_keys', 'cookie.data')->first();
        return view($this->activeTemplate . 'cookie', compact('pageTitle', 'cookie'));
    }

    public function placeholderImage($size = null)
    {
        $imgWidth  = explode('x', $size)[0];
        $imgHeight = explode('x', $size)[1];
        $text      = $imgWidth . '×' . $imgHeight;
        $fontFile  = realpath('assets/font') . DIRECTORY_SEPARATOR . 'RobotoMono-Regular.ttf';
        $fontSize  = round(($imgWidth - 50) / 8);

        if ($fontSize <= 9) {
            $fontSize = 9;
        }

        if ($imgHeight < 100 && $fontSize > 30) {
            $fontSize = 30;
        }

        $image      = imagecreatetruecolor($imgWidth, $imgHeight);
        $colorFill  = imagecolorallocate($image, 100, 100, 100);
        $bgFill     = imagecolorallocate($image, 175, 175, 175);
        imagefill($image, 0, 0, $bgFill);
        $textBox    = imagettfbbox($fontSize, 0, $fontFile, $text);
        $textWidth  = abs($textBox[4] - $textBox[0]);
        $textHeight = abs($textBox[5] - $textBox[1]);
        $textX      = ($imgWidth - $textWidth) / 2;
        $textY      = ($imgHeight + $textHeight) / 2;
        header('Content-Type: image/jpeg');
        imagettftext($image, $fontSize, 0, $textX, $textY, $colorFill, $fontFile, $text);
        imagejpeg($image);
        imagedestroy($image);
    }

    public function pizzaDetail($id)
    {
        $pageTitle  = 'Pizza Detail';
        $pizza      = Pizza::active()->with('category', 'PizzaSize', 'pizzaGallery', 'reviews.user')->findOrFail($id);
        return view($this->activeTemplate . 'pizza.detail', compact('pageTitle', 'pizza'));
    }

    public function cartCount()
    {
        return Cart::where('user_id', auth()->id())->count();
    }

    public function allPizzas(Request $request)
    {
        $pageTitle     = 'Pizzas';
        $pizzas        = $this->getPizzas($request);
        $categories    = Category::where('status', 1)->orderBy('id', 'desc')->get();
        return view($this->activeTemplate . 'pizza.list', compact('pageTitle', 'pizzas', 'categories'));
    }

    public function filterPizza(Request $request)
    {
        $pizzas = $this->getPizzas($request);
        return view($this->activeTemplate . 'pizza.filtered', compact('pizzas'));
    }

    public function pizzaByCategory(Request $request, $id, $name)
    {
        $pageTitle = 'Category - ' . $name;
        $pizzas    = Pizza::active()->where('category_id', $id)->latest()->with('pizzaPrice', 'category')->paginate(getPaginate());
        return view($this->activeTemplate . 'pizza.list', compact('pageTitle', 'pizzas', 'id'));
    }

    protected function getPizzas($request)
    {
        $pizzas    = Pizza::active();

        if ($request->categories) {
            $pizzas = $pizzas->whereIn('category_id', $request->categories);
        }

        if ($request->categoryId) {
            $pizzas = $pizzas->where('category_id', $request->categoryId);
        }

        if ($request->search) {
            $search = $request->search;
            $pizzas = $pizzas->where(function ($q) use ($search) {
                $q->orWhere('name', 'LIKE', '%' . $search . '%')->orWhereHas('category', function ($category) use ($search) {
                    $category->where('name', 'like', "%$search%");
                });
            });
        }

        if ($request->min && $request->max) {
            $pizzaId     = PizzaSize::whereBetween('price', [$request->min, $request->max])->select('pizza_id')->distinct('pizza_id')->get();
            $pizzas = $pizzas->whereIn('id', $pizzaId);
        }

        if ($request->sort) {
            $sort = explode('_', $request->sort);

            if ($request->sort == 'id_desc') {
                $pizzas = $pizzas->orderBy(@$sort[0], @$sort[1]);
            }

            if ($request->sort == 'price_asc' || $request->sort == 'price_desc') {
                $pizzaId     = PizzaSize::orderBy(@$sort[0], @$sort[1])->select('pizza_id')->distinct('pizza_id')->pluck('pizza_id');
                $orderId     = implode(',', $pizzaId->toArray());
                $pizzas = $pizzas->whereIn('id', $pizzaId)->orderByRaw("FIELD(id, $orderId)");
            }
        }

        return $pizzas->latest()->with('pizzaPrice', 'category')->paginate(getPaginate(9));
    }

    public function trackOrder()
    {
        $pageTitle = 'Track Your Order';
        return view($this->activeTemplate . 'track_order', compact('pageTitle'));
    }

    public function getTrackOrder($orderNumber)
    {

        $order = Order::where('order_no', $orderNumber)->first();

        if (!$order) {
            return response()->json(['error' => 'No order found with this order number']);
        }

        if ($order->status == 4) {
            $emptyMessage = 'Your order has been cancelled.';
            return response()->json(['emptyMessage' => $emptyMessage]);
        }

        return response()->json([
            'order' => $order,
        ]);
    }


    public function maintenance()
    {
        $pageTitle = 'Maintenance Mode';
        $general = GeneralSetting::first();
        if($general->maintenance_mode == 0){
            return to_route('home');
        }
        $maintenance = Frontend::where('data_keys','maintenance.data')->first();
        return view($this->activeTemplate.'maintenance',compact('pageTitle','maintenance'));
    }
}
