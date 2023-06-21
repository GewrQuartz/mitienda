@extends('admin.layouts.app')

@section('panel')

    <div class="row">

        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive table-responsive-xl">
                        <table class=" table align-items-center table--light">
                            <thead>
                            <tr>
                                <th>@lang('Short Code') </th>
                                <th>@lang('Description')</th>
                            </tr>
                            </thead>
                            <tbody class="list">
                            <tr>
                                <td>@{{name}}</td>
                                <td>@lang('User Name')</td>
                            </tr>
                            <tr>
                                <td>@{{message}}</td>
                                <td>@lang('Message')</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>



        <div class="col-lg-12">
            <div class="card mt-5">
                <form action="{{ route('admin.email_template.global') }}" method="POST">
                    @csrf
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-2">
                                <label class="font-weight-bold">@lang('From')</label>
                            </div>
                            <div class="col-md-10">
                                <input type="text" class="form-control form-control-lg" placeholder="@lang('Email Address')" name="email_from" value="{{ $general_setting->email_from }}"  required/>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-2">
                                <label class="font-weight-bold">@lang('Email Body')</label>
                            </div>
                            <div class="col-md-10">
                                <textarea name="email_template" rows="10" class="form-control form-control-lg nicEdit" placeholder="@lang('Your Email Template')">{{ $general_setting->email_template }}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-block btn--primary mr-2">@lang('Update')</button>
                    </div>
                </form>
            </div><!-- card end -->
        </div>


    </div>

@endsection


