@extends('admin.layouts.app')
@section('panel')
    <div class="row mb-none-30">
        <div class="col-lg-12 col-md-12 mb-30">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title mb-30 border-bottom pb-2"> @lang('Update Logos & Favicon From Here') </h5>
                    <form action="" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="form-group col-xl-4">
                                <label class="font-weight-bold">@lang('Logo For White Background')</label>
                                <div class="image-upload">
                                    <div class="thumb">
                                        <div class="avatar-preview">
                                            <div class="profilePicPreview logoPicPrev logoPrev" style="background-image: url({{ getImage(imagePath()['logoIcon']['path'].'/logo.png', '?'.time()) }})">
                                                <button type="button" class="remove-image"><i class="fa fa-times"></i></button>
                                            </div>
                                        </div>
                                        <div class="avatar-edit">
                                            <input type="file" class="profilePicUpload" id="profilePicUpload" accept=".png, .jpg, .jpeg" name="logo">
                                            <label for="profilePicUpload" class="bg--primary">@lang('Select Header Logo') </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group col-xl-4">
                                <label class="font-weight-bold">@lang('Logo For Dark Background')</label>
                                <div class="image-upload">
                                    <div class="thumb">
                                        <div class="avatar-preview">
                                            <div class="profilePicPreview logoPicPrev logoPrev bg--dark" style="background-image: url({{ getImage(imagePath()['logoIcon']['path'].'/logo_2.png', '?'.time()) }})">
                                                <button type="button" class="remove-image"><i class="fa fa-times"></i></button>
                                            </div>
                                        </div>
                                        <div class="avatar-edit">
                                            <input type="file" class="profilePicUpload" id="profilePicUpload1" accept=".png, .jpg, .jpeg" name="logo_2">
                                            <label for="profilePicUpload1" class="bg--primary">@lang('Select Footer Logo') </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group col-xl-4">
                                <label class="font-weight-bold">@lang('Favicon Image')</label>
                                <div class="image-upload">
                                    <div class="thumb">
                                        <div class="avatar-preview">
                                            <div class="profilePicPreview logoPicPrev iconPrev" style="background-image: url({{ getImage(imagePath()['logoIcon']['path'] .'/favicon.png', '?'.time()) }})">
                                                <button type="button" class="remove-image"><i class="fa fa-times"></i></button>
                                            </div>
                                        </div>
                                        <div class="avatar-edit">
                                            <input type="file" class="profilePicUpload" id="profilePicUpload2" accept=".png" name="favicon">
                                            <label for="profilePicUpload2" class="bg--primary">@lang('Select Favicon')</label>
                                        </div>
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

@push('style')
<style type="text/css">
    .logoPrev{
        background-size: 100%;
    }
    .iconPrev{
        background-size: 100%;
    }
</style>
@endpush
