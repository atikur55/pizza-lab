@php
$blogs = App\Models\Frontend::where('data_keys', 'blog.element')
    ->latest()
    ->take(3)
    ->get();
$blogContent = getContent('blog.content', true);
@endphp

<section class="pt-80 pb-80">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="section-header text-center">
                    <div class="section-top-title"><span>{{ __(@$blogContent->data_values->heading) }}</span></div>
                    <h2 class="section-title">{{ __(@$blogContent->data_values->subheading) }}</h2>
                </div>
            </div>
        </div>
        <div class="row justify-content-center gy-4">
            @foreach ($blogs as $blog)
                <div class="col-lg-4 col-md-6">
                    <div class="blog-item">
                        <div class="blog-item__thumb">
                            <img src="{{ getImage('assets/images/frontend/blog/thumb_' . @$blog->data_values->blog_image, '430x270') }}" alt="image">
                        </div>
                        <div class="blog-item__content">
                            <span class="mb-2"><i class="far fa-calendar-alt me-1"></i> {{ showDateTime($blog->created_at) }}</span>
                            <h4 class="title"><a href="{{ route('blog.details', [slug(@$blog->data_values->title), $blog->id]) }}">{{ __(@$blog->data_values->title) }}</a></h4>
                            <p class="mt-3">@php echo strLimit(strip_tags(@$blog->data_values->description), 90) @endphp</p>
                            <a href="{{ route('blog.details', [slug(@$blog->data_values->title), $blog->id]) }}" class="read-more-btn mt-3">@lang('Read More')
                                <i class="fas fa-long-arrow-alt-right ms-2"></i>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
