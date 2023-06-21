@extends($activeTemplate.'layouts.master')
@section('content')
<div class="payment-history-section padding-bottom padding-top">
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
                <table class="payment-table section-bg">
                    <thead>
                        <tr>
                            <th>@lang('S.N.')</th>
                            <th>@lang('Transaction ID')</th>
                            <th>@lang('Gateway')</th>
                            <th>@lang('Amount')</th>
                            <th>@lang('Status')</th>
                            <th>@lang('Time')</th>
                            <th>@lang('View')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(count($logs) >0)
                        @foreach($logs as $k=>$data)
                            <tr>

                                <td data-label="@lang('#')">{{$loop->iteration}}</td>
                                <td data-label="@lang('Transaction ID')">{{$data->trx}}</td>
                                <td data-label="@lang('Gateway')">{{ __(optional($data->gateway)->name) }}</td>
                                <td data-label="@lang('Amount')">
                                    <strong>{{getAmount($data->amount)}} {{$general->cur_text}}</strong>
                                </td>
                                <td data-label="@lang('Status')">
                                    @if($data->status == 1)
                                        <span class="d-block badge badge-capsule badge--success">@lang('Complete')</span>
                                    @elseif($data->status == 2)
                                        <span class="d-block badge badge-capsule badge--warning">@lang('Pending')</span>
                                    @elseif($data->status == 3)
                                        <span class="d-block badge badge-capsule badge--danger">@lang('Cancel')</span>
                                    @endif

                                    @if($data->admin_feedback != null)
                                        <button class="cmn-btn detailBtn" data-admin_feedback="{{$data->admin_feedback}}"><i class="fa fa-info"></i></button>
                                    @endif


                                </td>
                                <td data-label="@lang('Time')">
                                    <i class="fa fa-calendar"></i> {{showDateTime($data->created_at)}}
                                </td>

                                @php
                                    $details = ($data->detail != null) ? json_encode($data->detail) : null;
                                @endphp

                                <td data-label="@lang('Details')">
                                    <a href="javascript:void(0)" class="edit approveBtn"
                                        data-info="{{$details}}"
                                        data-id="{{ $data->id }}"
                                        data-amount="{{ getAmount($data->amount)}} {{ $general->cur_text }}"
                                        data-charge="{{ getAmount($data->charge)}} {{ $general->cur_text }}"
                                        data-after_charge="{{ getAmount($data->amount + $data->charge)}} {{ $general->cur_text }}"
                                        data-rate="{{ getAmount($data->rate)}} {{ $data->method_currency }}"
                                        data-payable="{{ getAmount($data->final_amo)}} {{ $data->method_currency }}">
                                        <i class="fa fa-desktop"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                        @else
                            <tr>
                                <td colspan="100%"> @lang('No result found')!</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


{{-- APPROVE MODAL --}}
<div id="approveModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-3">
                <h5 class="modal-title cl-white">@lang('Details')</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="text-white">&times;</span>
                </button>
            </div>
            <div class="modal-body p-0">
                <ul class="list-group">
                    <li class="list-group-item d-flex justify-content-between rounded-0">@lang('Amount') <span class="withdraw-amount "></span></li>
                    <li class="list-group-item d-flex justify-content-between rounded-0">@lang('Charge') <span class="withdraw-charge "></span></li>
                    <li class="list-group-item d-flex justify-content-between rounded-0">@lang('After Charge') <span class="withdraw-after_charge"></span></li>
                    <li class="list-group-item d-flex justify-content-between rounded-0">@lang('Conversion Rate') <span class="withdraw-rate"></span></li>
                    <li class="list-group-item d-flex justify-content-between rounded-0 border-bottom-0">@lang('Payable Amount') : <span class="withdraw-payable"></span></li>
                </ul>


                <ul class="list-group d-flex withdraw-detail mt-1">
                </ul>


            </div>
            <div class="modal-footer">
                <button type="button" class="cmn-btn" data-dismiss="modal">@lang('Close')</button>
            </div>
        </div>
    </div>
</div>


{{-- Detail MODAL --}}
<div id="detailModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-3">
                <h5 class="modal-title">@lang('Details')</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <div class="withdraw-detail"></div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">@lang('Close')</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
<script>
    "use strict";
    (function($){
        $('.approveBtn').on('click', function() {
            var modal = $('#approveModal');
            modal.find('.withdraw-amount').text($(this).data('amount'));
            modal.find('.withdraw-charge').text($(this).data('charge'));
            modal.find('.withdraw-after_charge').text($(this).data('after_charge'));
            modal.find('.withdraw-rate').text($(this).data('rate'));
            modal.find('.withdraw-payable').text($(this).data('payable'));

            var list = [];
            var details =  Object.entries($(this).data('info'));

            var ImgPath = "{{asset(imagePath()['verify']['deposit']['path'])}}";
            var singleInfo = '';
            for (var i = 0; i < details.length; i++) {
                if (details[i][1].type == 'file') {
                    singleInfo += `<li class="list-group-item d-flex justify-content-between rounded-0">
                                        <span class="font-weight-bold mb-2"> ${details[i][0].replaceAll('_', " ")} </span> <img class="w-25" src="${ImgPath}/${details[i][1].field_name}" alt="..." class="w-100">
                                    </li>`;
                }else{
                    singleInfo += `<li class="list-group-item d-flex justify-content-between rounded-0">
                                        <span class="font-weight-bold "> ${details[i][0].replaceAll('_', " ")} </span> <span class="font-weight-bold ml-3">${details[i][1].field_name}</span>
                                    </li>`;
                }
            }

            if (singleInfo)
            {
                modal.find('.withdraw-detail').html(`<h5 class="my-3 text-center">@lang('Payment Information')</h5>  ${singleInfo}`);
            }else{
                modal.find('.withdraw-detail').html(`@lang('${singleInfo}')`);
            }
            modal.modal('show');
        });
        $('.detailBtn').on('click', function() {
            var modal = $('#detailModal');
            var feedback = $(this).data('admin_feedback');
            modal.find('.withdraw-detail').html(`<p> @lang('${feedback}') </p>`);
            modal.modal('show');
        });
    })(jQuery)
</script>
@endpush



@push('breadcrumb-plugins')
    <li><a href="{{route('user.home')}}">@lang('Dashboard')</a></li>
@endpush
