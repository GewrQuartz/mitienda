@extends('admin.layouts.app')

@section('panel')
    <div class="row mb-none-30">
        <div class="col-xl-3 col-lg-5 col-md-5 mb-30">

            <div class="card b-radius--10 overflow-hidden box--shadow1">
                <div class="card-body">
                    <div class="mb-3">
                        <img src="{{ getAvatar('assets/images/user/profile/'. $user->image)}}" alt="@lang('profile-image')" class="b-radius--10 w-100">
                    </div>
                </div>
            </div>

            <div class="card mt-30">
                <div class="card-body">
                    <h5 class="mb-20 text-muted">@lang('Customer Information')</h5>

                    <ul class="list-group">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            @lang('Name')
                            <span class="font-weight-bold">{{$user->fullname}}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            @lang('Username')
                            <span class="font-weight-bold">{{$user->username}}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            @lang('Status')
                            @switch($user->status)
                                @case(1)
                                <span class="badge badge--success font-weight-normal text--small">@lang('Active')</span>
                                @break
                                @case(0)
                                <span class="badge badge--danger font-weight-normal text--small">@lang('Banned')</span>
                                @break
                            @endswitch
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            @lang('Joined')
                            <span class="font-weight-bold">{{showDateTime($user->created_at,'d M, Y h:i A')}}</span>
                        </li>

                    </ul>
                </div>
            </div>

            <div class="card b-radius--10 overflow-hidden mt-30 box--shadow1">
                <div class="card-body">
                    <h5 class="mb-20 text-muted">@lang('Customer Action')</h5>

                    <a href="{{ route('admin.users.login.history.single', $user->id) }}"
                       class="btn btn--primary btn--shadow btn-block btn-lg">
                        @lang('Login Logs')
                    </a>
                    <a href="{{route('admin.users.email.single',$user->id)}}"
                       class="btn btn--danger btn--shadow btn-block btn-lg">
                        @lang('Send Email')
                    </a>
                </div>
            </div>
        </div>

        <div class="col-xl-9 col-lg-7 col-md-7 mb-30">

            <div class="row mb-none-30">
                <div class="col-xl-4 col-md-12 col-sm-12 mb-30">
                    <div class="widget bb--3 border--cyan b-radius--10 bg--white p-4 box--shadow2 has--link">
                        <a href="{{route('admin.users.deposits',$user->id)}}" class="item--link"></a>
                        <div class="widget__icon b-radius--rounded bg--cyan"><i class="fa fa-credit-card"></i></div>
                        <div class="widget__content">
                            <p class="text-uppercase text-muted">@lang('Total Shopping')</p>
                            <h2 class="text--cyan font-weight-bold">{{$general->cur_sym}}{{number_format($totalDeposit, 2)}}</h2>

                        </div>
                        <div class="widget__arrow">
                            <i class="fas fa-chevron-right"></i>
                        </div>
                    </div>
                </div>

                <div class="col-xl-4 col-md-12 col-sm-12 mb-30">
                    <div class="widget bb--3 border--info b-radius--10 bg--white p-4 box--shadow2 has--link">
                        <a href="{{route('admin.users.transactions',$user->id)}}" class="item--link"></a>
                        <div class="widget__icon b-radius--rounded bg--info"><i class="la la-exchange-alt"></i></div>
                        <div class="widget__content">
                            <p class="text-uppercase text-muted">@lang('Total Transactions')</p>
                            <h2 class="text--info font-weight-bold">{{$totalTransaction}}</h2>

                        </div>
                        <div class="widget__arrow">
                            <i class="fas fa-chevron-right"></i>
                        </div>
                    </div>
                </div>

                <div class="col-xl-4 col-md-12 col-sm-12 mb-30">
                    <div class="widget bb--3 border--indigo b-radius--10 bg--white p-4 box--shadow2 has--link">
                        <a href="{{route('admin.report.order.user',$user->id)}}" class="item--link"></a>
                        <div class="widget__icon b-radius--rounded bg--indigo"><i class="la la-shopping-basket"></i></div>
                        <div class="widget__content">
                            <p class="text-uppercase text-muted">@lang('Total Orders')</p>
                            <h2 class="text--indigo font-weight-bold">{{ $totalOrders }}</h2>

                        </div>
                        <div class="widget__arrow">
                            <i class="fas fa-chevron-right"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mt-30">
                <div class="card-body">
                    <h5 class="card-title mb--20 border-bottom pb-2">{{$user->fullname}} @lang('Information')</h5>
                    <form action="{{route('admin.users.update',[$user->id])}}" method="POST" enctype="multipart/form-data" class="mt-4">
                        @csrf
                        <div class="form-group row">
                            <div class="col-md-12 col-lg-3 col-xl-2">
                                <label class="form-control-label font-weight-bold">@lang('First Name')
                                </label>
                            </div>
                            <div class="col-md-12 col-lg-9 col-xl-10">
                                <input class="form-control" type="text" name="firstname" value="{{$user->firstname}}" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-12 col-lg-3 col-xl-2">
                                <label class="form-control-label  font-weight-bold">@lang('Last Name')</label>
                            </div>
                            <div class="col-md-12 col-lg-9 col-xl-10">
                                <input class="form-control" type="text" name="lastname" value="{{$user->lastname}}" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-12 col-lg-3 col-xl-2">
                                <label class="form-control-label font-weight-bold">@lang('Email')</label>
                            </div>
                            <div class="col-md-12 col-lg-9 col-xl-10">
                                <input class="form-control" type="email" name="email" value="{{$user->email}}" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-12 col-lg-3 col-xl-2">
                                <label class="form-control-label font-weight-bold">@lang('Mobile')</label>
                            </div>
                            <div class="col-md-12 col-lg-9 col-xl-10">
                                <input class="form-control" type="text" name="mobile" value="{{$user->mobile}}" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-12 col-lg-3 col-xl-2">
                                <label class="form-control-label font-weight-bold">@lang('Address') </label>
                            </div>
                            <div class="col-md-12 col-lg-9 col-xl-10">
                                <input class="form-control" type="text" name="address" value="{{$user->address->address}}">
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-12 col-lg-3 col-xl-2">
                                <label class="form-control-label font-weight-bold">@lang('City') </label>
                            </div>
                            <div class="col-md-12 col-lg-9 col-xl-10">
                                <input class="form-control" type="text" name="city" value="{{$user->address->city}}">
                            </div>
                        </div>

                        <dv class="form-group row">
                            <div class="col-md-12 col-lg-3 col-xl-2">
                                <label class="form-control-label font-weight-bold">@lang('State') </label>
                            </div>
                            <div class="col-md-12 col-lg-9 col-xl-10">
                                <input class="form-control" type="text" name="state" value="{{$user->address->state}}">
                            </div>
                        </dv>

                        <div class="form-group row">
                            <div class="col-md-12 col-lg-3 col-xl-2">
                                <label class="form-control-label font-weight-bold">@lang('Zip/Post Code') </label>
                            </div>
                            <div class="col-md-12 col-lg-9 col-xl-10">
                                <input class="form-control" type="text" name="zip" value="{{$user->address->zip}}">
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-12 col-lg-3 col-xl-2">
                                <label class="form-control-label font-weight-bold">@lang('Country') </label>
                            </div>
                            <div class="col-md-12 col-lg-9 col-xl-10">
                                <select name="country" class="form-control"> @include('partials.country') </select>
                            </div>
                        </div>

                        <div class="row justify-content-end">
                            <div class="col-md-12 col-lg-9 col-xl-10">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="form-group row">
                                            <div class="col-md-12">
                                                <label class="font-weight-bold">
                                                    @lang('Status')
                                                </label>
                                            </div>
                                            <div class="col-md-12">
                                                <label class="switch">
                                                    <input type="checkbox" name="status" value="1" @if(isset($user)) {{ $user->status?'checked':'' }}  @endif>
                                                    <span class="slider round"></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-4">
                                        <div class="form-group row">
                                            <div class="col-md-12">
                                                <label class="font-weight-bold">
                                                    @lang('Email Verification')
                                                </label>
                                            </div>
                                            <div class="col-md-12">
                                                <label class="switch">
                                                    <input type="checkbox" name="ev" value="1" @if(isset($user)) {{ $user->ev?'checked':'' }}  @endif>
                                                    <span class="slider round"></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-4">
                                        <div class="form-group row">
                                            <div class="col-md-12">
                                                <label class="font-weight-bold">
                                                    @lang('SMS Verification')
                                                </label>
                                            </div>
                                            <div class="col-md-12">
                                                <label class="switch">
                                                    <input type="checkbox" name="sv" value="1" @if(isset($user)) {{ $user->sv?'checked':'' }}  @endif>
                                                    <span class="slider round"></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <button type="submit" class="btn btn--primary btn-block btn-lg">@lang('Save Changes')
                                    </button>
                                </div>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        'use strict';
        (function($){
            $("select[name=country]").val("{{ @$user->address->country }}");
        })(jQuery)
    </script>
@endpush
