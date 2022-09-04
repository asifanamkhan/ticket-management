<?php

namespace App\Http\Controllers;

use App\Mail\AddonPurchaseCancel;
use App\Mail\AddonPurchaseSuccess;
use App\Mail\OrderCancle;
use App\Mail\OrderSuccess;
use App\Mail\OrderError;
use App\Repositories\Activity;
use App\Repositories\Order\ActivityPayment;
use App\Repositories\Order\Order;
use App\Repositories\Order\OrderActivity;
use App\Repositories\Package;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Paytabs\Contracts\Paytabs;

class PaymentController extends Controller
{

    public function paytabsCallback(Request $request, Paytabs $paytabs)
    {
        try{

            $data = [
                'type' => 'Callback',
                'data' => request()->all()
            ];
            Log::alert(json_encode($data));

            // $signature= $request->header('signature');
            // $content = $request->getContent();

            // if ($paytabs->isValidIpn($content, $signature)) {

                // Update Order Status

                $cartId = $request->cart_id ?? null;
                $transactionId = $request->tran_ref ?? null;
                $status = $request->payment_result['response_status'] ?? 'E';

                $respMessage = $request->payment_result['response_message'] ?? null;
                $respCode = $request->payment_result['response_code'] ?? null;
                $customerEmail = $request->customer_details['email'] ?? null;

                //dd($customerEmail);

                $order = Order::first($cartId, 'cart_id');
                //$order = Order::first(1);
                //dd($order);
                //Mail::to('somuddro249@gmail.com')->send(new OrderSuccess($order['data']));
                //dd(5);

            if ($status === 'A') {

                    if ($order['status'] === 'success') {

                        if($order['data']->cart_id == '' || $order['data']->cart_id == $cartId){

                            $orderStatus = Order::update($order['data']->id,
                                [
                                    'cart_id' =>  $cartId,
                                    'status' => 'completed',
                                    'tran_ref' => $transactionId,
                                    'resp_message' => $respMessage,
                                    'resp_code' => $respCode,
                                ]);
                        }

                        if(isset($order['data']->orderDetails) && count($order['data']->orderDetails) > 0){
                            foreach ($order['data']->orderDetails as $orderDetail){
                                $package = Package::first($orderDetail->package_id);
                                if($package['status'] === 'success'){
                                    if($orderDetail->qty <= $package['data']->quantity) {
                                        $response = Package::updateQuantity($package['data']->id, [
                                            'quantity' => (int)$package['data']->quantity - (int)$orderDetail->qty,
                                        ]);
                                    }

                                }

                            }
                        }

                         if($customerEmail) {
                            Mail::to($customerEmail)->send(new OrderSuccess($order['data']));
                        }

                    }
                }

                if ($status === 'C') {

                    if($customerEmail) {
                        Mail::to($customerEmail)->send(new OrderCancle($order['data']));
                    }
                }

                if ($status === 'D') {

                    if($customerEmail) {
                        Mail::to($customerEmail)->send(new OrderError());
                    }
                }

                if ($status === 'E') {

                    if($customerEmail) {
                        Mail::to($customerEmail)->send(new OrderError());
                    }
                }

                // Return Response
                $response= 'valid IPN request. Cart updated';
                return response($response, 200)->header('Content-Type', 'text/plain');
                
            // }


        }catch(\Exception $e) {

            $data = [
                'type' => 'Callback',
                'data' => $e->getMessage()
            ];

            Log::alert(json_encode($data));

            return response($e->getMessage(), 400)
                ->header('Content-Type', 'text/plain');        
        }
    }

