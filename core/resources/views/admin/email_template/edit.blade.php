@extends('admin.layouts.app')

@section('panel')
    <div class="row">

        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class=" table align-items-center table--light">
                            <thead>
                            <tr>
                                <th>@lang('Short Code')</th>
                                <th>@lang('Description')</th>
                            </tr>
                            </thead>
                            <tbody class="list">
                            @forelse($email_template->shortcodes as $shortcode => $key)
                                <tr>
                                    <th>@php echo "{{". $shortcode ."}}"  @endphp</th>
                                    <td>{{ $key }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="100%" class="text-muted text-center">@lang('No shortcode available')</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div><!-- card end -->
        </div>
        <div class="col-lg-12">
            <div class="card mt-5">
                <div class="card-header bg--dark">
                    <h5 class="card-title text-white">{{ $page_title }}</h5>
                </div>
                <form action="{{ route('admin.email-template.update', $email_template->id) }}" method="POST">
                    @csrf
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-2">
                                <label class="font-weight-bold">@lang('Subject') <span class="text-danger">*</span></label>
                            </div>
                            <div class="col-md-10">
                                <input type="text" class="form-control form-control-lg" placeholder="@lang('Email subject')" name="subject" value="{{ $email_template->subj }}"/>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-2">
                                <label class="font-weight-bold">@lang('Message') <span class="text-danger">*</span></label>
                            </div>
                            <div class="col-md-10">
                                <textarea name="email_body" rows="10" class="form-control nicEdit" placeholder="@lang('Your message using shortcodes')">{{ $email_template->email_body }}</textarea>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-2">
                                <label class="font-weight-bold">
                                    @lang('Status')
                                </label>
                            </div>
                            <div class="col-md-10">
                                <label class="switch">
                                    <input type="checkbox" name="email_status" value="1" @if($email_template->email_status) checked @endif  >
                                    <span class="slider round"></span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-block btn--primary mr-2">@lang('Submit')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection


@push('breadcrumb-plugins')
    <a href="{{ route('admin.email-template.index') }}" class="btn btn-sm btn--primary box--shadow1 text--small"><i
            class="la la-backward"></i> @lang('Go Back') </a>
@endpush

