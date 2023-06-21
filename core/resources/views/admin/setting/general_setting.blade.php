@extends('admin.layouts.app')

@section('panel')
    <div class="row mb-none-30">

        <div class="col-lg-12 col-md-12 mb-30">
            <div class="card">
                <div class="card-body">
                    <form action="" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group row">
                            <div class="col-md-2">
                                <label class="font-weight-bold"> @lang('Site Title') </label>
                            </div>
                            <div class="col-md-10">
                                <input class="form-control form-control-lg" type="text" name="sitename" value="{{$general->sitename}}">
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-2">
                                <label class="font-weight-bold"> @lang('Preloader Title') </label>
                            </div>
                            <div class="col-md-10">
                                <input class="form-control form-control-lg" type="text" name="preloader_title" value="{{$general->preloader_title}}">
                                <small class="text--small text--danger">
                                    <i class="las la-info-circle"></i>
                                    @lang('Maximum 12 characters are allowed')
                                </small>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-2">
                                <label class="font-weight-bold">@lang('Currency')</label>
                            </div>
                            <div class="col-md-10">
                                <input class="form-control  form-control-lg" type="text" name="cur_text" value="{{__($general->cur_text)}}">

                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-2">
                                <label class="font-weight-bold">@lang('Currency Symbol')</label>
                            </div>
                            <div class="col-md-10">
                                <input class="form-control  form-control-lg" type="text" name="cur_sym" value="{{__($general->cur_sym)}}">
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-2">
                                <label class="font-weight-bold"> @lang('Site Base Color')</label>
                            </div>
                            <div class="col-md-10">
                                <div class="input-group">
                                    <span class="input-group-addon ">
                                        <input type='text' class="form-control  form-control-lg colorPicker"
                                            value="{{$general->base_color}}"/>
                                    </span>
                                    <input type="text" class="form-control form-control-lg colorCode" name="base_color" value="{{ $general->base_color }}"/>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-2">
                                <label class="font-weight-bold"> @lang('Site Secondary Color')</label>
                            </div>
                            <div class="col-md-10">
                                <div class="input-group">
                                <span class="input-group-addon">
                                    <input type='text' class="form-control form-control-lg colorPicker"
                                           value="{{$general->secondary_color}}"/>
                                </span>
                                    <input type="text" class="form-control form-control-lg colorCode" name="secondary_color" value="{{ $general->secondary_color }}"/>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-5">

                            <div class="col-xl-2 col-lg-4 col-sm-3">
                                <div class="form-group row">
                                    <div class="col-md-12">
                                        <label class="font-weight-bold mr-1">
                                            @lang('Cash On Delivery')
                                        </label>
                                    </div>
                                    <div class="col-md-12">
                                        <label class="switch">
                                            <input type="checkbox" name="cod" @if($general->cod) checked @endif>
                                            <span class="slider round"></span>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-2 col-lg-4 col-sm-3">
                                <div class="form-group row">
                                    <div class="col-md-12">
                                        <label class="font-weight-bold mr-1">
                                            @lang('User Registration')
                                        </label>
                                    </div>
                                    <div class="col-md-12">
                                        <label class="switch">
                                            <input type="checkbox" name="registration" @if($general->registration) checked @endif>
                                            <span class="slider round"></span>
                                        </label>
                                    </div>
                                </div>
                            </div>


                            <div class="col-xl-2 col-lg-4 col-sm-3">
                                <div class="form-group row">
                                    <div class="col-md-12">
                                        <label class="font-weight-bold">
                                            @lang('Email Verification')
                                        </label>
                                    </div>
                                    <div class="col-md-12">
                                        <label class="switch">
                                            <input type="checkbox" name="ev" @if($general->ev) checked @endif>
                                            <span class="slider round"></span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-2 col-lg-4 col-sm-3">
                                <div class="form-group row">
                                    <div class="col-md-12">
                                        <label class="font-weight-bold">
                                            @lang('Email Notification')
                                        </label>
                                    </div>
                                    <div class="col-md-12">
                                        <label class="switch">
                                            <input type="checkbox" name="en" @if($general->en) checked @endif>
                                            <span class="slider round"></span>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-2 col-lg-4 col-sm-3">
                                <div class="form-group row">
                                    <div class="col-md-12">
                                        <label class="font-weight-bold">
                                            @lang('SMS Verification')
                                        </label>
                                    </div>
                                    <div class="col-md-12">
                                        <label class="switch">
                                            <input type="checkbox" name="sv" @if($general->sv) checked @endif>
                                            <span class="slider round"></span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-2 col-lg-4 col-sm-3">
                                <div class="form-group row">
                                    <div class="col-md-12">
                                        <label class="font-weight-bold">
                                            @lang('SMS Notification')
                                        </label>
                                    </div>
                                    <div class="col-md-12">
                                        <label class="switch">
                                            <input type="checkbox" name="sn" @if($general->sn) checked @endif>
                                            <span class="slider round"></span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn--success btn-block btn-lg">@lang('Update')</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script-lib')
    <script src="{{ asset('assets/admin/js/spectrum.js') }}"></script>
@endpush

@push('style-lib')
    <link rel="stylesheet" href="{{ asset('assets/admin/css/spectrum.css') }}">
@endpush


@push('style')
    <style>
        .sp-replacer {
            padding: 0;
            border: none;
            border-radius: 5px 0 0 5px;
        }

        .sp-preview {
            width: 100px;
            height: 46px;
            border: 0;
        }

        .sp-preview-inner {
            width: 110px;
        }

        .sp-dd {
            display: none;
        }
    </style>
@endpush

@push('script')
    <script>
        "use strict";
        (function ($) {
            $('.colorPicker').spectrum({
                color: $(this).data('color'),
                change: function (color) {
                    $(this).parent().siblings('.colorCode').val(color.toHexString().replace(/^#?/, ''));
                }
            });

            $('.colorCode').on('input', function () {
                var clr = $(this).val();
                $(this).parents('.input-group').find('.colorPicker').spectrum({
                    color: clr,
                });
            });
        })(jQuery);
    </script>
@endpush

