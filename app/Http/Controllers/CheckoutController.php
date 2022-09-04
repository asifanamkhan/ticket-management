<?php

namespace App\Http\Controllers;

use App\Mail\OrderSuccess;
use App\Models\Day;

use App\Models\Package;
use App\Models\Activity;
use App\Repositories\Order\OrderCustomer;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Paytabs\Contracts\Paytabs;

use App\Repositories\Order\Order;
use App\Repositories\PackageType;
use Illuminate\Support\Facades\DB;
use App\Repositories\Country\Country;
use App\Repositories\Order\OrderName;
use Paytabs\Repositories\BaseDetails;
use Illuminate\Support\Facades\Session;
use App\Repositories\Order\OrderDetails;
use App\Repositories\Order\OrderActivity;
use Illuminate\Support\Facades\Validator;
use Paytabs\Repositories\CustomerDetails;
use Paytabs\Repositories\ShippingDetails;
use Paytabscom\Laravel_paytabs\Facades\paypage;

class CheckoutController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(CustomerDetails $customerDetail, Paytabs $client)
    {

        $cart = Session::has('cart') ? Session::get('cart') : [];
        $results = [];
        $errors = [];

        // dd($cart);

        if (count($cart) > 0) {
            
            foreach ($cart as $type_id => $days) {
                $type = PackageType::first($type_id);

                if ($type['status'] === 'success') {

                    $package_type = $type['data'];
                    $paclage_days = [];
                    

                    foreach ($days as $day => $packages) {
                        $day = Day::whereName($day)->first();
                        $day_packages = [];
                        foreach($packages as $package_id => $package_cart) {
                            $package = Package::find($package_id);    

                            if($package_cart['qty'] > $package->quantity){
                                $errors[] = "Pacakge type `{$package->package_type->name}` Day `{$package->day->name}` Package `{$package->name}` left `{$package->quantity}` item(s) but your cart has `{$package_cart['qty']}`.";
                            }

                            if (isset($package_cart['activities']) && count($package_cart['activities']) > 0) {
                                $activities = [];
                                foreach ($package_cart['activities'] as $activity_id => $value) {
                                    if ($value['qty'] < 1) continue;
                                    $activity = Activity::find($activity_id);
                                    $activity->qty = $value['qty'];
                                    $activities[] = $activity;
                                }
                                $package_cart['activities'] = $activities;
                            }

                            if (isset($package_cart['concerts']) && count($package_cart['concerts']) > 0) {
                                $concerts = [];
                                foreach ($package_cart['concerts'] as $concert_id => $value) {
                                    if ($value['qty'] < 1) continue;
                                    $concert = Activity::find($concert_id);
                                    $concert->qty = $value['qty'];
                                    $concerts[] = $concert;
                                }
                                $package_cart['concerts'] = $concerts;
                            }

                            $package->cart = $package_cart;
                            $day_packages[$package->name] = $package;
                        }

                        $day->packages = $day_packages;
                        $paclage_days[$day->name] = $day;
                    } 

                    $package_type->days = $paclage_days;

                    // $data = $type['data']->packages()
                    //             ->leftJoin('days', 'packages.day_id', '=', 'days.id')
                    //             ->select('days.name as day_name', 'packages.*')
                    //             ->where('packages.id', '=', 2)
                    //             ->get()
                    //             ->groupBy('day_name');                    
                    $results[$package_type->name] = $package_type;
                }
            }
        }
        
        if (sizeof($errors) > 0) {
            Session::flash('cart_errors', $errors);
            return redirect(route('home'));
        }

        //dd($results);

        return view('checkout',compact('results'));
    }


    /**
     * @param Request $request
     * @param Paytabs $client
     * @param CustomerDetails $customerDetail
     * @param ShippingDetails $shippingDetail
     * @return \Illuminate\Http\RedirectResponse|string
     */
    public function checkout(Request $request, Paytabs $client, CustomerDetails $customerDetail, ShippingDetails $shippingDetail)
    {

        $rules = [
            'customer_name' => 'required',
            // 'customer_email' => 'required',
            'customer_address' => 'required',
            'customer_phone' => 'required|numeric|min:10',
            'customer_country_id' => 'required',
            'customer_state' => 'required',
            'customer_city' => 'required',
            'customer_zip' => 'required',
        ];

        if ($request->has('packages') && count($request->packages) > 0) {
            foreach($request->packages as $id => $package) {
                
                $rules["package_{$id}_qty"] = "required";
                $rules["package_{$id}_price"] = "required";

                for($i = 1; $i < $package['qty']; $i++) {
                    $rules["package_{$id}_name_{$i}"] = "required";
                }
            }
        }

        $user = auth()->user();

        $country = Country::first($request->customer_country_id);
        $customerCountry = '';
        if ($country['status'] === 'success') {
            $customerCountry = $country['data']->code;
            $countryName = $country['data']->name;
        }

        $user->mobile = $request->customer_phone ?? $user->mobile;
        $user->address = $request->customer_address ?? $user->address;
        $user->country_id = $request->customer_country_id ?? $user->country_id;
        $user->city = $request->customer_city ?? $user->city;
        $user->state = $request->customer_state ?? $user->state;
        $user->zip = $request->customer_zip ?? $user->zip;
        $user->save();


        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        if (cart_total() > 0) {

            $cart_id_response = Order::cartNoGenerate();
            if($cart_id_response ['status']  === 'success'){
                $cart_id = $cart_id_response ['data'];
            }

            if(Session::has('cart')){

                $cart = Session::get('cart');

                //check package quantity
                $errors = [];
                foreach ($cart as $type_id => $days) {
                    foreach ($days as $day => $packages) {
                        foreach($packages as $package_id => $package_cart) {
                            $package = Package::find($package_id);
                            if($package->quantity <= $package_cart['qty']){
                                $errors[] = "Package type `{$package->package_type->name}` Day `{$package->day->name}` Package `{$package->name}` left `{$package->quantity}` item(s) but your cart has `{$package_cart['qty']}`.";
                            }
                        }
                    }
                }
                if (sizeof($errors) > 0) {
                    Session::flash('cart_errors', $errors);
                    return redirect(route('home'));
                }


                //save order data
                $order = Order::save([
                    'user_id' => auth()->user()->id,
                    'cart_id' => $cart_id,
                    'cart_total' => cart_total(),
                    'is_admin' => 0,
                ]);

                //Order name insert
                if($order['status'] === 'success'){

                    $orderDetails ['order_id'] = $order['data']->id;

                    foreach ($cart as $type_id => $days) {

                        $package_type = PackageType::first($type_id);

                        if($package_type['status'] === 'success'){
                            $orderDetails['type_id'] = $package_type['data']->id;
                            $orderDetails['type_name'] = $package_type['data']->name;
                            $orderDetails['type_arabic_name'] = $package_type['data']->arabic_name;
                        }

                        foreach ($days as $day => $packages) {
                            $day = Day::whereName($day)->first();

                            //assign order package day
                            $orderDetails['day_code'] = $day->code;
                            $orderDetails['day_name'] = $day->name;
                            $orderDetails['day_arabic_name'] = $day->arabic_name;
                            $orderDetails['day_from'] = $day->day_from;
                            $orderDetails['day_to'] = $day->day_to;

                            foreach($packages as $package_id => $package_cart) {

                                $package = Package::find($package_id);

                                //assign order package name
                                $orderDetails['package_id']         = $package->id;
                                $orderDetails['name']               = $package->name;
                                $orderDetails['arabic_name']        = $package->arabic_name;
                                $orderDetails['description']        = $package->description;
                                $orderDetails['arabic_description'] = $package->arabic_description;
                                $orderDetails['price']              = $package->price;
                                $orderDetails['gate_access']        = $package->gate_access;
                                $orderDetails['qty']                = $package_cart['qty'];
                                $orderDetails['fixed_quantity']     = $package->fixed_quantity;

                                $orderDetail = OrderDetails::save($orderDetails);

                                if ($orderDetail['status'] == 'success') {

                                    $freeActivities = $package->activities()->wherePrice(0)->get();

                                    if(count($freeActivities) > 0) {

                                        foreach ($freeActivities as $activity) {

                                            //Save data order details with free activities
                                            $response = OrderActivity::save([
                                                'order_detail_id'       => $orderDetail['data']->id,
                                                'name'                  => $activity->name,
                                                'activity_id'           => $activity->id,
                                                'arabic_name'           => $activity->arabic_name,
                                                'description'           => $activity->description,
                                                'arabic_description'    => $activity->arabic_description,
                                                'price'                 => $activity->price,
                                                'qty'                   => $package_cart['qty'],
                                                'images'                => $activity->images,
                                            ]);
                                        }
                                    }

                                    if (isset($package_cart['concerts']) && count($package_cart['concerts']) > 0) {
                                        foreach ($package_cart['concerts'] as $concert_id => $value) {

                                            //assign activity name
                                            $concert = Activity::find($concert_id);
                                            
                                            //Save data order details with free activities
                                            $response = OrderActivity::save([
                                                'order_detail_id'       => $orderDetail['data']->id,
                                                'name'                  => $concert->name,
                                                'activity_id'           => $concert->id,
                                                'arabic_name'           => $concert->arabic_name,
                                                'description'           => $concert->description,
                                                'arabic_description'    => $concert->arabic_description,
                                                'price'                 => $concert->price,
                                                'qty'                   => $value['qty'],
                                                'images'                => $concert->images,
                                            ]);

                                        }
                                    }

                                    if (isset($package_cart['activities']) && count($package_cart['activities']) > 0) {
                                        foreach ($package_cart['activities'] as $activity_id => $value) {

                                            //assign activity name
                                            $activity = Activity::find($activity_id);
                                            
                                            //Save data order details with free activities
                                            $response = OrderActivity::save([
                                                'order_detail_id'       => $orderDetail['data']->id,
                                                'name'                  => $activity->name,
                                                'activity_id'           => $activity->id,
                                                'arabic_name'           => $activity->arabic_name,
                                                'description'           => $activity->description,
                                                'arabic_description'    => $activity->arabic_description,
                                                'price'                 => $activity->price,
                                                'qty'                   => $value['qty'],
                                                'images'                => $activity->images,
                                            ]);

                                        }
                                    }

                                    //Save Order name
                                    if ($request->has('packages') && count($request->packages) > 0) {
                                        foreach ($request->packages as $id => $p) {
                                            if ($package->id == $id) {
                                                for ($i = 1; $i < $p['qty']; $i++) {
                                                    $name = 'package_'. $id . '_name_' . $i;
                                                
                                                    $response = OrderName::save([
                                                        'order_detail_id' => $orderDetail['data']->id,
                                                        'name' => $request->{$name}
                                                    ]);
                                                }
                                            }
                                        }
                                    }
                                }

                            }

                        }
                    }

                    //Save Customer name

                    $response = OrderCustomer::save([
                        'order_id' => $order['data']->id,
                        'user_id' => $user->id,
                        'name' => $request->customer_name,
                        'email' => $user->email ?? null,
                        'address' => $request->customer_address ?? null,
                        'phone' => $request->customer_phone ?? null,
                        'state' => $request->customer_state ?? null,
                        'city' => $request->customer_city ?? null,
                        'country' => $countryName ?? null,
                        'zip' => $request->customer_zip ?? null,
                    ]);


                }

            }

            // Payment

            $customerDetails = $customerDetail
                ->setName($request->customer_name ?? '')
                ->setEmail(auth()->user()->email ?? '')
                ->setAddress($request->customer_address ?? '')
                ->setPhone($request->customer_phone ?? '')
                ->setState($request->customer_state ?? '')
                ->setCity($request->customer_city ?? '')
                ->setCountry($customerCountry)
                ->setZip($request->customer_zip ?? '')
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
                ->cartId($cart_id)
                ->setCartDescription("Cart {$cart_id} description")
                ->setCartCurrency(config('paytabs.currency', 'USD'))
                ->setCartAmount(cart_total())
                ->setReturnUrl(route('paytabs.return'))
                ->setCallbackUrl(route('paytabs.callback'))
                ->setCustomerDetails($customerDetails)
                ->setHideShipping(true)
                ->createPayPage();
            } catch (\Exception $ex) {
                throw new \Exception($ex->getMessage());
            }
            

            //return redirect()->route('paytabs.callback');
        }

        return "You must cart at leas 1 package.";
    }

//    public  function generateRandomString($length = 20) {
//        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
//        $charactersLength = strlen($characters);
//        $randomString = '';
//        for ($i = 0; $i < $length; $i++) {
//            $randomString .= $characters[rand(0, $charactersLength - 1)];
//        }
//        return $randomString;
//    }
}
