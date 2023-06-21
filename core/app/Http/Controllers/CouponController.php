<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Coupon;
use App\GeneralSetting;
use Carbon\Carbon;

class CouponController extends Controller
{
    public function applyCoupon(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code'          => 'required|string',
            'subtotal'      => 'required|numeric|gt:0',
            'categories'    => 'nullable|array|'
        ]);

        if($validator->fails()) {
            return response()->json($validator->errors());
        }

        $general = GeneralSetting::first();

        $now = Carbon::now();

        $coupon = Coupon::where('coupon_code', $request->code)->with('categories')->where('start_date', '<=', $now)->where('end_date', '>=', $now)->where('status', 1)->with(['appliedCoupons', 'categories', 'products'])->first();

        if($coupon){

            // Check Minimum Subtotal
            if($request->subtotal < $coupon->minimum_spend){
                return response()->json(['error' => "Lo sentimos, tienes que pedir una cantidad mínima de $coupon->minimum_spend $general->cur_text"]);
            }

            // Check Maximum Subtotal
            if($coupon->maximum_spend !=null && $request->subtotal > $coupon->maximum_spend){
                return response()->json(['error' => "Lo sentimos, tienes que pedir la cantidad máxima de $coupon->maximum_spend $general->cur_text"]);
            }

            //Check Limit Per Coupon
            if($coupon->appliedCoupons->count() >= $coupon->usage_limit_per_coupon){
                return response()->json(['error' => "Lo sentimos, su cupón ha excedido el límite máximo de uso"]);
            }

            //Check Limit Per User
            if($coupon->appliedCoupons->where('user_id', auth()->id())->count() >= $coupon->usage_limit_per_user){
                return response()->json(['error' => "Lo sentimos, ya alcanzó el límite de uso máximo para este cupón"]);
            }

            $coupon_categories  = $coupon->categories->pluck('id')->toArray();
            $coupon_products    = $coupon->products->pluck('id')->toArray();

            //Check all of the products in cart with coupon's products
            if(empty(array_intersect($coupon_products, $request->products))){
                //Check all of the products in cart with coupon's products
                foreach($request->categories as $cateogires){
                    if(empty(array_intersect($cateogires, $coupon_categories))){
                        return response()->json(['error' => 'El cupón no está disponible para algunos productos en su carrito.']);
                    }
                }
            }


            if($coupon->discount_type == 1){
                $amount = $coupon->coupon_amount;
            }else{
                $amount = $request->subtotal * $coupon->coupon_amount / 100;
            }

            // Check in session

            if(session()->has('coupon') && session('coupon')['code'] == $request->code){
                return response()->json(['error' => 'El cupón ya se aplicó']);
            }


            session()->put('coupon', ['code'=>$request->code,'amount' => $amount]);

            return response()->json([
                'success' => 'Cupón aplicado con éxito',
                'coupon_code'    => $coupon->coupon_code,
                'amount'  => $amount
            ]);
        }else{
            return response()->json(['error' => 'El cupón no existe']);
        }
    }

    public function removeCoupon()
    {
        session()->forget('coupon');
        return response()->json(['success'=>'Cupón eliminado con éxito']);
    }

}
