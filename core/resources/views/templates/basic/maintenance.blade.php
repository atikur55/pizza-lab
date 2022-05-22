@extends($activeTemplate.'layouts.app')
@section('app')
<section class="maintanance-page pt-80 pb-80 bg--danger">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-8">
                <div class="maintanance-icon mx-auto mb-4">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
                @php echo $maintenance->data_values->description @endphp
            </div>
        </div>
    </div>
</section>
@endsection
