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
                    <h5 class="card-title mb-50 border-bottom pb-2">@lang('Change Password')</h5>

                    <form action="{{ route('admin.password.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group row">
                            <label class="col-lg-3 font-weight-bold">@lang('Password')</label>
                            <div class="col-lg-9">
                                <input class="form-control" type="password" name="old_password">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-3 font-weight-bold">@lang('New password')</label>
                            <div class="col-lg-9">
                                <input class="form-control" type="password" name="password">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-3 font-weight-bold">@lang('Confirm password')</label>
                            <div class="col-lg-9">
                                <input class="form-control" type="password" name="password_confirmation">
                            </div>
                        </div>
                        <div class="form-group row justify-content-end">
                            <div class="col-lg-9">
                            <button type="submit" class="btn btn--primary btn-block btn-lg">@lang('Save Changes')</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('breadcrumb-plugins')
    <a href="{{route('admin.profile')}}" class="btn btn-sm btn--primary box--shadow1 text--small" ><i class="fa fa-user"></i>@lang('Profile Setting')</a>
@endpush
