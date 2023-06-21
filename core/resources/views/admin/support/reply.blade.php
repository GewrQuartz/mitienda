@extends('admin.layouts.app')

@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card p-3">
                <div class="card-header card-header-bg d-flex flex-wrap justify-content-between align-items-center">
                    <h6 class="card-title mt-0">

                        @if($ticket->status == 0)
                            <span class="text--small badge font-weight-normal badge--success py-1">@lang('Open')</span>
                        @elseif($ticket->status == 1)
                            <span class="text--small badge font-weight-normal badge--primary py-1">@lang('Answered')</span>
                        @elseif($ticket->status == 2)
                            <span
                                class="text--small badge font-weight-normal badge--warning py-1">@lang('Customer Reply')</span>
                        @elseif($ticket->status == 3)
                            <span class="text--small badge font-weight-normal badge--dark py-1">@lang('Closed')</span>
                        @endif
                        [@lang('Ticket')#{{ $ticket->ticket }}] {{ __($ticket->subject) }}

                    </h6>
                    <button class="btn btn--dark close-button" type="button" data-toggle="modal" data-target="#DelModal"><i class="las la-times"></i> @lang('Close Ticket')</button>
                </div>
                <div class="card-body ">
                    <form action="{{ route('admin.ticket.reply', $ticket->id) }}" enctype="multipart/form-data" method="post" class="form-horizontal">
                        @csrf

                        <div class="form-group">
                            <textarea class="form-control" name="message" rows="3" id="inputMessage" placeholder="@lang('Your Message ...')"></textarea>
                        </div>

                        <div class="form-group">
                            <label for="inputAttachments">@lang('Attachments')</label>

                            <div class="file-upload-wrapper" data-text="Select your file!">
                                <input type="file" name="attachments[]" id="inputAttachments"
                                class="file-upload-field"/>
                            </div>

                            <div id="fileUploadsContainer"></div>
                            <div class="ticket-attachments-message text-muted text--small my-2">
                                @lang('Allowed File Extensions:') @lang('.jpg, .jpeg, .png, .pdf'),
                            </div>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="javascript:void(0)" class="btn btn--primary add-more">
                                <i class="la la-plus"></i> @lang('Add More')
                            </a>

                            <button type="submit" class="btn btn--success" name="replayTicket" value="1">
                                <i class="la la-reply"></i> @lang('Reply')
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-12 mt-3">
            <div class="card p-3">
                <div class="card-header">
                    <h5 class="card-title">@lang('All messages')</h5>
                </div>
                <div class="card-body">
                    @foreach($messages as $message)
                    @if($message->admin_id == 0)
                        <div class="single-answer from__client box--shadow1 mt-30">

                            <div class="single-answer__header bg--dark">
                                <div class="left">
                                    <h5>
                                        @if($ticket->owner_id != null)
                                            <p class="d-inline"><a href="{{route('admin.users.detail', $ticket->owner_id)}}" class="text--cyan">&#64;{{ $ticket->name }}</a></p>
                                        @else
                                            <p class="d-inline text--cyan">&#64;{{ $ticket->name }}</p>
                                        @endif
                                        <p class="d-inline text--cyan"> - {{ diffForHumans($message->created_at) }}</p>
                                    </h5>
                                </div>

                                <div class="right">
                                    <button data-id="{{$message->id}}" type="button" data-toggle="modal" data-target="#DelMessage" class="btn btn-danger btn-sm delete-message"><i class="la la-trash mr-0"></i></button>
                                </div>
                            </div>

                            <div class="single-answer__body">
                                <p>{{ $message->message }}</p>

                                @if($message->attachments()->count() > 0)
                                    <div class="my-3 d-flex flex-wrap">
                                        @foreach($message->attachments as $image)
                                            <a href="{{route('admin.ticket.download',encrypt($image->id))}}" class="mr-3"><i class="fa fa-file fa-2x text--amber"></i> @lang('Attachment') {{ $loop->iteration }} </a>
                                        @endforeach
                                    </div>
                                @endif
                            </div>

                        </div>
                    @else
                        <div class="single-answer from__admin box--shadow1 mt-30">

                            <div class="single-answer__header bg--primary">
                                <div class="left">
                                    <p class="d-inline text-white">{{ $message->admin->name }}</p>
                                    <p class="d-inline text-white-50"> - {{ diffForHumans($message->created_at) }}</p>
                                </div>
                                <div class="right">
                                    <button data-id="{{$message->id}}" type="button" data-toggle="modal" data-target="#DelMessage" class="btn btn-danger btn-sm delete-message"><i class="la la-trash mr-0"></i></button>
                                </div>
                            </div>

                            <div class="single-answer__body">
                                <p>{{ $message->message }}</p>
                                @if($message->attachments()->count() > 0)
                                    <div class="my-3">
                                        @foreach($message->attachments as $k=> $image)
                                            <a href="{{route('admin.ticket.download',encrypt($image->id))}}" class="mr-3"><i class="fa fa-file fa-2x text--amber"></i>  @lang('Attachment') {{++$k}} </a>
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




    <div class="modal fade" id="DelModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"> @lang('Close Support Ticket!')</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @lang('Are you  want to Close This Support Ticket?')
                </div>
                <div class="modal-footer">
                    <form method="post" action="{{ route('admin.ticket.reply', $ticket->id) }}">
                        @csrf
                        <button type="button" class="btn btn--dark" data-dismiss="modal">@lang('No') </button>
                        <button type="submit" class="btn btn--success" name="replayTicket" value="2"> @lang('Yes') </button>
                    </form>
                </div>

            </div>
        </div>
    </div>



    <div class="modal fade" id="DelMessage" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">@lang('Delete Reply!')</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @lang('Are you sure to delete this?')
                </div>
                <div class="modal-footer">
                    <form method="post" action="{{ route('admin.ticket.delete')}}">
                        @csrf
                        <input type="hidden" name="message_id" class="message_id">
                        <button type="button" class="btn btn--dark" data-dismiss="modal">@lang('No')</button>
                        <button type="submit" class="btn btn--danger">@lang('Yes')</button>
                    </form>
                </div>

            </div>
        </div>
    </div>
@endsection

@push('breadcrumb-plugins')
    <a href="{{ route('admin.ticket') }}" class="btn btn-sm btn--primary box--shadow1 text--small"><i class="la la-fw la-backward"></i> @lang('Go Back') </a>
@endpush

@push('script')
    <script>
        'use strict';
        (function($){
            $('.delete-message').on('click', function (e) {
                $('.message_id').val($(this).data('id'));
            });

            $('.add-more').on('click', function () {

                $("#fileUploadsContainer").append(`
                <div class="file-upload-wrapper" data-text="Select your file!"><input type="file" name="attachments[]" id="inputAttachments" class="file-upload-field"/></div>`)
            });

        })(jQuery)


    </script>
@endpush
