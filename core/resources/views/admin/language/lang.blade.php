@extends('admin.layouts.app')

@section('panel')
    <div class="row">

        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive table-responsive--sm">
                        <table class="default-data-table table ">
                            <thead>
                            <tr>
                                <th>@lang('Name')</th>
                                <th>@lang('Code')</th>
                                <th>@lang('Default')</th>
                                <th>@lang('Actions')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse ($languages as $item)

                                <tr>
                                    <td data-label="@lang('Name')">
                                        <div class="user">
                                            <div class="thumb">
                                                <a href="{{ getImage($path .'/'. $item->icon,'64x64') }}" class="image-popup">
                                                    <img src="{{ getImage($path .'/'. $item->icon,'64x64') }}" alt="@lang('image')">
                                                </a>
                                            </div>

                                            <span class="name">{{ __($item->name) }}</span>
                                        </div>
                                    </td>
                                    <td data-label="@lang('Code')"><strong>{{ __($item->code) }}</strong></td>
                                    <td data-label="@lang('Status')">
                                        @if($item->is_default == 1)
                                            <span class="text--small badge font-weight-normal badge--success">@lang('Default')</span>
                                        @else
                                            <span class="text--small badge font-weight-normal badge--warning">@lang('Selectable')</span>
                                        @endif
                                    </td>
                                    <td data-label="@lang('Action')">
                                            <a href="{{route('admin.language-key', $item->id)}}" class="icon-btn btn--success" data-toggle="tooltip" data-original-title="@lang('Translate')">
                                                <i class="la la-code"></i>
                                            </a>

                                            <a href="javascript:void(0)" class="icon-btn ml-1 editBtn" data-original-title="@lang('Edit')" data-toggle="tooltip" data-url="{{ route('admin.language-manage-update', $item->id)}}" data-lang="{{ json_encode($item->only('name', 'text_align', 'is_default')) }}" data-icon="{{ getImage($path .'/'. $item->icon,'64x64')}}">
                                                <i class="la la-edit"></i>
                                            </a>


                                        @if($item->id != 1)
                                            <a href="javascript:void(0)" class="icon-btn btn--danger ml-1 deleteBtn" data-original-title="@lang('Delete')" data-toggle="tooltip" data-url="{{ route('admin.language-manage-del', $item->id) }}">
                                                <i class="la la-trash"></i>
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="text-muted text-center" colspan="100%">{{ __($empty_message) }}</td>
                                </tr>
                            @endforelse

                            </tbody>
                        </table><!-- table end -->
                    </div>
                </div>
            </div><!-- card end -->
        </div>
    </div>


    {{-- NEW MODAL --}}
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel"><i class="fa fa-share-square"></i> @lang('Agregar nuevo idioma')</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <form class="form-horizontal" method="post" action="{{ route('admin.language-manage-store')}}" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">

                        <div class="form-group row">
                            <div class="col-md-2">
                                <label class="font-weight-bold">@lang('Flag Icon') </label>
                            </div>
                            <div class="col-md-10">
                                <div class="file-upload-wrapper" data-text="@lang('Choose Flag Icon')">
                                    <input type="file" name="icon" id="customFile1" class="file-upload-field">
                                </div>
                                <div id="fileUploadsContainer"></div>
                                <small class="form-text text-muted">
                                    <i class="las la-info-circle"></i>
                                    @lang("Supported files:") @lang("png"). @lang("Image will be resized into") <b>{{ $size }}px</b>
                                </small>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-2">
                                <label class="font-weight-bold ">@lang('Name')</label>
                            </div>
                            <div class="col-md-10">
                                <input type="text" class="form-control has-error bold " id="code" name="name" placeholder="@lang('e.g. Japaneese, Portuguese')" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-2">
                                <label class="font-weight-bold">@lang('Code')</label>
                            </div>
                            <div class="col-md-10">
                                <input type="text" class="form-control has-error bold " id="link" name="code" placeholder="@lang('e.g. jp, pt-br')" required>
                            </div>
                        </div>

                        <div class="form-row form-group">
                            <div class="col-md-2">
                                <label class="font-weight-bold">@lang('Default Language')</label>
                            </div>
                            <div class="col-md-10">

                                <label class="switch">
                                    <input type="checkbox" name="is_default">
                                    <span class="slider round"></span>
                                </label>
                            </div>

                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn--dark" data-dismiss="modal">@lang('Close')</button>
                        <button type="submit" class="btn btn--primary" id="btn-save" value="add">@lang('Save')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- EDIT MODAL --}}
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel"><i class="fa fa-fw fa-share-square"></i>@lang('Edit Language')</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <form method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group row">
                            <div class="col-md-2">
                                <img class="mx-auto language-icon" width="80px">
                            </div>

                            <div class="col-md-10">
                                <div class="file-upload-wrapper" data-text="@lang('Change Flag Icon')">
                                    <input type="file" name="icon" id="customFile2" class="file-upload-field has-error">
                                </div>
                                <div id="fileUploadsContainer"></div>
                                <small class="form-text text-muted">
                                    <i class="las la-info-circle"></i>
                                    @lang("Supported files:") @lang("png"). @lang("Image will be resized into") <b>{{ $size }}px</b>
                                </small>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-2">
                                <label for="inputName" class="font-weight-bold">@lang('Name')</label>
                            </div>
                            <div class="col-md-10">
                                <input type="text" class="form-control has-error bold " id="code" name="name" required>
                            </div>
                        </div>

                        <div class="form-row form-group">
                            <div class="col-md-2">
                                <label class="font-weight-bold">@lang('Default Language')</label>
                            </div>
                            <div class="col-md-10">
                                <label class="switch">
                                    <input type="checkbox" name="default">
                                    <span class="slider round"></span>
                                </label>
                            </div>

                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn--dark" data-dismiss="modal">@lang('Close')</button>
                        <button type="submit" class="btn btn--primary" id="btn-save" value="add">@lang('Update')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- DELETE MODAL --}}
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">@lang('Confirmation Alert')</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <form method="post" action="" >
                    @csrf
                    {{method_field('delete')}}
                    <input type="hidden" name="delete_id" id="delete_id" class="delete_id" value="0">
                    <div class="modal-body">
                        <p class="text-muted">@lang('Are you sure to Delete ?')</p>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn--dark" data-dismiss="modal">@lang('No')</button>
                        <button type="submit" class="btn btn--danger deleteButton">@lang('Yes')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection


@push('breadcrumb-plugins')
    <a class="btn btn-sm btn--primary box--shadow1 text-white text--small" data-toggle="modal" data-target="#myModal" ><i class="la la-plus"></i>@lang('Agregar nuevo idioma')</a>
@endpush

@push('script')
    <script>
        "use strict";
        (function($){

            $('.image-popup').magnificPopup({
                type: 'image'
            });

            $('.editBtn').on('click', function () {
                var modal = $('#editModal');
                var url = $(this).data('url');
                var icon = $(this).data('icon');
                var lang = $(this).data('lang');

                modal.find('form').attr('action', url);
                modal.find('.language-icon').attr('src',icon);
                modal.find('input[name=name]').val(lang.name);
                modal.find('select[name=text_align]').val(lang.text_align);
                if (lang.is_default == 1) {
                    modal.find('input[name=default]').attr('checked', 'checked');
                } else {
                    modal.find('input[name=default]').removeAttr('checked');
                }
                modal.modal('show');
            });

            $('.deleteBtn').on('click', function () {
                var modal = $('#deleteModal');
                var url = $(this).data('url');

                modal.find('form').attr('action', url);
                modal.modal('show');
            });
        })(jQuery);
    </script>
@endpush
