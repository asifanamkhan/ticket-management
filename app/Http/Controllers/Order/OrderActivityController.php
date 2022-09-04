<?php

namespace App\Http\Controllers\Order;

use App\Models\Order\OrderDetails;
use App\Repositories\Order\ActivityPayment;
use App\Repositories\Order\OrderActivity;
use App\Repositories\Package;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Order\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Paytabs\Contracts\Paytabs;
use Paytabs\Repositories\CustomerDetails;

class OrderActivityController extends Controller
{
    /**
     * Store or Update resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function addAddon(Request $request, Paytabs $client, CustomerDetails $customerDetail){

        try{
            Session::put('addAddonCart', $request->input());

            $price = (int)$request->qty * (float)$request->adon_price;


            // Payment
            $cart_id_response = ActivityPayment::cartNoGenerate();
            if($cart_id_response ['status']  === 'success'){
                $cart_id = $cart_id_response ['data'];
            }

            $user = Auth::user();
            $name = $user->first_name.' '.$user->last_name;

            $customerDetails = $customerDetail
                ->setName($name ?? '')
                ->setEmail(auth()->user()->email ?? '')
                ->setAddress($user->address ?? '')
                ->setPhone($user->mobile ?? '')
                ->setState('')
                ->setCity($user->city ?? '')
                ->setCountry('')
                ->setZip('')
                ->setIP($request->ip())
                ->build();

            return $client->transactionType('sale')
                ->transactionClass('ecom')
                ->cartId($cart_id)
                ->setCartDescription('Add on order description')
                ->setCartCurrency(config('paytabs.currency', 'USD'))
                ->setCartAmount($price)
                ->setReturnUrl(route('paytabs.addon.return'))
                ->setCallbackUrl(route('paytabs.addon.callback'))
                ->setCustomerDetails($customerDetails)
                ->setHideShipping(true)
                ->createPayPage();

            //return redirect()->route('paytabs.addon.return');

        }
        catch (\Exception $exception){
            throw new \Exception($exception->getMessage());
        }

    }

}
