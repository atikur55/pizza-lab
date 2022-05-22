@extends($activeTemplate.'layouts.master')
@section('content')
    <div class="card custom--card">
        <div class="card-header">
            <h5 class="title d-inline-block">{{ __($pageTitle) }}</h5>
            <h5 class="float-end">{{ __($pizza->name) }}</h5>
        </div>

        <div class="card-body">
            <form action="{{ route('user.review.store',$pizza->id) }}" method="POST" class="review-form rating row">
                @csrf
                <div class="form-group col-md-6">
                    <label for="your-name" class="review-label">@lang('Your Name')</label>
                    <input type="text" class="form-control form--control" id="your-name"
                        name="username" value="{{ auth()->user()->username }}" readonly>
                </div>
                <div class="form-group col-md-6">
                    <label for="your-email" class="review-label">@lang('Your Email')</label>
                    <input type="text" class="form-control form--control" id="your-email"
                        name="email" value="{{ auth()->user()->email }}" readonly>
                </div>
                <div class="form-group col-md-6 d-flex flex-wrap">
                    <label class="review-label mb-0 me-3">@lang('Your Ratings') :</label>
                    <div class="rating-form-group">
                        <label class="star-label">
                            <input type="radio" name="stars" value="1"/>
                            <span class="icon"><i class="las la-star"></i></span>
                        </label>
                        <label class="star-label">
                            <input type="radio" name="stars" value="2"/>
                            <span class="icon"><i class="las la-star"></i></span>
                            <span class="icon"><i class="las la-star"></i></span>
                        </label>
                        <label class="star-label">
                            <input type="radio" name="stars" value="3"/>
                            <span class="icon"><i class="las la-star"></i></span>
                            <span class="icon"><i class="las la-star"></i></span>
                            <span class="icon"><i class="las la-star"></i></span>
                        </label>
                        <label class="star-label">
                            <input type="radio" name="stars" value="4"/>
                            <span class="icon"><i class="las la-star"></i></span>
                            <span class="icon"><i class="las la-star"></i></span>
                            <span class="icon"><i class="las la-star"></i></span>
                            <span class="icon"><i class="las la-star"></i></span>
                        </label>
                        <label class="star-label">
                            <input type="radio" name="stars" value="5"/>
                            <span class="icon"><i class="las la-star"></i></span>
                            <span class="icon"><i class="las la-star"></i></span>
                            <span class="icon"><i class="las la-star"></i></span>
                            <span class="icon"><i class="las la-star"></i></span>
                            <span class="icon"><i class="las la-star"></i></span>
                        </label>
                    </div>
                </div>
                <div class="form-group col-12 d-flex flex-wrap">
                    <label class="review-label" for="review-comments">
                        @lang('Say something about this products')
                    </label>
                    <textarea name="review_comment" class="form-control form--control"
                        id="review-comments" placeholder="@lang('Write here')...">{{ old('review_comment') }}</textarea>
                </div>
                <div class="form-group mb-0 col-12 d-flex flex-wrap">
                    <button type="submit" class="btn btn--base w-100">@lang('Submit')</button>
                </div>
            </form>
        </div>
    </div>
@endsection
@push('style')
    <style>
        .review-item .ratings {
    color: #ff9613;
    font-size: 18px;
}

.rating .rating-form-group {
    position: relative;
    height: 24px;
    line-height: 24px;
    font-size: 24px;
    cursor: pointer;
}

.rating .rating-form-group .star-label {
    position: absolute;
    top: 0;
    left: 0;
    height: 100%;
    cursor: pointer;
}

.rating .rating-form-group .star-label:last-child {
    position: static;
}

.rating .rating-form-group .star-label:nth-child(1) {
    z-index: 5;
}

.rating .rating-form-group .star-label:nth-child(2) {
    z-index: 4;
}

.rating .rating-form-group .star-label:nth-child(3) {
    z-index: 3;
}

.rating .rating-form-group .star-label:nth-child(4) {
    z-index: 2;
}

.rating .rating-form-group .star-label:nth-child(5) {
    z-index: 1;
}

.rating .rating-form-group .star-label input {
    display: none;
}

.rating .rating-form-group .star-label .icon {
    float: left;
    color: transparent;
}

.rating .rating-form-group .star-label:last-child .icon {
    color: #555555;
}

.rating .rating-form-group:not(:hover) label input:checked~.icon,
.rating .rating-form-group:hover label:hover input~.icon {
    color: #F90716;
}

.rating .rating-form-group label input:focus:not(:checked)~.icon:last-child {
    color: rgba(255, 255, 255, 0.1);
    text-shadow: 0 0 5px #F90716;
}
    </style>
@endpush


