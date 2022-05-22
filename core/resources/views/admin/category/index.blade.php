@extends('admin.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card b-radius--10 ">
                <div class="card-body p-0">
                    <div class="table-responsive--md table-responsive">
                        <table class="table table--light style--two">
                            <thead>
                            <tr>
                                <th>@lang('S.N.')</th>
                                <th>@lang('Name')</th>
                                <th>@lang('Status')</th>
                                <th>@lang('Featured')</th>
                                <th>@lang('Action')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($categories as $category)
                            <tr>
                                <td data-label="@lang('S.N.')">{{ $categories->firstItem() + $loop->index }}</td>
                                <td data-label="@lang('Name')">{{ __($category->name) }}</td>

                                <td data-label="@lang('Status')">
                                    @if ($category->status == 1)
                                        <span class="text--small badge font-weight-normal badge--success">@lang('Enabled')</span>
                                    @else
                                        <span class="text--small badge font-weight-normal badge--danger">
                                            @lang('Disabled')
                                        </span>
                                    @endif
                                </td>

                                <td data-label="@lang('Featured')">
                                    @if ($category->featured == 1)
                                    <span class="text--small badge font-weight-normal badge--primary">
                                        @lang('Yes')
                                    </span>
                                    @else
                                    <span class="text--small badge font-weight-normal badge--danger">
                                        @lang('No')
                                    </span>
                                    @endif
                                </td>

                                <td data-label="@lang('Action')">
                                    <button class="btn btn-sm btn-outline--primary editButton" data-action="{{ route('admin.category.store',$category->id) }}" data-id="{{ $category->id }}" data-name="{{ __($category->name) }}" data-status="{{ __($category->status) }}" data-featured="{{ __($category->featured) }}" data-images="{{ getImage(getFilePath('category').'/'. $category->image,getFileSize('category'))}}">
                                        <i class="la la-pencil"></i> @lang('Edit')
                                    </button>
                                </td>
                            </tr>
                            @empty
                                <tr>
                                    <td class="text-muted text-center" colspan="100%">{{ __($emptyMessage) }}</td>
                                </tr>
                            @endforelse

                            </tbody>
                        </table>
                    </div>
                </div>
                @if ($categories->hasPages())
                <div class="card-footer py-4">
                    {{ paginateLinks($categories) }}
                </div>
                @endif
            </div>
        </div>
    </div>
    <div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="createModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="createModalLabel"> @lang('Add New Category')</h4>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><i class="las la-times"></i></button>
                </div>
                <form class="form-horizontal" method="post" action="{{ route('admin.category.store')}}" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="row form-group">
                            <label>@lang('Name')</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" value="{{ old('name') }}" name="name" required>
                            </div>
                        </div>
                        <div class="row form-group">
                            <label>@lang('Image')<span class="text--danger">*</span></label>
                            <div class="col-sm-12">
                                <div class="image-upload">
                                    <div class="thumb">
                                        <div class="avatar-preview">
                                            <div class="profilePicPreview" style="background-image: url({{ getImage('/',getFileSize('category'))}})">
                                                <button type="button" class="remove-image"><i class="fa fa-times"></i></button>
                                            </div>
                                        </div>
                                        <div class="avatar-edit">
                                            <input type="file" class="profilePicUpload" name="image" id="profilePicUpload1" accept=".png, .jpg, .jpeg">
                                            <label for="profilePicUpload1" class="bg--primary">@lang('Upload Image')</label>
                                            <small class="mt-2 text-facebook">@lang('Supported files'):
                                                <b>@lang('jpeg'), @lang('jpg'), @lang('png').</b>
                                                @lang('Image will be resized into '){{ getFileSize('category') }} @lang('px')
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row form-group">
                            <label>@lang('Featured')</label>
                            <div class="col-sm-12">
                                <input type="checkbox" data-width="100%" data-size="large" data-onstyle="-success" data-offstyle="-danger" data-bs-toggle="toggle" data-height="50" data-on="@lang('Yes')" data-off="@lang('No')" name="featured">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn--primary w-100 h-45" id="btn-save" value="add">@lang('Submit')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="updateModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="updateModalLabel"> @lang('Update Category')</h4>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><i class="las la-times"></i></button>
                </div>
                <form class="form-horizontal" method="post" action="" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="row form-group">
                            <label>@lang('Name')</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" value="{{ old('name') }}" name="name" required>
                            </div>
                        </div>
                        <div class="row form-group">
                            <label>@lang('Image')</label>
                            <div class="col-sm-12">
                                <div class="image-upload">
                                    <div class="thumb">
                                        <div class="avatar-preview">
                                            <div class="profilePicPreview">
                                                <button type="button" class="remove-image"><i class="fa fa-times"></i></button>
                                            </div>
                                        </div>
                                        <div class="avatar-edit">
                                            <input type="file" class="profilePicUpload" name="image" id="profilePicUpload2" accept=".png, .jpg, .jpeg">
                                            <label for="profilePicUpload2" class="bg--primary">@lang('Upload Image')</label>
                                            <small class="mt-2 text-facebook">@lang('Supported files'):
                                                <b>@lang('jpeg'), @lang('jpg'), @lang('png').</b>
                                                @lang('Image will be resized into '){{ getFileSize('category') }} @lang('px')
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row form-group">
                            <label>@lang('Status')</label>
                            <div class="col-sm-12">
                                <input type="checkbox" data-width="100%" data-size="large" data-onstyle="-success" data-offstyle="-danger" data-bs-toggle="toggle" data-height="50" data-on="@lang('Enable')" data-off="@lang('Disabled')" name="status">
                            </div>
                        </div>
                        <div class="row form-group">
                            <label>@lang('Featured')</label>
                            <div class="col-sm-12">
                                <input type="checkbox" data-width="100%" data-size="large" data-onstyle="-success" data-offstyle="-danger" data-bs-toggle="toggle" data-height="50" data-on="@lang('Yes')" data-off="@lang('No')" name="featured">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn--primary w-100 h-45" id="btn-save" value="add">@lang('Submit')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('breadcrumb-plugins')
<div class="d-flex flex-colum flex-wrap gap-2 justify-content-end align-items-center">
    <a class="btn btn-lg btn-outline--primary me-2" data-bs-toggle="modal" data-bs-target="#createModal"><i class="las la-plus"></i>@lang('Add New')</a>

    <form action="" method="GET" class="form-inline float-sm-end">
        <div class="input-group justify-content-end">
            <input type="text" name="search" class="form-control bg--white" placeholder="@lang('Name')" value="{{ request()->search }}">
            <button class="btn btn--primary input-group-text" type="submit"><i class="fa fa-search"></i></button>
        </div>
    </form>
</div>
@endpush

@push('script')
<script>
    (function($) {
            "use strict"
            $('.editButton').on('click', function() {
                var modal = $('#updateModal');
                var featured = $(this).data('featured');
                var status = $(this).data('status');
                var action = $(this).data('action');
                var images = $(this).data('images');

                modal.find('form').attr('action', `${action}`);
                modal.find('input[name=name]').val($(this).data('name'));

                if ($(this).data('status') == 1) {
                    modal.find('input[name=status]').bootstrapToggle('on');
                } else {
                    modal.find('input[name=status]').bootstrapToggle('off');
                }

                if ($(this).data('featured') == 1) {
                    modal.find('input[name=featured]').bootstrapToggle('on');
                } else {
                    modal.find('input[name=featured]').bootstrapToggle('off');
                }

                modal.find('.profilePicPreview').css('background-image',`url(${images})`);
                modal.modal('show');
            });
        })(jQuery);
</script>
@endpush
