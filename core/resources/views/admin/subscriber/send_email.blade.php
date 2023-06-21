@extends('admin.layouts.app')

@section('panel')
    <div class="row">

        <div class="col-xl-12">
            <div class="card">
                <form action="{{ route('admin.subscriber.sendEmail', @request()->id) }}" method="POST">
                    @csrf
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-2">
                                <label class="font-weight-bold">@lang('Subject')</label>
                            </div>
                            <div class="col-md-10">
                                <input type="text" class="form-control" placeholder="@lang('Email Subject')" name="subject" value="{{ old('subject') }}" />
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-2">
                                <label class="font-weight-bold">@lang('Email Body')</label>
                            </div>
                            <div class="col-md-10">
                                <textarea name="body" rows="10" class="form-control nicEdit" placeholder="@lang('Your Email Template')">{{ old('body') }}</textarea>
                            </div>
                        </div>

                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-block btn--primary "><i class="fa fa-fw fa-paper-plane"></i>@lang('Send Mail')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('breadcrumb-plugins')
    <a href="{{ route('admin.subscriber.index') }}" class="btn btn-sm btn--primary box--shadow1 text--small"><i class="fa fa-fw fa-backward"></i> @lang('Go Back')</a>
@endpush
