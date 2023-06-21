@extends('admin.layouts.app')

@section('panel')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="table-responsive--md table-responsive">
                <table class="table table--light style--two">
                    <thead>
                        <tr>
                            <th>@lang('SN.')</th>
                            <th class="text-center">@lang('Quantity')</th>
                            <th>@lang('Description')</th>
                            <th>@lang('Created At')</th>
                        </tr>
                    </thead>
                    <tbody class="list">
                        @forelse($stock_logs as $log)
                        <tr>
                            <td data-label="@lang('SN.')">{{$loop->iteration}}</td>
                            <td data-label="@lang('Quantity')" class="text-center">
                                <span class="badge badge--{{$log->quantity>0?'success':'dark'}} ">
                                    {{ sprintf('%02d',$log->quantity)}}
                                </span>
                            </td>
                            <td data-label="@lang('Description')">
                                {{$log->type==1?'Updated by admin':'Sold'}}
                            </td>
                            <td data-label="@lang('Created At')">{{ showDateTime($log->created_at) }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td class="text-muted text-center" colspan="100%">{{ __($empty_message) }}</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="card-footer py-4">
                <nav aria-label="...">
                    {{ $stock_logs->links('admin.partials.paginate') }}
                </nav>
            </div>

        </div>
    </div>
</div>

@endsection

@push('breadcrumb-plugins')
<a href="{{ route('admin.products.stock.create', $product_stock->product->id) }}" class="btn btn-sm btn--primary box--shadow1 text--small"><i class="las la-backward"></i>@lang('Go Back')</a>
@endpush