    public function completed(Request $request){

        $data = [
            'type' => 'Payment redirect.',
            'data' => request()->all()
        ];

        Log::alert(json_encode($data));

        $status = $request->respStatus ?? 'E';
        //dd($request->customerEmail);
        $message = 'Something went wrong. Please contact with support.';

        $order = Order::first($request->cartId, 'cart_id');

        if($order['status'] === 'success'){
            if ($status === 'A') {

//                if($request->customerEmail) {
//                    Mail::to($request->customerEmail)->send(new OrderSuccess($order['data']));
//                }


                if (Session::has('cart')) {

                    Session::forget('cart');
                    Session::forget('ses_package');
                    Session::forget('cart_items');
                }
                $message = 'Payment completed. Thanks for the purchase.';
            }

            if ($status === 'C') {
                $message = 'Payment canceled.';

            }

            if ($status === 'D') {
                $message = 'Payment declined or rejected.';

            }

            if ($status === 'E') {
                $message = 'Something went wrong.';
            }

            session()->flash('thankyou_message', $message);
            return redirect()->route('checkout.index');
        }


    }

    public function paytabsAdonCallback(Request $request, Paytabs $paytabs){
        try{
            $data = [
                'type' => 'Callback',
                'data' => request()->all()
            ];

            Log::alert(json_encode($data));

            $cartId = $request->cart_id ?? null;
            $transactionId = $request->tran_ref ?? null;
            $status = $request->payment_result['response_status'] ?? 'E';

            $respMessage = $request->payment_result['response_message'] ?? null;
            $respCode = $request->payment_result['response_code'] ?? null;
            $customerEmail = $request->customer_details['email'] ?? null;


            $data = Session::get('addAddonCart');

            $package = Package::first($data['package_id']);
            if ($package['status'] === 'success'){
                $data['package_name'] = $package['data']->name;
            }
            //dd($data);

            if(count($data) > 0){

                $price = (int)$data['qty'] * (float)$data['adon_price'];
            }

            if ($status === 'A') {
                $message = 'Payment completed. Thanks for the purchase.';

                $add_on = OrderActivity::searchAddon(
                    $data['order_detail_id'],
                    $data['activity_id']
                );

                if(isset($add_on) && $add_on['status'] === 'success'){
                    $response = OrderActivity::update($add_on['data']->id, [
                        'qty' => (int)$data['qty'] + (int)$add_on['data']->qty,
                    ]);


                    $order_activity_id = $add_on['data']->id;

                }
                else{

                    $activity = Activity::first($data['activity_id']);

                    if ($activity['status'] === 'success'){

                        $response = OrderActivity::save([
                            'order_detail_id'       => $data['order_detail_id'],
                            'name'                  => $activity['data']->name,
                            'activity_id'           => $activity['data']->id,
                            'arabic_name'           => $activity['data']->arabic_name,
                            'description'           => $activity['data']->description,
                            'arabic_description'    => $activity['data']->arabic_description,
                            'price'                 => $activity['data']->price,
                            'qty'                   => $data['qty'],
                            'images'                => $activity['data']->images,
                        ]);

                        if($response['status'] === 'success'){

                            $order_activity_id = $response['data']->id;
                        }
                    }

                }

                $orderActivityPayment = ActivityPayment::save(
                    [
                        'cart_id' => $cartId,
                        'order_activity_id' => $order_activity_id,
                        'status' => 'Completed',
                        'tran_ref' => $transactionId,
                        'resp_message' => $respMessage,
                        'resp_code' => $respCode,
                        'qty' => $data['qty'],
                        'payment_price' => $price,
                        'adon_price' => $data['adon_price'],

                    ]);

                if($customerEmail){
                    Mail::to($customerEmail)->send(new AddonPurchaseSuccess(
                        $data, $cartId, $transactionId, $price
                    ));
                }

                if (Session::has('addAddonCart')) {
                    Session::forget('addAddonCart');
                }

            }

            if ($status === 'C') {

                if($customerEmail){
                    Mail::to($customerEmail)->send(new AddonPurchaseCancel(
                        $data, $cartId, $transactionId, $price
                    ));
                }

            }

            if ($status === 'D') {

                if($customerEmail) {
                    Mail::to($customerEmail)->send(new OrderError());
                }
            }

            if ($status === 'E') {

                if($customerEmail) {
                    Mail::to($customerEmail)->send(new OrderError());
                }

            }

            $response= 'valid IPN request. Add on updated';
            return response($response, 200)->header('Content-Type', 'text/plain');



        }catch (\Exception $e){
            $data = [
                'type' => 'Callback',
                'data' => $e->getMessage()
            ];

            Log::alert(json_encode($data));

            return response($e->getMessage(), 400)
                ->header('Content-Type', 'text/plain');
        }
    }

