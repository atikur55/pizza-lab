@php
    $chefContent = getContent('chef.content',true);
    $chefs = getContent('chef.element',false,null,true);
@endphp
<section class="pt-80 pb-80 section--bg">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="section-header text-center">
                    <div class="section-top-title"><span>{{ __(@$chefContent->data_values->heading) }}</span></div>
                    <h2 class="section-title">{{ __(@$chefContent->data_values->subheading) }}</h2>
                </div>
            </div>
        </div>
        <div class="row gy-4  justify-content-center">
            @foreach ($chefs as $chef)   
            <div class="col-xl-3 col-lg-4 col-sm-6">
                <div class="chef-item">
                    <div class="el"><img src="{{ getImage('assets/images/frontend/chef/'.@$chefContent->data_values->image,'75x100') }}" alt="image"></div>
                    <div class="chef-item__thumb">
                        <img src="{{ getImage('assets/images/frontend/chef/'.@$chef->data_values->chef_image,'220x220') }}" alt="image">
                    </div>
                    <div class="chef-item__content">
                        <h3 class="name">{{ __(@$chef->data_values->name) }}</h3>
                        <p class="text--base">{{ __(@$chef->data_values->experience) }}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
