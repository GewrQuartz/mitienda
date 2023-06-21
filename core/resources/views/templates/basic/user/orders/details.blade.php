@extends(activeTemplate() .'layouts.master')

@section('content')
<!-- dashboard-section start -->
<div class="invoice-history-section padding-bottom padding-top">
    <div class="container border">
        <!-- Main content -->
        <div class="invoice" id="invoice">
            <!-- title row -->
            <div class="row mt-3 border-bottom p-3">
                <div class="col-lg-6">
                    <h4><i class="fa fa-globe"></i> {{__($general->sitename)}} </h4>
                </div>
                <div class="col-lg-6 text-right">
                    <b>@lang('Order ID'):</b> {{$order->order_number}}<br>
                    <b>@lang('Order Date'):</b> {{showDateTime($order->created_at, 'd/m/Y')}} <br>
                </div>
            </div>

            <div class="invoice-info mb-3">

            </div><!-- /.row -->
            <!-- Table row -->

            <div class="row">
                <div class="col-12 table-responsive">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>@lang('SN.')</th>
                            <th>@lang('Product')</th>
                            <th>@lang('Variants')</th>
                            <th>@lang('Discount')</th>
                            <th>@lang('Quantity')</th>
                            <th>@lang('Price')</th>
                            <th>@lang('Total Price')</th>
                        </tr>
                        </thead>
                        <tbody>
                            @php
                            $subtotal = 0;
                            @endphp
                            @foreach($order->orderDetail as $data)
                                    
                            @php
                            $details = json_decode($data->details);
                            $offer_price = $details->offer_amount;
                            $extra_price = 0;
                            @endphp
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$data->product->name ?? "Product Removed"}}</td>
                                <td>
                                    @if($details->variants)
                                    @foreach ($details->variants as $item)
                                    <span class="d-block">{{__($item->name)}} :  <b>{{__($item->value)}}</b></span>
                                    @php $extra_price += $item->price;  @endphp
                                    @endforeach
                                    @else
                                    @lang('N/A')
                                    @endif
                                </td>
                                @php $base_price = $data->base_price + $extra_price @endphp
                                <td class="text-right">{{$general->cur_sym.getAmount($offer_price)}}/ @lang('Item')</td>
                                <td class="text-center">{{$data->quantity}}</td>
                                <td class="text-right">{{$general->cur_sym. ($data->base_price - getAmount($offer_price))}}</td>

                                <td class="text-right">{{$general->cur_sym.getAmount(($base_price - $offer_price)*$data->quantity)}}</td>
                                @php $subtotal += ($base_price - $offer_price) * $data->quantity @endphp
                            </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div><!-- /.col -->
            </div><!-- /.row -->

            <div class="row mt-4">
                <!-- accepted payments column -->
                <div class="col-lg-6">
                    @if(isset($order->deposit) && $order->deposit->status != 0)
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <th width="50%">@lang('Payment Method')</td>
                                    <td width="50%">
                                        @if($order->deposit->method_code == 0)
                                        <span data-toggle="tooltip" title="@lang('Cash On Delivery')">@lang('COD')
                                        </span>
                                        @else
                                        {{ __($order->deposit->gateway->name) }}
                                        @endif
                                </td>
                                </tr>

                                <tr>
                                    <th>@lang('Payment Charge')</td>
                                    <td>{{$general->cur_sym. $charge = getAmount(@$order->deposit->charge) }}</td>
                                </tr>
                                <tr>
                                    <th>@lang('Total Payment Amount') </td>
                                    <td>{{$general->cur_sym. getAmount(($order->deposit->amount + $charge)) }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    @endif


                </div><!-- /.col -->
                <div class="col-lg-6">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <th width="50%">@lang('Subtotal')</th>
                                    <td width="50%">{{@$general->cur_sym.getAmount($subtotal, 2)}}</td>
                                </tr>
                                @if($order->appliedCoupon)
                                <tr>
                                    <th>(<i class="la la-plus"></i>) @lang('Coupon') ({{ $order->appliedCoupon->coupon->coupon_code }})</th>
                                    <td> {{$general->cur_sym.getAmount($order->appliedCoupon->amount, 2)}}</td>
                                </tr>
                                @endif
                                <tr>
                                    <th>(<i class="la la-minus"></i>) @lang('Shipping')</th>
                                    <td>{{ @$general->cur_sym.getAmount($order->shipping_charge, 2)}}</td>
                                </tr>
                                <tr>
                                    <th>@lang('Total')</th>
                                    <td>{{@$general->cur_sym.($order->total_amount)}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div><!-- /.col -->



                <div class="col-md-12">
                    <h5 class="mb-2">@lang('Shipping Address')</h5>
                    @php
                        $shipping_address = json_decode($order->shipping_address);
                    @endphp

                    <address>
                        <strong>@lang('Name'):</strong> {{$order->user->firstname }} {{$order->user->lastname }},
                        <strong>@lang('Address'):</strong> {{$shipping_address->address}},
                        <strong>@lang('State'):</strong> {{$shipping_address->state}},
                        <strong>@lang('City'):</strong> {{$shipping_address->city}},
                        <strong>@lang('Zip'):</strong> {{$shipping_address->zip}},
                        <strong>@lang('Country'):</strong> {{$shipping_address->country}}
                    </address>
                </div><!-- /.col -->
            </div><!-- /.row -->
            <!-- this row will not appear when printing -->
        </div><!-- /.content -->
        <div class="float-right">
            <a href="{{ route('print.invoice', $order->id) }}" target=blank class="btn btn-dark mt-3"><i class="fa fa-print"></i>@lang('Print')</a>
        </div>
    </div>
</div>

@endsection



@push('breadcrumb-plugins')
    <li><a href="{{route('user.home')}}">@lang('Dashboard')</a></li>
    <li><a href="{{route('user.orders', 'all')}}">@lang('Orders')</a></li>
@endpush