    public function addon(Request $request){

        $cartId = $request->cartId ?? null;
        $transactionId = $request->tranRef ?? null;
        $status = $request->respStatus ?? 'E';
        //$status = 'A';
        $respMessage = $request->respMessage ?? null;
        $respCode = $request->respCode ?? null;
        $customerEmail = $request->customerEmail ?? null;


        $data = Session::get('addAddonCart');

        $package = Package::first($data['package_id']);
        if ($package['status'] === 'success'){
            $data['package_name'] = $package['data']->name;
        }
        //dd($data);

//        if(count($data) > 0){
//
//            $price = (int)$data['qty'] * (float)$data['adon_price'];
//        }

        if ($status === 'A') {
            $message = 'Payment completed. Thanks for the purchase.';

//            $add_on = OrderActivity::searchAddon(
//                $data['order_detail_id'],
//                $data['activity_id']
//            );
//
//            if(isset($add_on) && $add_on['status'] === 'success'){
//                $response = OrderActivity::update($add_on['data']->id, [
//                    'qty' => (int)$data['qty'] + (int)$add_on['data']->qty,
//                ]);
//
//
//                $order_activity_id = $add_on['data']->id;
//
//            }
//            else{
//
//                $activity = Activity::first($data['activity_id']);
//
//                if ($activity['status'] === 'success'){
//
//                    $response = OrderActivity::save([
//                        'order_detail_id'       => $data['order_detail_id'],
//                        'name'                  => $activity['data']->name,
//                        'activity_id'           => $activity['data']->id,
//                        'arabic_name'           => $activity['data']->arabic_name,
//                        'description'           => $activity['data']->description,
//                        'arabic_description'    => $activity['data']->arabic_description,
//                        'price'                 => $activity['data']->price,
//                        'qty'                   => $data['qty'],
//                        'images'                => $activity['data']->images,
//                    ]);
//
//                    if($response['status'] === 'success'){
//
//                        $order_activity_id = $response['data']->id;
//                    }
//                }
//
//
//            }
//
//            $orderActivityPayment = ActivityPayment::save(
//                [
//                    'cart_id' => $cartId,
//                    'order_activity_id' => $order_activity_id,
//                    'status' => 'Completed',
//                    'tran_ref' => $transactionId,
//                    'resp_message' => $respMessage,
//                    'resp_code' => $respCode,
//                    'qty' => $data['qty'],
//                    'payment_price' => $price,
//                    'adon_price' => $data['adon_price'],
//
//                ]);
//
//            if($customerEmail){
//                Mail::to($customerEmail)->send(new AddonPurchaseSuccess(
//                    $data, $cartId, $transactionId, $price
//                ));
//            }

            if (Session::has('addAddonCart')) {
                Session::forget('addAddonCart');
            }

        }

        if ($status === 'C') {
            $message = 'Payment canceled.';

//            if($customerEmail){
//                Mail::to($customerEmail)->send(new AddonPurchaseCancel(
//                    $data, $cartId, $transactionId, $price
//                ));
//            }

        }

        if ($status === 'D') {
            $message = 'Payment declained or rejected.';
//            if($customerEmail) {
//                Mail::to($customerEmail)->send(new OrderError());
//            }
        }

        if ($status === 'E') {
            $message = 'Something went wrong.';

//            if($customerEmail) {
//                Mail::to($customerEmail)->send(new OrderError());
//            }

        }

        session()->flash('order-add-on-update', $message);
        return redirect()->route('visitor.orders.show',$data['order_id']);

    }

}
