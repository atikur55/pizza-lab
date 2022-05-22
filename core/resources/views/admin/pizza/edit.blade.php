@extends('admin.layouts.app')

@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <form action="{{ route('admin.pizza.update', $pizza->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4 col-lg-4 col-xl-3">
                                <div class="form-group">
                                    <div class="payment-method-item">
                                        <div class="payment-method-header">
                                            <div class="thumb">
                                                <label class="form-control-label">@lang('Image')<span class="text--danger">*</span></label>
                                                <div class="avatar-preview">
                                                    <div class="profilePicPreview" style="background-image: url('{{ getImage(getFilePath('pizza') . '/' . $pizza->image, getFileSize('pizza')) }}')">
                                                    </div>
                                                </div>
                                                <div class="avatar-edit">
                                                    <input type="file" name="image" class="profilePicUpload" id="image" accept=".png, .jpg, .jpeg" />
                                                    <label for="image" class="bg--primary"><i class="la la-pencil"></i></label>
                                                </div>
                                            </div>
                                        </div>
                                        <small class="text-facebook mt-2">@lang('Supported files'):
                                            <b>@lang('jpeg'), @lang('jpg'), @lang('png').</b> @lang('Image will be resized into '){{ getFileSize('pizza') }} @lang('px')
                                        </small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8 col-lg-8 col-xl-9">
                                <div class="form-group">
                                    <label class="form-control-label">@lang('Category Name')<span class="text--danger">*</span></label>
                                    <select name="category_id" class="form-control">
                                        <option value="" selected disabled>@lang('Select One')</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}" @if ($pizza->category_id == $category->id) selected="selected" @endif>
                                                {{ __($category->name) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label">@lang('Pizza Name')</label>
                                    <input class="form-control" type="text" name="name" required value="{{ $pizza->name }}">
                                </div>

                                <div class="form-group">
                                    <label class="form-control-label">@lang('Ingredients')<span class="text--danger">*</span></label>
                                    <select class="select2-auto-tokenize form-select-lg" multiple="multiple" name="ingredients[]">
                                        @foreach (json_decode($pizza->ingredients) as $ingredient)
                                            <option value="{{ $ingredient }}" selected>{{ $ingredient }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <label class="form-control-label">@lang('Status')</label>
                                            <input type="checkbox" data-width="100%" data-size="large" data-onstyle="-success" data-offstyle="-danger" data-bs-toggle="toggle" data-height="50" data-on="@lang('Available')" data-off="@lang('Not Available')" name="status" @if ($pizza->status) checked @endif>
                                        </div>
                                        <div class="col-sm-6">
                                            <label class="form-control-label">@lang('Featured')</label>
                                            <input type="checkbox" data-width="100%" data-size="large" data-onstyle="-success" data-offstyle="-danger" data-bs-toggle="toggle" data-height="50" data-on="@lang('Yes')" data-off="@lang('No')" name="featured" @if ($pizza->featured) checked @endif>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-control-label">@lang('Short Description')<span class="text--danger">*</span></label>
                                    <textarea type="text" name="short_description" class="form-control" rows="4">{{ $pizza->short_description }}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-control-label">@lang('Description')<span class="text--danger">*</span></label>
                                    <textarea name="description" class="form-control nicEdit" rows="5">{{ $pizza->description }}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="content w-100 ps-0 border-bottom my-3">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <div class="form-group mb-0">
                                    <h4>@lang('Size, Price')</h4>
                                </div>
                                <button type="button" class="btn btn--primary addSizeBtn flex-shrink-0">
                                    <i class="las la-plus"></i>@lang('Add New')
                                </button>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="addedSize">
                                    @foreach ($pizza->pizzaSize as $size)
                                        <div class="size-data">
                                            <div class="form-group">
                                                <div class="row mb-4">
                                                    <input type="hidden" name="sizeId[]" value="{{ $size->id }}">
                                                    <div class="col-md-5 mb-md-0 mb-2">
                                                        <div class="input-group">
                                                            <input name="size[]" class="form-control" type="number" required placeholder="@lang('Size')" value="{{ $size->size }}">
                                                            <div class="input-group-text">@lang('Inch')</div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-5 mb-md-0 mb-2">
                                                        <div class="input-group">
                                                            <input name="price[]" class="form-control" type="number" step="any" required placeholder="@lang('Price')" value="{{ showAmount($size->price) }}">
                                                            <div class="input-group-text">{{ $general->cur_text }}</div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2 mb-md-0 mb-2">
                                                        <button class="btn btn--danger remove-Size w-100 h-45 @if ($loop->first) disabled @endif" type="button"> <i class="fa fa-times"></i></button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="content w-100 ps-0 mt-3">
                            <div class="d-flex justify-content-between algin-items-center mb-4">
                                <div class="form-group">
                                    <h4>@lang('Images')</h4>
                                </div>
                                <button type="button" class="btn btn--primary galleryBtn flex-shrink-0">
                                    <i class="las la-plus"></i>@lang('Add More')
                                </button>
                            </div>
                        </div>
                        <div class="row pizzaGallery">
                            @foreach ($pizza->pizzaGallery as $k => $gallery)
                                <div class="col-md-4 col-lg-4 col-xl-3 gallery-data">
                                    <div class="form-group">
                                        <div class="image-upload">
                                            <div class="thumb">
                                                <div class="avatar-preview">
                                                    <input type="hidden" name="imageId[]" value="{{ $gallery->id }}">
                                                    <div class="profilePicPreview" style="background-image: url({{ getImage(getFilePath('pizza') . '/' . $gallery->image, getFileSize('pizza')) }})">
                                                        <button type="button" class="remove-image removeBtn d-block"><i class="fa fa-times"></i></button>
                                                    </div>
                                                </div>
                                                <div class="avatar-edit">
                                                    <input type="file" class="profilePicUpload" name="gallery_image[]" id="{{ $k }}" accept=".png, .jpg, .jpeg">
                                                    <label for="{{ $k }}" class="bg--success">@lang('Upload Image')</label>
                                                    <small class="text-facebook mt-2">@lang('Supported files'):
                                                        <b>@lang('jpeg'), @lang('jpg'), @lang('png').</b> @lang('Image will be resized into') {{ getFileSize('pizza') }} @lang('px')</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn--primary w-100 h-45">@lang('Submit')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('breadcrumb-plugins')
    <a href="{{ route('admin.pizza.index') }}" class="btn btn-sm btn-outline--primary"><i class="la la-undo"></i>@lang('Back')</a>
@endpush

@push('script')
    <script>
        (function($) {
            "use strict";
            $('.addSizeBtn').on('click', function() {
                var html = `
                <div class="size-data">
                    <div class="form-group">
                        <div class="mb-4 row">
                            <div class="col-md-5 mb-2 mb-md-0">
                                <div class="input-group">
                                    <input name="size[]" class="form-control" type="number" required placeholder="@lang('Size')">
                                    <div class="input-group-text">@lang('inch')</div>
                                </div>
                            </div>
                            <div class="col-md-5 mb-2 mb-md-0">
                                <div class="input-group">
                                    <input name="price[]" class="form-control" type="number" step="any" required placeholder="@lang('Price')">
                                    <div class="input-group-text">{{ $general->cur_text }}</div>
                                </div>
                            </div>
                            <div class="col-md-2 mb-2 mb-md-0">
                                <button class="btn btn--danger remove-Size w-100 h-45" type="button"> <i class="fa fa-times"></i></button>
                            </div>
                        </div>
                    </div>
                </div>`;
                $('.addedSize').append(html);
            });
            $(document).on('click', '.remove-Size', function() {
                $(this).closest('.size-data').remove();
            });

            $('.galleryBtn').on('click', function() {

                var randomId = Math.floor(Math.random() * 100);
                var html = `
                <div class="col-md-4 col-lg-4 col-xl-3 gallery-data">
                    <div class="form-group">
                        <div class="image-upload">
                            <div class="thumb">
                                <div class="avatar-preview">
                                    <div class="profilePicPreview" style="background-image: url({{ getImage('/', getFileSize('pizza')) }})">
                                        <button type="button" class="remove-image removeBtn d-block"><i class="fa fa-times"></i></button>
                                    </div>
                                </div>
                                <div class="avatar-edit">
                                    <input type="file" class="profilePicUpload" name="gallery_image[]" id="${randomId}" accept=".png, .jpg, .jpeg">
                                    <label for="${randomId}" class="bg--success">@lang('Upload Image')</label>
                                    <small class="mt-2 text-facebook">@lang('Supported files'): <b>@lang('jpeg'), @lang('jpg'), @lang('png').</b> @lang('Image will be resized into '){{ getFileSize('pizza') }} @lang('px') </small>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>`;

                $('.pizzaGallery').append(html);
            });

            $(document).on('click', '.removeBtn', function() {
                $(this).closest('.gallery-data').remove();
            });

            $('.select2-auto-tokenize').select2({
                dropdownParent: $('.card-body')
            });
        })(jQuery);
    </script>
@endpush
