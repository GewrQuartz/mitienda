@extends('admin.layouts.app')

@section('panel')
<div class="row">
    <div class="col-lg-12">
        <div class="card b-radius--10 ">
            <div class="card-body">
                <div class="row justify-content-end">
                    <div class="col-lg-4 mb-3">
                        <form action="" method="GET">
                            <div class="input-group has_append">
                                <input type="text" name="search" class="form-control" placeholder="Orden ID" value="{{ request()->search ?? '' }}">
                                <div class="input-group-append">
                                    <button class="btn btn--primary box--shadow1" id="search-btn" type="submit"><i class="fa fa-search"></i></button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="table-responsive--md  table-responsive">
                    <table class="table table--light style--two">
                        <thead>
                            <tr>
                                <th class="text-left">@lang('Order Date')</th>
                                <th class="text-left">@lang('Customer')</th>
                                <th class="text-left">@lang('Order ID')</th>
                                @if(!request()->routeIs('admin.order.cod'))
                                <th class="text-left">@lang('Payment Via')</th>
                                @endif
                                <th class="text-right">@lang('Amount')</th>
                                @if(request()->routeIs('admin.order.index'))
                                    <th>@lang('Status')</th>
                                @endif
                                <th class="text-center">@lang('Action')</th>
                            </tr>
                        </thead>
                        <tbody class="list">
                            @forelse($orders as $item)
                            <tr>
                                <td data-label="Order Date" class="text-left">
                                    {{ showDateTime($item->created_at, 'd M, Y') }}
                                </td>

                                <td data-label="Customer" class="text-left">
                                    <a href="{{ route('admin.users.detail', $item->user->id) }}">{{ $item->user->username }}</a>
                                </td>
                                <td data-label="Order ID" class="text-left">
                                    {{ $item->order_number }}
                                </td>

                                @if(!request()->routeIs('admin.order.cod'))
                                <td data-label="Payment Via" class="text-left">
                                    @if($item->payment_status==2)
                                    <strong class="text-warning"><abbr data-toggle="tooltip" title="@lang('Cash On Delivery')">{{ @$deposit->gateway->name??trans('COD') }}</abbr></strong>
                                    @elseif($item->deposit)
                                        <strong class="text-primary">{{ $item->deposit->gateway->name }}</strong>
                                    @endif
                                </td>
                                @endif

                                <td data-label="Amount" class="text-right">
                                    <b>{{ $general->cur_sym.($item->total_amount) }}</b>
                                </td>
                                @if(request()->routeIs('admin.order.index'))
                                <td data-label="Action" class="text-center">
                                    <span class="badge
                                        @if($item->status == 0)
                                            {{'badge--warning'}}
                                        @elseif($item->status == 1)
                                            {{'badge--primary'}}

                                        @elseif($item->status == 2)
                                            {{'badge--dark'}}
                                        @elseif($item->status == 3)
                                            {{'badge--success'}}
                                        @elseif($item->status == 4)
                                            {{'badge--danger'}}
                                        @endif
                                            d-block">

                                        @if($item->status == 0)
                                        {{'Pendiente'}}
                                        @elseif($item->status == 1)
                                        {{'Procesando...'}}
                                        @elseif($item->status == 2)
                                            {{'Enviado'}}
                                        @elseif($item->status == 3)
                                            {{'Entregado'}}
                                        @elseif($item->status == 4)
                                            {{'Cancelado'}}

                                        @endif
                                    </span>
                                </td>
                                @endif

                                <td data-label="Action" class="text-center">

                                    <a href="{{ route('admin.order.details', $item->id) }}" data-toggle="tooltip" title="@lang('View')" class="icon-btn btn--dark mr-1">
                                        <i class="la la-desktop"></i>
                                    </a>

                                    @if(!request()->routeIs('admin.order.notpaid'))
                                    <button type="button" class="approveBtn icon-btn btn--success {{$item->status >= 3?'disabled':''}} text-white" data-toggle="tooltip" data-action="{{ $item->status+1 }}" data-id='{{$item->id}}'
                                    title="
                                    @if($item->status == 0)
                                        {{ __('Mark as Processing') }}
                                    @elseif($item->status == 1)
                                        {{ __('Mark as Dispatched') }}
                                    @elseif($item->status == 2)
                                            {{ __('Mark as  Delivered') }}
                                    @endif
                                    ">
                                        <i class="la la-check"></i>
                                    </button>

                                    <button type="button" class="{{ ($item->status==0 || $item->status==4)?'approveBtn':'' }} icon-btn btn--{{$item->status==4?'warning':'danger'}} {{ ($item->status==0 || $item->status==4)?'':'disabled' }}" data-toggle="tooltip" data-action="{{ ($item->status==4)?0:4 }}" data-id='{{$item->id}}' title="{{$item->status==4?__('Retake'):__('Cancel')}}">
                                        <i class="la la-{{$item->status==4?'reply':'ban'}}"></i>
                                    </button>

                                    @else

                                    <button type="button" class="icon-btn btn--danger" data-toggle="modal" data-target="#deleteModal" data-id='{{$item->id}}'>
                                        <i class="la la-trash"></i>
                                    </button>

                                    @endif

                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td class="text-muted text-center" colspan="100%">{{ __($empty_message) }}</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer py-4">
                {{ $orders->links('admin.partials.paginate') }}
            </div>
        </div>
    </div>
</div>
{{-- DELIVERY METHOD MODAL --}}
<div class="modal fade" id="approveModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
        <form action="{{ route('admin.order.status') }}" method="POST" id="deliverPostForm">
            @csrf
            <input type="hidden" name="id" id="oid">
            <input type="hidden" name="action" id="action">
                <div class="modal-header">
                    <h5 class="modal-title" id="approveModalLabel">@lang('Confirmation Alert')</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p class="text-bold">

                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn--dark" data-dismiss="modal">@lang('No')</button>
                    <button type="submit" class="btn btn--success">@lang('Yes')</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('script')
<script src="{{ asset('assets/admin/js/moment.js') }}"></script>
<script>

    'use strict';
    (function($){

        $('.approveBtn').on('click', function () {
            var modal = $('#approveModal');
            $('#oid').val($(this).data('id'));
            var action = $(this).data('action');

            $('#action').val(action);

            if(action == 1){
                $('.text-bold').text("@lang('Are you sure to mark the order as processing?')");
            }else if(action ==2){
                $('.text-bold').text("@lang('Are you sure to mark the order as dispatched?')");
            }else if(action ==3){
                $('.text-bold').text("@lang('Are you sure to mark the order as delivered?')");
            }else if(action ==4){
                $('.text-bold').text("@lang('Are you sure to cancel this order?')");
            }else{
                $('.text-bold').text("@lang('Are you sure to retake this order?')");
            }

            modal.modal('show');
        });
    })(jQuery)

</script>
@endpush


