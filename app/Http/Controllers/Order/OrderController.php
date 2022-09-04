<?php

namespace App\Http\Controllers\Order;

use App\Models\Order\OrderDetails;
use App\Repositories\Country\Country;
use App\Repositories\Order\OrderCustomer;
use App\Repositories\Package;
use App\Repositories\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Order\Order;
use Illuminate\Support\Facades\Session;
use Paytabs\Repositories\CustomerDetails;
use Paytabs\Repositories\ShippingDetails;
use Paytabs\Contracts\Paytabs;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = auth()->user();

        $response = Order::search(['user_id' => $user->id]);

        if($response['status'] === 'success'){
            $orders = $response['data'];
        }


        return view('visitors.orders.index', compact('user','orders'));
    }


    public function payment($order_id, Request $request, Paytabs $client, CustomerDetails $customerDetail, ShippingDetails $shippingDetail){

        $order = Order::first(1);


        if($order['status'] === 'success'){

            $user = OrderCustomer::customer($order['data']->id, $order['data']->user_id);

            if($user['status'] === 'success'){
                $user = $user['data'];

                $customerDetails = $customerDetail
                    ->setName($user->name ?? '')
                    ->setEmail(auth()->user()->email ?? '')
                    ->setAddress($user->address ?? '')
                    ->setPhone($user->mobile ?? '')
                    ->setState($user->state ?? '')
                    ->setCity($user->city ?? '')
                    ->setCountry($user->country ?? '')
                    ->setZip($user->zip ?? '')
                    ->setIP($request->ip())
                    ->build();

                $shippingDetails = isset($request->same_as_billing) && $request->same_as_billing == 'on' ? 'same_as_billing' : null;

                if ($shippingDetails != 'same_as_billing') {
                    $shippingDetails = $shippingDetail
                        ->setName($request->shipping_name ?? '')
                        ->setEmail($request->shipping_email ?? '')
                        ->setAddress($request->shipping_address ?? '')
                        ->setPhone($request->shipping_phone ?? '')
                        ->setState($request->shipping_state ?? '')
                        ->setCity($request->shipping_city ?? '')
                        ->setCountry($request->shipping_country ?? '')
                        ->setZip($request->shipping_zip ?? '')
                        ->setIP($request->ip())
                        ->build();
                }

                try {
                    return $client->transactionType('sale')
                        ->transactionClass('ecom')
                        ->cartId($order['data']->cart_id)
                        ->setCartDescription("Cart {$order['data']->cart_id} description")
                        ->setCartCurrency(config('paytabs.currency', 'USD'))
                        ->setCartAmount($order['data']->cart_total)
                        ->setReturnUrl(route('paytabs.return'))
                        ->setCallbackUrl(route('paytabs.callback'))
                        ->setCustomerDetails($customerDetails)
                        ->setHideShipping(true)
                        ->createPayPage();
                } catch (\Exception $ex) {
                    throw new \Exception($ex->getMessage());
                }
            }
        }
        Session::flash('payment-cancel', 'something went wrong');
        return back();

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $response = Order::first($id);
        $order = $response['data'];

        if ($response['status'] === 'error' ) {
            throw new \Exception($order);
        }

        return view('visitors.orders.order_details', compact('order'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        //
    }
}
