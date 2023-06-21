@extends($activeTemplate.'layouts.master')

@section('content')

<!-- Cart Section Starts Here -->
<div class="user-profile-section padding-top padding-bottom">
    <div class="container">
        <div class="row">
            <div class="col-xl-3">
                <div class="dashboard-menu">
                    @include($activeTemplate.'user.partials.dp')
                    <ul>
                        @include($activeTemplate.'user.partials.sidebar')
                    </ul>
                </div>
            </div>
            <div class="col-xl-9">
                <div class="checkout-area section-bg">
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="user-profile">
                                <div class="thumb">
                                    <img id="imagePreview" src="{{ getAvatar(imagePath()['user_profile']['path'].'/'.$user->image ) }}" alt="@lang('user')">
                                    <label for="file-input" class="file-input-btn">
                                        <i class="la la-edit"></i>
                                    </label>
                                </div>
                                <div class="content">
                                    <h5 class="title">{{ $user->fullname }}</h5>
                                    <span>@lang('Username'): {{ $user->username }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-8">
                            <form action="" method="post" enctype="multipart/form-data" class="user-profile-form row mb--20">
                                @csrf
                                <input type='file' class="d-none" name="image" id="file-input" accept=".png, .jpg, .jpeg" />

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>@lang('First Name')</label>
                                        <input class="form-control custom--style" type="text" name="firstname" value="{{ $user->firstname}}" placeholder="@lang('Last Name')">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>@lang('Last Name')</label>
                                        <input class="form-control custom--style" type="text" name="lastname" value="{{ $user->lastname}}" placeholder="@lang('Last Name')">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>@lang('Email')</label>
                                        <input class="form-control custom--style" type="email" name="email" value="{{ $user->email}}" placeholder="@lang('Last Name')" readonly>
                                    </div>
                                </div>


                                <div class="col-md-6">
                                    <label for="country" class="billing-label">@lang('Country')</label>
                                    <div class="billing-select">
                                        <select name="country" id="country" class="select-bar">
                                            @include('partials.country')
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>@lang('City')</label>
                                        <input class="form-control custom--style" type="text" name="city" value="{{ @$user->address->city}}" placeholder="@lang('City')">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>@lang('State')</label>
                                        <input class="form-control custom--style" type="text" name="state" value="{{ @$user->address->state}}" placeholder="@lang('State')">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>@lang('Zip')</label>
                                        <input class="form-control custom--style" type="text" name="zip" value="{{ @$user->address->zip}}" placeholder="@lang('Zip')">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>@lang('Mobile')</label>
                                        <input class="form-control custom--style" type="text" name="mobile" value="{{ $user->mobile}}" placeholder="@lang('Cell No.')" readonly>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>@lang('Address')</label>
                                        <textarea class="form-control custom--style" name="address" rows="3">{{ @$user->address->address}}</textarea>
                                    </div>
                                </div>
                                <div class="col-lg-6 ml-auto text-right mb-20">
                                    <button type="submit" class="bill-button w-unset">@lang('Update Profile')</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Cart Section Ends Here -->

@endsection


@push('script')
    <script>
        'use strict';
        (function($){
            $('select[name=country]').val("{{  @$user->address->country }}");

            $("#file-input").on('change',function() {
                readURL(this);
            });

            function readURL(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        $('#imagePreview').attr('src', e.target.result);
                        $('#imagePreview').hide();
                        $('#imagePreview').fadeIn(650);
                    }
                    reader.readAsDataURL(input.files[0]);
                }
            }
        })(jQuery)

    </script>
@endpush


@push('breadcrumb-plugins')
    <li><a href="{{route('user.home')}}">@lang('Dashboard')</a></li>
@endpush
