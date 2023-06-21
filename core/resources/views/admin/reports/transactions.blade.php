@extends('admin.layouts.app')

@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card b-radius--10">
                <div class="card-body">
                    <div class="row justify-content-end">
                        <div class="col-lg-3 mb-3">
                            @if(request()->routeIs('admin.users.transactions'))
                                <form action="" method="GET">
                                    <div class="input-group has_append">
                                        <input type="text" name="search" class="form-control" placeholder="TRX" value="{{ $search ?? '' }}">
                                        <div class="input-group-append">
                                            <button class="btn btn--primary" type="submit"><i class="fa fa-search"></i></button>
                                        </div>
                                    </div>
                                </form>
                            @else

                            <form action="{{ route('admin.report.transaction.search') }}" method="GET" >
                                <div class="input-group has_append">
                                    <input type="text" name="search" class="form-control" placeholder="TRX/Usuario" value="{{ $search ?? '' }}">
                                    <div class="input-group-append">
                                        <button class="btn btn--primary" type="submit"><i class="fa fa-search"></i></button>
                                    </div>
                                </div>
                            </form>
                            @endif
                        </div>
                        <div class="col-lg-3">

                            <form action="
                                @if(request()->routeIs('admin.report.transaction') ||request()->routeIs('admin.report.transaction.search'))
                                {{ route('admin.report.transaction.search') }}
                                @else
                                    {{ route('admin.report.transaction.user_search', $user->id) }}
                                @endif
                                " method="GET"
                            >
                                <div class="input-group has_append ">
                                    <input name="date" type="text" data-range="true" data-multiple-dates-separator=" to " data-language="en" class="datepicker-here form-control bg--white" data-position='bottom right' placeholder="Búsqueda de fecha" autocomplete="off" value="" data-date-format="dd-mm-yyyy" readonly>
                                    <div class="input-group-append">
                                        <button class="btn btn--primary" type="submit"><i class="fa fa-search"></i></button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="table-responsive--sm table-responsive">
                        <table class="table table--light style--two">
                            <thead>
                            <tr>
                                <th>@lang('Date')</th>
                                <th>@lang('TRX')</th>
                                <th>@lang('Customer')</th>
                                <th>@lang('Amount')</th>
                                <th>@lang('Charge')</th>
                                <th>@lang('Detail')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($transactions as $trx)
                                <tr>
                                    <td data-label="@lang('Date')">{{ showDateTime($trx->created_at) }}</td>
                                    <td data-label="@lang('TRX')" class="font-weight-bold">{{ $trx->trx }}</td>
                                    <td data-label="@lang('Customer')"><a href="{{ route('admin.users.detail', $trx->user_id) }}">{{ @$trx->user->username }}</a></td>
                                    <td data-label="@lang('Amount')" class="budget">
                                        <strong @if($trx->trx_type == '+') class="text--success" @else class="text--danger" @endif> {{($trx->trx_type == '+') ? '+':'-'}} {{getAmount($trx->amount)}} {{$general->cur_text}}</strong>
                                    </td>
                                    <td data-label="@lang('Charge')" class="budget">{{ $general->cur_sym }} {{ getAmount($trx->charge) }} </td>
                                    <td data-label="@lang('Detail')">{{ $trx->details }}</td>
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
                    {{ $transactions->links('admin.partials.paginate') }}
                </div>
            </div><!-- card end -->
        </div>
    </div>

@endsection
@push('script')
    <script src="{{asset('assets/admin/js/vendor/datepicker.min.js')}}"></script>
    <script src="{{asset('assets/admin/js/vendor/datepicker.en.js')}}"></script>
    <script>
    // date picker
    'use strict';
    (function($){
        $('.datepicker-here').datepicker();

    })(jQuery)
    </script>
@endpush





