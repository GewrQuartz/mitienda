@extends('admin.layouts.app')

@section('panel')
<div class="row">
    <div class="col-lg-12">
        <div class="card b-radius--10 ">
            <div class="card-body">
                <div class="row justify-content-end">
                    <div class="col-lg-4 mb-3">
                        @if(request()->routeIs('admin.users.deposits'))
                            <form action="" method="GET">
                                <div class="input-group has_append">
                                    <input type="text" name="search" class="form-control" placeholder="@lang('TRX Number/Username')" value="{{ $search ?? '' }}">

                                    <div class="input-group-append">
                                        <button class="btn btn--primary" type="submit"><i class="fa fa-search"></i></button>
                                    </div>
                                </div>
                            </form>
                        @else
                            <form action="{{route('admin.deposit.search', $scope ?? str_replace('admin.deposit.', '', request()->route()->getName()))}}" method="GET">
                                <div class="input-group has_append  ">
                                    <input type="text" name="search" class="form-control" placeholder="@lang('TRX Number/Username')" value="{{ $search ?? '' }}">
                                    <div class="input-group-append">
                                        <button class="btn btn--primary" type="submit"><i class="fa fa-search"></i></button>
                                    </div>
                                </div>
                            </form>
                        @endif
                    </div>
                </div>
                <div class="table-responsive--sm table-responsive">
                    <table class="table table--light style--two">
                        <thead>
                            <tr>
                                <th>@lang('Date')</th>
                                <th>@lang('Trx Number')</th>
                                <th>@lang('Username')</th>
                                <th>@lang('Method')</th>
                                <th>@lang('Amount')</th>
                                <th>@lang('Charge')</th>
                                <th>@lang('After Charge')</th>
                                <th>@lang('Rate')</th>
                                <th>@lang('Payable')</th>

                                @if(request()->routeIs('admin.deposit.pending') || request()->routeIs('admin.deposit.approved'))
                                    <th>@lang('Action')</th>

                                @elseif(request()->routeIs('admin.deposit.list') || request()->routeIs('admin.deposit.search') || request()->routeIs('admin.users.deposits'))
                                    <th>@lang('Status')</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                        @forelse($deposits as $deposit)
                            @php
                                $details = ($deposit->detail != null) ? json_encode($deposit->detail) : null;
                            @endphp
                            <tr>
                                <td data-label="@lang('Date')"> {{ showDateTime($deposit->created_at) }}</td>
                                <td data-label="@lang('Trx Number')" class="font-weight-bold text-uppercase">{{ $deposit->trx }}</td>
                                <td data-label="@lang('Username')"><a href="{{ route('admin.users.detail', @$deposit->user_id) }}">{{@ $deposit->user->username }}</a></td>

                                <td data-label="@lang('Method')">
                                    @if($deposit->method_code == 0)
                                    <span data-toggle="tooltip" title="@lang('Cash On Delivery')">@lang('COD')</span>
                                    @else
                                    {{ $deposit->gateway->name }}
                                    @endif
                                </td>

                                <td data-label="@lang('Amount')" class="font-weight-bold">{{ getAmount($deposit->amount ) }} {{ $general->cur_text }}</td>
                                <td data-label="@lang('Charge')" class="text-success">{{ getAmount($deposit->charge)}} {{ $general->cur_text }}</td>
                                <td data-label="@lang('After Charge')"> {{ getAmount($deposit->amount+$deposit->charge) }} {{ $general->cur_text }}</td>
                                <td data-label="@lang('Rate')"> {{ getAmount($deposit->rate) }} {{$deposit->method_currency}}</td>
                                <td data-label="@lang('Payable')" class="font-weight-bold">{{ getAmount($deposit->final_amo) }} {{$deposit->method_currency}}</td>

                                @if(request()->routeIs('admin.deposit.approved') || request()->routeIs('admin.deposit.pending'))

                                    <td data-label="@lang('Action')">
                                        @if($deposit->method_code == 0)
                                            <a href="javascript:void(0)" class="icon-btn ml-1 disabled"><i class="la la-eye"></i></a>
                                        @else
                                            <a href="{{ route('admin.deposit.details', $deposit->id) }}" class="icon-btn ml-1 " data-toggle="tooltip" data-original-title="@lang('Detail')">
                                                <i class="la la-eye"></i>
                                            </a>
                                        @endif
                                    </td>

                                @elseif(request()->routeIs('admin.deposit.list')  || request()->routeIs('admin.deposit.search') || request()->routeIs('admin.users.deposits'))
                                    <td data-label="@lang('Status')">
                                        @if($deposit->status == 2)
                                            <span class="badge badge--warning">@lang('Pending')</span>
                                        @elseif($deposit->status == 1)
                                            <span class="badge badge--success">@lang('Approved')</span>
                                        @elseif($deposit->status == 3)
                                            <span class="badge badge--danger">@lang('Rejected')</span>
                                        @endif
                                    </td>
                                @endif
                            </tr>
                        @empty
                            <tr>
                                <td class="text-muted text-center" colspan="100%">{{ __($empty_message) }}</td>
                            </tr>
                        @endforelse

                        </tbody>
                    </table><!-- table end -->
                </div>
            </div>
            <div class="card-footer py-4">
                {{ $deposits->links('admin.partials.paginate') }}
            </div>
        </div><!-- card end -->
    </div>
</div>
@endsection



