@extends('admin.layouts.app')

@section('panel')

    <div class="row mb-none-30">
        <div class="col-xl-4 col-lg-5 mb-30">
            <div class="card b-radius--5 overflow-hidden">
                <div class="card-body">
                    <div class="avatar avatar--lg text-center mb-4">
                        <img src="{{ getImage('assets/admin/images/profile/'. $admin->image)}}" class="w-50 h-auto" alt="profile-image">
                    </div>
                    <ul class="list-group">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            @lang('Name')
                            <span class="font-weight-bold">{{$admin->name}}</span>
                        </li>

                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            @lang('Username')
                            <span  class="font-weight-bold">{{$admin->username}}</span>
                        </li>

                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            @lang('Email')
                            <span  class="font-weight-bold">{{$admin->email}}</span>
                        </li>

                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            @lang('Last Update')
                            <span  class="font-weight-bold">{{showDateTime($admin->updated_at,'d M, Y h:i A')}}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            @lang('Joined')
                            <span  class="font-weight-bold">{{showDateTime($admin->created_at,'d M, Y h:i A')}}</span>
                        </li>

                    </ul>
                </div>
            </div>
        </div>
        <div class="col-xl-8 col-lg-7 mb-30">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title mb-50 border-bottom pb-2">@lang('Profile Information')</h5>

                    <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group row">
                            <div class="col-lg-3 col-xl-2">
                                <label for="profilePicUpload1" class="font-weight-bold">@lang('Image')</label>
                            </div>
                            <div class="col-lg-9 col-xl-10">
                                <div class="payment-method-item">
                                    <div class="payment-method-header d-flex flex-wrap">
                                        <div class="thumb">
                                            <div class="avatar-preview">
                                                <div class="profilePicPreview" style="background-image: url('{{ getImage('assets/admin/images/profile/'. auth()->guard('admin')->user()->image, '400x400') }}')"></div>
                                            </div>
                                            <div class="avatar-edit">
                                                <input type="file" name="image" class="profilePicUpload" id="image" accept=".png, .jpg, .jpeg"/>
                                                <label for="image" class="bg--primary"><i class="la la-pencil"></i></label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-lg-3 col-xl-2">
                                <label class="form-control-label font-weight-bold">@lang('Name')</label>
                            </div>
                            <div class="col-lg-9 col-xl-10">
                                <input class="form-control" type="text" name="name" value="{{ auth()->guard('admin')->user()->name }}" >
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-lg-3 col-xl-2">
                                <label class="form-control-label  font-weight-bold">@lang('Email')</label>
                            </div>
                            <div class="col-lg-9 col-xl-10">
                                <input class="form-control" type="email" name="email" value="{{ auth()->guard('admin')->user()->email }}" >
                            </div>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn--primary btn-block btn-lg">@lang('Save Changes')</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('breadcrumb-plugins')
    <a href="{{route('admin.password')}}" class="btn btn-sm btn--primary box--shadow1 text--small" ><i class="fa fa-key"></i>@lang('Password Setting')</a>
@endpush
