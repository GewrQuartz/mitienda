<?php

namespace App\Http\Controllers\Admin;

use App\GeneralSetting;
use App\Http\Controllers\Controller;
use App\Order;
use App\OrderDetail;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function ordered()
    {
        $empty_message  = 'No Data Found';
        $page_title     = "All Orders";

        $query          =  Order::where('payment_status', '!=' ,0);
        if(isset(request()->search)){
            $query->where('order_number', request()->search);
        }
        $orders = $query->with(['user', 'deposit', 'deposit.gateway'])->orderBy('id', 'DESC')->paginate(getPaginate());

        return view('admin.order.ordered', compact('page_title', 'orders', 'empty_message'));
    }

    public function codOrders()
    {
        $empty_message  = 'No Data Found';
        $page_title     = "COD Orders";
        $query          = Order::where('payment_status',2);
        if(isset(request()->search)){
            $query->where('order_number', request()->search);
        }
        $orders         = $query->with(['user', 'deposit'])->orderBy('id', 'DESC')->paginate(getPaginate());

        return view('admin.order.ordered', compact('page_title', 'orders', 'empty_message'));
    }

    public function pending()
    {
        $empty_message  = 'No Data Found';
        $page_title     = "Pending Orders";

        $query         = Order::where('payment_status', '!=' , 0)->where('status', 0);
        if(isset(request()->search)){
            $query->where('order_number', request()->search);
        }
        $orders         = $query->with(['user', 'deposit', 'deposit.gateway'])->orderBy('id', 'DESC')->paginate(getPaginate());
        return view('admin.order.ordered', compact('page_title', 'orders', 'empty_message'));

    }

    public function onProcessing()
    {
        $empty_message  = 'No Data Found';
        $page_title     = "Orders on Processing";

        $query         = Order::where('payment_status', '!=' ,0)->where('status', 1);
        if(isset(request()->search)){
            $query->where('order_number', request()->search);
        }
        $orders         = $query->with(['user', 'deposit', 'deposit.gateway'])->orderBy('id', 'DESC')->paginate(getPaginate());
        return view('admin.order.ordered', compact('page_title', 'orders', 'empty_message'));
    }

    public function dispatched()
    {
        $empty_message  = 'No Data Found';
        $page_title     = "Orders Dispatched";
        $query         = Order::where('payment_status', '!=' ,0)->where('status', 2);
        if(isset(request()->search)){
            $query->where('order_number', request()->search);
        }
        $orders         = $query->with(['user', 'deposit', 'deposit.gateway'])->orderBy('id', 'DESC')->paginate(getPaginate());
        return view('admin.order.ordered', compact('page_title', 'orders', 'empty_message'));
    }


    public function canceledOrders()
    {
        $empty_message  = 'No Data Found';
        $page_title     = "Canceled Orders";

        $query         = Order::where('payment_status', '!=' ,0)->where('status', 4);
        if(isset(request()->search)){
            $query->where('order_number', request()->search);
        }
        $orders         = $query->with(['user', 'deposit', 'deposit.gateway'])->orderBy('id', 'DESC')->paginate(getPaginate());
        return view('admin.order.ordered', compact('page_title', 'orders', 'empty_message'));
    }

    public function deliveredOrders()
    {
        $empty_message  = 'No Data Found';
        $page_title     = "Delivered Orders";

        $query         = Order::where('payment_status', '!=' ,0)->where('status', 3);
        if(isset(request()->search)){
            $query->where('order_number', request()->search);
        }
        $orders         = $query->with(['user', 'deposit', 'deposit.gateway'])->orderBy('id', 'DESC')->paginate(getPaginate());


        return view('admin.order.ordered', compact('page_title', 'orders', 'empty_message'));
    }

    public function changeStatus(Request $request)
    {
        $order = Order::findOrFail($request->id);
        if($order->status == 3){
            $notify[] = ['error', 'This order has already been delivered'];
            return back()->withNotify($notify);
        }


        $order->status = $request->action;

        if($request->action==1){
            $action = 'Processing';
        }elseif($request->action == 2){
            $action = 'Dispatched';
        }elseif($request->action == 3){
            $action = 'Deliverd';
            $order->deposit->status = 1;
            $order->deposit->save();
        }elseif($request->action == 4){
            $action = 'Canceled';
        }elseif($request->action == 0){
            $action = 'Pending';
        }

        $notify[] = ['success', 'Order Status Changed to '.$action];
        $order->save();
        $general = GeneralSetting::first('sitename', 'cur_sym');

        $short_code = [
            'site_name' => $general->sitename,
            'order_id'  => $order->order_number
        ];

        if($request->action == 1){
            $act = 'ORDER_ON_PROCESSING_CONFIRMATION';
        }elseif($request->action == 2){
            $act = 'ORDER_DISPATCHED_CONFIRMATION';
        }elseif($request->action == 3){
            $act = 'ORDER_DELIVERY_CONFIRMATION';
        }elseif($request->action == 4){
            $act = 'ORDER_CANCELLATION_CONFIRMATION';
        }elseif($request->action == 0){
            $act = 'ORDER_RETAKE_CONFIRMATION';
        }
        notify($order->user, $act, $short_code);
        return back()->withNotify($notify);
    }

    public function orderDetails($id)
    {
        $page_title = 'Order Details';
        $order = Order::where('id', $id)->with('user','deposit','deposit.gateway','orderDetail', 'appliedCoupon')->firstOrFail();
        return view('admin.order.order_details', compact('order', 'page_title'));
    }
}
