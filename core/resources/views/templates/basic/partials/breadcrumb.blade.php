@php
$breadcrumb = getContent('breadcrumb.content', true);
@endphp
<section class="inner-hero bg_img" style="background-image: url('{{ getImage('assets/images/frontend/breadcrumb/' . @$breadcrumb->data_values->image, '1920x225') }}')">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6 text-center">
                <ul class="page-breadcrumb justify-content-center">
                    <li class="fs--20px">{{ __($pageTitle) }}</li>
                </ul>
            </div>
        </div>
    </div>
</section>
