<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\ShippingMethod;
use Illuminate\Http\Request;

class ShippingMethodController extends Controller
{
    public function index()
    {
        $page_title         = 'Shipping Method Manager';
        $empty_message      = 'No shipping mehods created yet';
        $shipping_methods   = ShippingMethod::latest()->paginate(getPaginate());

        return view('admin.shipping_method.index', compact('page_title', 'empty_message', 'shipping_methods'));
    }

    public function create()
    {
        $page_title = 'Create New Shipping Method';

        return view('admin.shipping_method.create', compact('page_title'));
    }

    public function edit(ShippingMethod $id)
    {
        $shipping_method =  $id;
        $page_title = 'Edit Shipping Method';

        return view('admin.shipping_method.create', compact('page_title', 'shipping_method'));
    }

    public function store(Request $request, $id)
    {
        $validation_rule = [
            'name'          => 'required|string|max:191',
            'charge'        => 'required|numeric',
            'description'   => 'nullable|string|',
        ];
        $request->validate($validation_rule);

        if($id ==0){
            $sm = new ShippingMethod();
            $notify[] = ['success', 'Shipping Method Created Successfully'];
        }else{
            $sm = ShippingMethod::findOrFail($id);
            $notify[] = ['success', 'Shipping Method Updated Successfully'];
        }

        $sm->name         = $request->name;
        $sm->charge       = $request->charge;
        $sm->shipping_time= $request->deliver_in;
        $sm->description  = $request->description;
        $sm->save();

        return redirect()->back()->withNotify($notify);
    }

    public function delete(ShippingMethod $id)
    {
        $id->delete();
        $notify[] = ['success', 'Shipping Method Deleted Successfully'];
        return redirect()->back()->withNotify($notify);
    }

    public function changeStatus(Request $request)
    {
        $method = ShippingMethod::findOrFail($request->id);
        if ($method) {
            if ($method->status == 1) {
                $method->status = 0;
                $msg = 'Activated Successfully';
            } else {
                $method->status = 1;
                $msg = 'Deactivated Successfully';
            }
            $method->save();
            return response()->json(['success' => true, 'message' => $msg]);
        }
    }

}
