<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\OrderDetail;
use App\Models\Pizza;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function reviewPizzas()
    {
        $pageTitle    = 'Reviews';

        $pizzaId = OrderDetail::with('order')->whereHas('order', function ($order) {
            $order->where('user_id', auth()->id())->where('status', 1);
        })->distinct('pizza_id')->pluck('pizza_id');

        $pizzas = Pizza::active()->whereIn('id', $pizzaId)->with(['reviews' => function ($q) {
            $q->where('user_id', auth()->id());
        }])->with('pizzaPrice')->paginate(getPaginate());

        return view($this->activeTemplate . 'user.review.index', compact('pageTitle', 'pizzas'));
    }

    public function reviewCreate($id)
    {
        $pageTitle = 'Add Review';


        $pizza   = Pizza::active()->findOrFail($id);
        return view($this->activeTemplate . 'user.review.create', compact('pageTitle', 'pizza'));
    }
    public function reviewStore(Request $request, $id)
    {
        $request->validate([
            'stars' => 'required|integer|in:1,2,3,4,5',
            'review_comment' => 'required|string'
        ]);


        $pizza = OrderDetail::with('order')->whereHas('order', function ($order) use ($id) {
            $order->where('user_id', auth()->id())->where('pizza_id', $id)->where('status', 1);
        })->firstOrFail();

        $review = Review::where('user_id', auth()->id())->where('pizza_id', $id)->exists();

        if ($review) {
            $notify[] = ['error', 'You have already reviewed this pizza.'];
            return back()->withNotify($notify);
        }

        $review                 = new Review();
        $review->user_id        = auth()->id();
        $review->pizza_id       = $id;
        $review->stars          = $request->stars;
        $review->review_comment = $request->review_comment;
        $review->save();

        $pizza                  = Pizza::with('reviews')->findOrFail($id);
        $totalReview            = $pizza->reviews->count();
        $totalStar              = $pizza->reviews->sum('stars');
        $avgRating              = $totalStar / $totalReview;

        $pizza->avg_rating      = $avgRating;
        $pizza->save();

        $notify[] = ['success', 'Review added successfully.'];
        return back()->withNotify($notify);
    }
}
