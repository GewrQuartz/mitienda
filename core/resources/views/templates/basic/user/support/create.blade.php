@extends($activeTemplate.'layouts.master')

@section('content')
<div class="account-section padding-bottom padding-top">
    <div class="container">
        <div class="row justify-content-center mt-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-3 text-white">{{ __($page_title) }}
                        <a href="{{route('ticket') }}" class="cmn-btn-2 btn-sm float-right">
                            <i class="la la-backward"></i>
                            @lang('Back')
                        </a>
                    </div>

                    <div class="card-body">

                        <form  action="{{route('ticket.store')}}" method="post" enctype="multipart/form-data" onsubmit="return submitUserForm();" class="contact-form">
                            @csrf
                            <div class="row">
                                <div class="form-group col-lg-6">
                                    <label for="name">@lang('Name')</label>
                                    <input type="text" class="form-control rounded-0" id="name" name="name" value="{{@$user->firstname . ' '.@$user->lastname}}" placeholder="@lang('Enter Name')" required>
                                </div>

                                <div class="form-group col-lg-6">
                                    <label for="email">@lang('Email')</label>
                                    <input type="email" class="form-control rounded-0" id="email" name="email" value="{{@$user->email}}" placeholder="@lang('Enter your Email')" required>
                                </div>

                                <div class="form-group col-lg-12">
                                    <label for="website">@lang('Subject')</label>
                                    <input type="text" class="form-control rounded-0" id="subject" name="subject" value="{{old('subject')}}" placeholder="@lang('Subject')" >
                                </div>

                                <div class="col-12 form-group">
                                    <label for="inputMessage">@lang('Message')</label>
                                    <textarea name="message" id="inputMessage" rows="6">{{old('message')}}</textarea>
                                </div>
                            </div>

                            <div class="row justify-content-between">
                                <div class="col-md-12">
                                    <label for="inputAttachments" class="font-weight-bold">@lang('Attachments')</label>
                                    <div class="form-group custom-file">
                                        <input type="file" name="attachments[]" id="customFile" class="custom-file-input"/>
                                        <label class="custom-file-label" for="customFile">@lang('Choose file')</label>
                                    </div>
                                    <div id="fileUploadsContainer"></div>

                                    <p class="my-2 ticket-attachments-message text-muted">
                                        @lang("Allowed File Extensions: .jpg, .jpeg, .png, .pdf")
                                    </p>
                                </div>
                            </div>
                            <a href="javascript:void(0)" class="cmn-btn-2 btn-sm mt-4 add-more-btn">
                                <i class="la la-plus"></i>
                            </a>
                            <div class="d-flex justify-content-between mt-3">
                                <button class="btn btn-sm btn-danger h-unset" type="button" onclick="formReset()">&nbsp;@lang('Cancel')</button>

                                <button class="cmn-btn btn-success" type="submit" id="recaptcha" ></i>&nbsp;@lang('Submit')</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
    <script>

        "use strict";
        (function ($) {

            $(document).on("change", '.custom-file-input' ,function() {
                var fileName = $(this).val().split("\\").pop();
                $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
            });

            var itr = 0;

            $('.add-more-btn').on('click', function(){
                itr++
                $("#fileUploadsContainer").append(` <div class="form-group custom-file mt-3">
                                            <input type="file" name="attachments[]" id="customFile${itr}" class="custom-file-input"/>
                                            <label class="custom-file-label" for="customFile${itr}">@lang('Choose file')</label>
                                        </div>`);

            })
        })(jQuery);

        function formReset() {
            window.location.href = "{{url()->current()}}"
        }
    </script>
@endpush


@push('breadcrumb-plugins')
<li><a href="{{route('user.home')}}">@lang('Dashboard')</a></li>
<li><a href="{{route('ticket')}}">@lang('Support Tickets')</a></li>
@endpush
