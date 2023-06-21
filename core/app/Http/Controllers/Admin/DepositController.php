<?php

namespace App\Http\Controllers\Admin;

use App\Deposit;
use App\GeneralSetting;
use App\Http\Controllers\Controller;
use App\Order;
use App\Transaction;
use App\User;
use Illuminate\Http\Request;

class DepositController extends Controller
{

    public function pending()
    {
        $page_title = 'Pending Payments';
        $empty_message = 'No pending payments.';
        $deposits = Deposit::pending()->with(['user', 'gateway'])->latest()->paginate(getPaginate());
        return view('admin.deposit.log', compact('page_title', 'empty_message', 'deposits'));
    }


    public function approved()
    {
        $page_title = 'Approved Payments';
        $empty_message = 'No approved payments.';
        $deposits = Deposit::where('status', 1)->with(['user', 'gateway'])->latest()->paginate(getPaginate());
        return view('admin.deposit.log', compact('page_title', 'empty_message', 'deposits'));
    }

    public function successful()
    {
        $page_title = 'Successful Payments';
        $empty_message = 'No successful payments.';
        $deposits = Deposit::where('status', 1)->with(['user', 'gateway'])->latest()->paginate(getPaginate());
        return view('admin.deposit.log', compact('page_title', 'empty_message', 'deposits'));
    }

    public function rejected()
    {
        $page_title = 'Rejected Payments';
        $empty_message = 'No rejected payments.';
        $deposits = Deposit::where('status', 3)->with(['user', 'gateway'])->latest()->paginate(getPaginate());
        return view('admin.deposit.log', compact('page_title', 'empty_message', 'deposits'));
    }

    public function deposit()
    {
        $page_title = 'All Payments';
        $empty_message = 'No payment history available.';
        $deposits = Deposit::with(['user', 'gateway'])->where('status','!=',0)->latest()->paginate(getPaginate());
        return view('admin.deposit.log', compact('page_title', 'empty_message', 'deposits'));
    }

    public function search(Request $request, $scope)
    {
        $search = $request->search;
        $page_title = '';
        $empty_message = 'No search result was found.';
        $deposits = Deposit::with(['user', 'gateway'])->where('status','!=',0)->where(function ($q) use ($search) {
            $q->where('trx', 'like', "%$search%")->orWhereHas('user', function ($user) use ($search) {
                $user->where('username', 'like', "%$search%");
            });
        });
        switch ($scope) {
            case 'pending':
                $page_title .= 'Pending Payments Search';
                $deposits = $deposits->where('status', 2);
                break;
            case 'approved':
                $page_title .= 'Approved Payments Search';
                $deposits = $deposits->where('status', 1);
                break;
            case 'rejected':
                $page_title .= 'Rejected Payments Search';
                $deposits = $deposits->where('status', 3);
                break;
            case 'list':
                $page_title .= 'Payments History Search';
                break;
        }
        $deposits = $deposits->paginate(getPaginate());
        $page_title .= ' - ' . $search;

        return view('admin.deposit.log', compact('page_title', 'search', 'scope', 'empty_message', 'deposits'));
    }

    public function details($id)
    {
        $general = GeneralSetting::first();
        $deposit = Deposit::where('id', $id)->with(['user', 'gateway'])->firstOrFail();
        $page_title = $deposit->user->username.' requested ' . getAmount($deposit->amount) . ' '.$general->cur_text;
        $details = ($deposit->detail != null) ? json_encode($deposit->detail) : null;

        return view('admin.deposit.detail', compact('page_title', 'deposit','details'));
    }

    public function approve(Request $request)
    {

        $request->validate(['id' => 'required|integer']);
        $deposit = Deposit::where('id',$request->id)->where('status',2)->firstOrFail();
        $deposit->update(['status' => 1]);

        $order = Order::where('id', $deposit->order_id)->first();
        $order->payment_status = 1;
        $order->save();

        $user = User::find($deposit->user_id);
        $user->update();

        $transaction = new Transaction();
        $transaction->user_id = $deposit->user_id;
        $transaction->amount = getAmount($deposit->amount);
        $transaction->charge = getAmount($deposit->charge);
        $transaction->trx_type = '+';
        $transaction->details = 'Payment By ' . $deposit->gateway_currency()->name;
        $transaction->trx =  $deposit->trx;
        $transaction->save();

        $gnl = GeneralSetting::first();
        notify($user, 'DEPOSIT_APPROVE', [
            'method_name' => $deposit->gateway_currency()->name,
            'method_currency' => $deposit->method_currency,
            'method_amount' => getAmount($deposit->final_amo),
            'amount' => getAmount($deposit->amount),
            'charge' => getAmount($deposit->charge),
            'currency' => $gnl->cur_text,
            'rate' => getAmount($deposit->rate),
            'trx' => $deposit->trx,
        ]);
        $notify[] = ['success', 'Payment has been approved.'];

        return redirect()->route('admin.deposit.pending')->withNotify($notify);
    }

    public function reject(Request $request)
    {

        $request->validate([
            'id' => 'required|integer',
            'message' => 'required|max:250'
        ]);
        $deposit = Deposit::where('id',$request->id)->where('status',2)->firstOrFail();

        $deposit->admin_feedback = $request->message;
        $deposit->status = 3;
        $deposit->save();

        $gnl = GeneralSetting::first();
        notify($deposit->user, 'DEPOSIT_REJECT', [
            'method_name' => $deposit->gateway_currency()->name,
            'method_currency' => $deposit->method_currency,
            'method_amount' => getAmount($deposit->final_amo),
            'amount' => getAmount($deposit->amount),
            'charge' => getAmount($deposit->charge),
            'currency' => $gnl->cur_text,
            'rate' => getAmount($deposit->rate),
            'trx' => $deposit->trx,
            'rejection_message' => $request->message
        ]);

        $notify[] = ['success', 'Payment has been rejected.'];
        return  redirect()->route('admin.deposit.pending')->withNotify($notify);

    }
}
