@extends($activeTemplate.'layouts.master')

@section('content')
<div class="account-section padding-bottom padding-top">

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card rounded-0">
                    <div class="card-header bg-3 d-flex flex-wrap justify-content-between align-items-center">
                        <h5 class="card-title mt-0 text-white">
                            @if($my_ticket->status == 0)
                                <span class="text--small font-weight-normal badge badge--success">@lang('Open')</span>
                            @elseif($my_ticket->status == 1)
                                <span class="text--small font-weight-normal badge badge--primary">@lang('Answered')</span>
                            @elseif($my_ticket->status == 2)
                                <span class="text--small font-weight-normal badge badge--warning">@lang('Replied')</span>
                            @elseif($my_ticket->status == 3)
                                <span class="text--small font-weight-normal badge badge-dark">@lang('Closed')</span>
                            @endif
                            [@lang('Ticket')#{{ $my_ticket->ticket }}] {{ $my_ticket->subject }}
                        </h5>
                        <button class="btn btn-sm btn-danger close-button h-unset" type="button" title="@lang('Close Ticket')" data-toggle="modal" data-target="#DelModal">
                                <i class="la la-times"></i>
                        </button>
                    </div>

                    <div class="card-body ">
                        @if($my_ticket->status != 4)
                            <form method="post" action="{{ route('ticket.reply', $my_ticket->id) }}" enctype="multipart/form-data">
                                @csrf
                                <div class="row justify-content-between">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <textarea name="message" class="form-control form-control-lg" id="inputMessage" placeholder="@lang('Your Reply') ..." rows="4" cols="10"></textarea>
                                        </div>
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
                                            @lang("Allowed File Extensions: .png, .jpg, .jpeg, .pdf, .doc, .docx")
                                        </p>
                                    </div>

                                </div>
                                <a href="javascript:void(0)" class="cmn-btn-2 btn-sm mt-4 add-more-btn">
                                    <i class="la la-plus"></i>
                                </a>

                                <div class="text-right">
                                    <button type="submit" class="cmn-btn " name="replayTicket" value="1">
                                        <i class="la la-reply"></i> @lang('Reply')
                                    </button>
                                </div>

                            </form>
                        @endif
                    </div>
                </div>

                <div class="card mt-4 rounded-0">
                    <div class="card-body ">
                        @foreach($messages as $message)
                            @if($message->admin_id == 0)
                                <div class="row user-support-ticket">
                                    <div class="col-md-3 border-right text-right">
                                        <h5 class="my-3">{{ $message->ticket->name }}</h5>
                                    </div>

                                    <div class="col-md-9">
                                        <p class="text-muted font-weight-bold my-3">
                                            @lang('Posted on') {{ $message->created_at->format('l, dS F Y @ H:i') }}</p>
                                        <p>{{$message->message}}</p>
                                        @if($message->attachments()->count() > 0)
                                            <div class="mt-2">
                                                @foreach($message->attachments as $k=> $attachment)
                                                    <a href="{{route('ticket.download',encrypt($attachment->id))}}" class="mr-3"><i class="fa fa-file"></i>  @lang('Attachment') {{++$k}} </a>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @else
                                <div class="row admin-support-ticket">
                                    <div class="col-md-3 border-right text-right">
                                        <h5 class="my-3">{{ $message->admin->name }}</h5>
                                        <p class="lead text-muted">@lang('Staff')</p>
                                    </div>
                                    <div class="col-md-9">
                                        <p class="text-muted font-weight-bold my-3">
                                            @lang('Posted on') {{ $message->created_at->format('l, dS F Y @ H:i') }}</p>
                                        <p>{{$message->message}}</p>

                                        @if($message->attachments()->count() > 0)
                                            <div class="mt-2">
                                                @foreach($message->attachments as $k=> $attachment)
                                                    <a href="{{route('ticket.download',encrypt($attachment->id))}}" class="mr-3"><i class="fa fa-file"></i>  @lang('Attachment') {{++$k}} </a>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>

                                </div>
                            @endif
                        @endforeach



                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<div class="modal fade" id="DelModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog  modal-dialog-centered">
        <div class="modal-content">

            <form method="post" action="{{ route('ticket.reply', $my_ticket->id) }}">
                @csrf

                <div class="modal-header">
                    <h5 class="modal-title"> @lang('Confirmation')!</h5>

                    <button type="button" class="close close-button" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <strong class="text-dark">@lang('Are you sure you want to close this ticket')?</strong>
                </div>
                <div class="modal-footer">

                    <button type="button" class="btn btn-dark h-unset" data-dismiss="modal"><i class="fa fa-times"></i>
                        @lang('No')
                    </button>

                    <button type="submit" class="cmn-btn" name="replayTicket" value="2"><i class="fa fa-check"></i> @lang("Yes")
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>
@endsection

@push('script')
    <script>
        "use strict";
        (function ($) {
            $('.delete-message').on('click', function (e) {
                $('.message_id').val($(this).data('id'));
            });

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


    </script>
@endpush


@push('breadcrumb-plugins')
<li><a href="{{route('user.home')}}">@lang('Dashboard')</a></li>
<li><a href="{{route('ticket')}}">@lang('Support Tickets')</a></li>
@endpush
