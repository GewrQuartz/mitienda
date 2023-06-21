<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Order;
use App\Product;
use App\Transaction;
use App\User;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function transaction()
    {
        $page_title = 'Transaction Logs';
        $transactions = Transaction::with('user')->latest()->paginate(getPaginate());
        $empty_message = 'No transactions.';
        return view('admin.reports.transactions', compact('page_title', 'transactions', 'empty_message'));
    }

    public function transactionSearch(Request $request)
    {
        $search  = $page_title = '';
        $empty_message  = 'No Transaction Found';

        if($request->search != null){
            $search         = trim(strtolower($request->search));
            $transactions   = Transaction::with('user')
            ->whereHas('user', function ($user) use ($search) {
                $user->where('username', 'like', "%$search%");
            })->orWhere('trx', 'like', "%$search%")->paginate(getPaginate());
            $page_title     = 'Transactions Search - ' . $search;

        }elseif($request->has('date')){
            $request->validate([
                'date' => 'required|string',
            ]);

            $date               = explode('to', $request->date);

            if(count($date) == 2) {
                $start_date       = date('Y-m-d H:i:s',strtotime(trim($date[0])));
                $end_date         = date('Y-m-d H:i:s',strtotime(trim($date[1])));

                $transactions     = Transaction::whereBetween('created_at', [$start_date, $end_date])->paginate(getPaginate());

                $page_title     = 'Transactions - Between ' . showDatetime($start_date, 'M d, y').' to ' .showDatetime($end_date, 'M d, y');

            }else{
                $start_date       = date('Y-m-d',strtotime(trim($date[0])));
                $transactions     = Transaction::whereDate('created_at', $start_date)->paginate(getPaginate());

                $page_title     = 'Transactions of ' . showDatetime($start_date, 'M d, y');
            }

        }else{
            $page_title     = 'Transactions Logs';
            $transactions = Transaction::with('user')->whereHas('user')->latest()->paginate(getPaginate());
        }

        return view('admin.reports.transactions', compact('page_title', 'transactions', 'empty_message','search'));
    }


    public function userTransactionSearch(Request $request, $id)
    {
        $user = User::findOrfail($id);
        $search  = $page_title = '';
        $key    = $request->search??'';
        $empty_message  = 'No Transaction Found';

        if($request->search != null){
            $search         = trim(strtolower($request->search));
            $transactions   = Transaction::where('user_id', $id)->with('user')
            ->whereHas('user', function ($user) use ($search) {
                $user->where('username', 'like', "%$search%");
            })->orWhere('trx', 'like', "%$search%")->paginate(getPaginate());
            $page_title     = 'Transactions Search - ' . $search;

        }elseif($request->has('date')){
            $request->validate([
                'date' => 'required|string',
            ]);

            $date               = explode('to', $request->date);
            if(count($date) == 2) {
                $start_date       = date('Y-m-d H:i:s',strtotime(trim($date[0])));
                $end_date         = date('Y-m-d H:i:s',strtotime(trim($date[1])));

                $transactions     = Transaction::where('user_id', $id)->whereBetween('created_at', [$start_date, $end_date])->paginate(getPaginate());

                $page_title     = 'Transactions of '.$user->fullname .' Between ' . showDatetime($start_date, 'M d, y').' to ' .showDatetime($end_date, 'M d, y');

            }else{
                $start_date       = date('Y-m-d', strtotime(trim($date[0])));
                $transactions     = Transaction::where('user_id', $id)->whereDate('created_at',$start_date)->paginate(getPaginate());

                $page_title     = 'Transactions of '.$user->fullname.' for ' . showDatetime($start_date, 'M d, y');
            }
        }else{
            $transactions   = Transaction::where('user_id', $id)->with('user')
            ->whereHas('user')->paginate(getPaginate());
            $page_title     = 'All Transactions of ' . $user->fullname;
        }

        return view('admin.reports.transactions', compact('page_title', 'transactions', 'empty_message','search', 'user'));
    }

    public function order()
    {
        $page_title = 'Order Logs';
        $orders     = Order::where('payment_status', '!=' ,0)->with('user', 'deposit')->latest()->paginate(15);

        $empty_message = 'No orders.';
        return view('admin.reports.orders', compact('page_title', 'orders', 'empty_message'));
    }

    public function orderByUser($id)
    {
        $user = User::findOrFail($id);
        $page_title = 'Order Logs of '. $user->fullname;


        $orders     =  Order::where('user_id', $id)->where('payment_status', '!=' ,0)->with('user', 'deposit')->paginate(config('constansts.table.default'));

        $empty_message = 'No orders.';
        return view('admin.reports.orders', compact('page_title', 'user', 'orders', 'empty_message'));
    }

    public function orderSearch(Request $request)
    {
        $key    = $request->search??'';

        if($key){
            $orders = Order::where('payment_status', '!=' ,0)->with('user', 'deposit')->where('order_number', 'like', "%$key%")->paginate(config('constansts.table.default'));
            $page_title = 'Order Search Results - Order ID: ' . $key;

        }elseif($request->has('date')){
            $request->validate([
                'date' => 'required|string',
            ]);

            if($request->date){
                $data['title']['Date to Date']      = $request->date ;

                $date               = explode('to', $request->date);

                if(count($date) == 2) {
                    $start_date       = date('Y-m-d H:i:s',strtotime(trim($date[0])));
                    $end_date         = date('Y-m-d H:i:s',strtotime(trim($date[1])));
                    $orders           = Order::where('payment_status', '!=' ,0)->with('user', 'deposit')->whereBetween('created_at', [$start_date, $end_date])->paginate(getPaginate());

                    $page_title = 'Orders between : ' . showDateTime($start_date, 'd M, Y') .' to '. showDateTime($end_date, 'd M, Y');
                }else{
                    $start_date       = date('Y-m-d', strtotime(trim($date[0])));
                    $orders           = Order::where('payment_status', '!=' ,0)->with('user', 'deposit')->whereDate('created_at',$start_date)->paginate(getPaginate());

                    $page_title     = 'Orders of ' . showDatetime($start_date, 'M d, y');
                }

            }else{
                $page_title = 'Order Logs';
                $orders     = Order::where('payment_status', '!=' ,0)->with('user', 'deposit')->latest()->paginate(15);
            }

        }

        $empty_message  = 'No Orders.';

        return view('admin.reports.orders', compact('page_title', 'orders', 'empty_message', 'key'));
    }

    public function userOrderSearch(Request $request, $id)
    {
        $user = User::findOrfail($id);
        $key    = $request->search??'';

        if($key){
            $orders = Order::where('user_id', $id)
            ->where('payment_status', '!=' ,0)
            ->with('user', 'deposit')->where('order_number', 'like', "%$key%")
            ->paginate(config('constansts.table.default'));

            $page_title = 'Order Search of' . $user->fullname .' Results - Order ID : ' . $key;
        }elseif($request->has('date')){
            $request->validate([
                'date' => 'required|string',
            ]);

            $date               = explode('to', $request->date);

            if(count($date) == 2) {

                $start_date       = date('Y-m-d H:i:s',strtotime(trim($date[0])));
                $end_date         = date('Y-m-d H:i:s',strtotime(trim($date[1])));

                $orders     = Order::where('user_id', $id)->where('payment_status', '!=' ,0)->with('user', 'deposit')->whereBetween('created_at', [$start_date, $end_date])->paginate(getPaginate());

                $page_title = 'Orders of '. $user->name .' between : ' . showDateTime($start_date, 'd M, Y') .' to '. showDateTime($end_date, 'd M, Y');

            }else{
                $start_date       = date('Y-m-d', strtotime(trim($date[0])));

                $orders           = Order::where('user_id', $id)->where('payment_status', '!=' ,0)->with('user', 'deposit')->whereDate('created_at',$start_date)->paginate(getPaginate());

                $page_title     = 'Orders of '.$user->name .' '. showDatetime($start_date, 'M d, y');
            }

        }

        $empty_message  = 'No Order Yet.';

        return view('admin.reports.orders', compact('page_title', 'user', 'orders', 'empty_message', 'key'));
    }
}
