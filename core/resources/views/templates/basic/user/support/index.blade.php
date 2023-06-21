@extends($activeTemplate.'layouts.master')

@section('content')
<div class="account-section padding-bottom padding-top">
    <div class="container">
        <div class="row justify-content-center">
            @auth
            <div class="col-xl-3">
                <div class="dashboard-menu">
                    @include($activeTemplate.'user.partials.dp')
                    <ul>
                        @include($activeTemplate.'user.partials.sidebar')
                    </ul>
                </div>
            </div>
            @endauth

            <div class="col-md-9">
                <div class="card">
                    <div class="card-header bg-3 text-white">{{ __($page_title) }}
                        <a href="{{route('ticket.open') }}" class="cmn-btn-2 btn-sm float-right">
                         <i class="fa fa-plus"></i> @lang('New Ticket')
                        </a>
                    </div>

                    <div class="card-body">
                        <table class="payment-table section-bg">
                            <thead>
                                <tr>
                                    <th>@lang('Subject')</th>
                                    <th>@lang('Status')</th>
                                    <th>@lang('Last Reply')</th>
                                    <th>@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($supports as $key => $support)
                                <tr>
                                    <td data-label="@lang('Subject')"> <a href="{{ route('ticket.view', $support->ticket) }}" class="font-weight-bold"> [@lang('Ticket')#{{ $support->ticket }}] {{ $support->subject }} </a></td>
                                    <td data-label="@lang('Status')">
                                        @if($support->status == 0)
                                            <span class="text--small font-weight-normal badge badge--success">@lang('Open')</span>
                                        @elseif($support->status == 1)
                                            <span class="text--small font-weight-normal badge badge--primary">@lang('Answered')</span>
                                        @elseif($support->status == 2)
                                            <span class="text--small font-weight-normal badge badge--warning">@lang('Customer Reply')</span>
                                        @elseif($support->status == 3)
                                            <span class="text--small font-weight-normal badge badge-dark">@lang('Closed')</span>
                                        @endif
                                    </td>
                                    <td data-label="@lang('Last Reply')">{{ \Carbon\Carbon::parse($support->last_reply)->diffForHumans() }} </td>

                                    <td data-label="@lang('Action')">
                                        <a href="{{ route('ticket.view', $support->ticket) }}" class="btn btn-primary btn-sm">
                                            <i class="fa fa-desktop"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        {{$supports->links()}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


@push('breadcrumb-plugins')
<li><a href="{{route('user.home')}}">@lang('Dashboard')</a></li>
@endpush
