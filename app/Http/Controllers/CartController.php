<?php

namespace App\Http\Controllers;

use App\Repositories\Cart;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Repositories\Package;
use App\Repositories\Activity;
use App\Repositories\PackageType;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('cart');
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
        if (! $request->has(['package_type_id', 'day', 'package_id', 'qty', 'price'])) {
            return response()->json(['success' => false, 'data' => 'You must provide `package_type_id`, `day`, `package_id`, `qty`, `price`']);
        }
        
        $cart = Session::has('cart') ? Session::get('cart') : [];

        $package_type = $cart[$request->package_type_id] = $cart[$request->package_type_id] ?? [];
        $day = $cart[$request->package_type_id][$request->day] = $package_type[$request->day] ?? [];
        $package = $cart[$request->package_type_id][$request->day][$request->package_id] = $day[$request->package_id] ?? [];
        $packageResponse = Package::first($request->package_id);

        if ($packageResponse['status'] == 'success') {
            $oldQty = $package['qty'] ?? $request->qty;
            $package['qty'] = $request->qty;
            $package['price'] = $packageResponse['data']->price;
            $package['join_concert'] = $request->has('join_concert') && ( $request->join_concert == 1 || $request->join_concert == 'true') ? 'true' : 'false';
            $package['concerts'] = $package['concerts'] ?? [];

            if (!$package['join_concert'] || $package['join_concert'] == 'false') {
                $package['concerts'] = [];
            }

            if ($package['join_concert'] && $request->has(['concert_id', 'concert_price', 'concert_qty'])) {

                $concertResponse = Activity::first($request->concert_id);

                if ($concertResponse['status'] == 'success') {
                    $package['concerts'][$request->concert_id] = [
                        'price' => $concertResponse['data']->price,
                        'qty' => $request->concert_qty
                    ];
                }
            }
            
            if ($request->has(['add_on_id', 'add_on_price', 'add_on_qty'])) {

                $activityResponse = Activity::first($request->add_on_id);

                if ($activityResponse['status'] == 'success') {
                    $package['activities'][$request->add_on_id] = [
                        'price' => $activityResponse['data']->price,
                        'qty' => $request->add_on_qty
                    ];
                }
            }

            if (isset($package['activities']) && sizeof($package['activities']) > 0) {
                foreach ($package['activities'] as $activity_id => $activity) {
                    $package['activities'][$activity_id]['qty'] += $request->qty - $oldQty;
                    if ($package['activities'][$activity_id]['qty'] < $request->qty) {
                        
                    }
                }
            }

            

            $cart[$request->package_type_id][$request->day][$request->package_id] = $package;
        }
        

        Session::put('cart', $cart);
        Session::flash('ses_package', $request->all());

        $html = $this->renderHtml($request->all());

        return response()->json(['success' => true, 'data' => $request->all(), 'cart' => $cart, 'html' => $html]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        if (! $request->has(['package_type_id', 'day', 'package_id'])) {
            return response()->json(['success' => false, 'data' => 'You must provide `package_type_id`, `day`, `package_id`']);
        }
        
        $cart = Session::has('cart') ? Session::get('cart') : [];

        if (count($cart) < 1) {
            return response()->json(['success' => false, 'data' => 'There are no cart.']);
        }

        if (!isset($cart[$request->package_type_id])) {
            return response()->json(['success' => false, 'data' => 'Package type id doesn\'t match.']);
        }

        if (!$cart[$request->package_type_id][$request->day]) {
            return response()->json(['success' => false, 'data' => 'Package day doesn\'t match.']);
        }

        if (!$cart[$request->package_type_id][$request->day][$request->package_id]) {
            return response()->json(['success' => false, 'data' => 'Package id doesn\'t match.']);
        }

        unset($cart[$request->package_type_id][$request->day][$request->package_id]);

        Session::put('cart', $cart);
        Session::flash('ses_package', $request->all());

        $html = $this->renderHtml();


        return response()->json(['success' => true, 'data' => $request->all(), 'html' => $html]);
    }

    protected function renderHtml($ses_package = [])
    {
        $pacakageType = PackageType::all();
        $types = [];
        $total = 0;
        $cart_items = 0;
        if ($pacakageType['status'] === 'success') {
            $types = $pacakageType['data'];

            $cart = Session::has('cart') ? Session::get('cart') : [];

            if (count($cart) > 0 && count($types) > 0) {
                foreach($types as $type) {
                    if (count($type->days()) > 0) {
                        foreach($type->days() as $day => $packages) {
                            if (count($packages) > 0) {
                                foreach($packages as $package) {
                                    $cart_type = $cart[$type->id] ?? null;
                                    $cart_day = $cart_type[$day] ?? null;
                                    $car_package = $cart_day[$package->id] ?? null;
                                    $activities = $car_package['activities'] ?? [];
                                    $concerts = $car_package['concerts'] ?? [];
                                    $qty = $car_package['qty'] ?? 0;
                                    
                                    if ($qty > 0) {
                                        $cart_items++;
                                        if (count($activities) > 0) {
                                            foreach ($activities as $activity) {
                                                if (isset($activity['price'], $activity['qty'])) {
                                                    $total += $activity['price'] * $activity['qty'];
                                                }
                                            }
                                           
                                        }

                                        if (count($concerts) > 0) {
                                            foreach ($concerts as $concert) {
                                                if (isset($concert['price'], $concert['qty'])) {
                                                    $total += $concert['price'] * $concert['qty'];
                                                }
                                            }
                                           
                                        } else {
                                            $total += $package->price * $qty;
                                        }
                                        
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }

        Session::put('cart_items', $cart_items);
        
        return view('packages', compact('types', 'total', 'ses_package'))->render();
    }

    public function clear()
    {
        if (Session::has('cart')) {
            Session::forget('cart');
        }

        if (Session::has('cart_items')) {
            Session::forget('cart_items');
        }

        return redirect(route('home'));
    }

    public function getPackageQuantity(Request $request, $package_id)
    {
        try {
            $package = Package::first($package_id);

            if ($package['status'] === 'success') {
                return response()->json(['success' => true, 'data' => 'Package exists', 'qty' => $package['data']->quantity]);
            }
            
            return response()->json(['success' => false, 'data' => 'Package doesn\'t found.']);
        } catch (\Exception $ex) {
            return response()->json(['success' => false, 'data' => $ex->getmessage()]);
        }
    }

    public function removeAddon(Request $request)
    {
        if (! $request->has(['package_type_id', 'day', 'package_id', 'qty', 'price'])) {
            return response()->json(['success' => false, 'data' => 'You must provide `package_type_id`, `day`, `package_id`, `qty`, `price`']);
        }
        
        $cart = Session::has('cart') ? Session::get('cart') : [];

        $package_type = $cart[$request->package_type_id] = $cart[$request->package_type_id] ?? [];
        $day = $cart[$request->package_type_id][$request->day] = $package_type[$request->day] ?? [];
        $package = $cart[$request->package_type_id][$request->day][$request->package_id] = $day[$request->package_id] ?? [];

        $packageResponse = Package::first($request->package_id);

        if ($packageResponse['status'] == 'success') {
            $package['qty'] = $request->qty;
            $package['price'] = $packageResponse['data']->price;
            
            if ($request->has('add_on_id')) {
                // $package['activities'][$request->add_on_id] = $request->add_on_price;

                if ( isset($package['activities'][$request->add_on_id]) ) {
                    unset($package['activities'][$request->add_on_id]);
                }
            }

            $cart[$request->package_type_id][$request->day][$request->package_id] = $package;
        }
        

        Session::put('cart', $cart);
        Session::flash('ses_package', $request->all());

        $html = $this->renderHtml($request->all());

        return response()->json(['success' => true, 'data' => $request->all(), 'cart' => $cart, 'html' => $html]);
    }

    public function removeConcert(Request $request)
    {
        if (! $request->has(['package_type_id', 'day', 'package_id', 'qty', 'price'])) {
            return response()->json(['success' => false, 'data' => 'You must provide `package_type_id`, `day`, `package_id`, `qty`, `price`']);
        }
        
        $cart = Session::has('cart') ? Session::get('cart') : [];

        $package_type = $cart[$request->package_type_id] = $cart[$request->package_type_id] ?? [];
        $day = $cart[$request->package_type_id][$request->day] = $package_type[$request->day] ?? [];
        $package = $cart[$request->package_type_id][$request->day][$request->package_id] = $day[$request->package_id] ?? [];

        $packageResponse = Package::first($request->package_id);

        if ($packageResponse['status'] == 'success') {

            $package['qty'] = $request->qty;
            $package['price'] = $packageResponse['data']->price;
            
            if ($request->has('concert_id')) {
                // $package['activities'][$request->concert_id] = $request->add_on_price;

                if ( isset($package['concerts'][$request->concert_id]) ) {
                    unset($package['concerts'][$request->concert_id]);
                }
            }

            $cart[$request->package_type_id][$request->day][$request->package_id] = $package;
        }

        Session::put('cart', $cart);
        Session::flash('ses_package', $request->all());

        $html = $this->renderHtml($request->all());

        return response()->json(['success' => true, 'data' => $request->all(), 'cart' => $cart, 'html' => $html]);
    }

    public function cartTotal(Request $request)
    {
        $total = Cart::total();

        if ($request->ajax()) {
            return response()->json(['success' => true, 'total' => $total]);
        }

        return Cart::total();
    }

    public function ajaxIndex(Request $request)
    {
        $html = $this->renderHtml();

        return response()->json([
            'success' => true, 
            'html' => $html,
            'cart' => Session::get('cart')
        ]);
    }

    public function checkActivity(Request $request)
    {
        $packageResponse = Package::first($request->package_id);

        if ($packageResponse['status'] == 'success') {
            if ($request->has('concert_id')) {
                $activityIdType = 'concert_id';
                $activityQtyType = 'concert_qty';
            } else if ($request->has('add_on_id')) {
                $activityIdType = 'add_on_id';
                $activityQtyType = 'add_on_qty';
            }
            
            $activity = $packageResponse['data']->activities()->where('activity_id', $request->{$activityIdType})->first();

            if ($activity) {
                $dailyActivityQtys = DB::table('order_details')
                    ->leftJoin('order_activities', 'order_activities.order_detail_id', '=', 'order_details.id')
                    ->where('order_details.type_id', $request->package_type_id)
                    ->where('order_details.package_id', $request->package_id)
                    ->where('order_details.day_name', $request->day)
                    ->where('order_activities.activity_id', $request->{$activityIdType})
                    ->select(DB::raw("sum(order_activities.qty) as total"))
                    ->first();
                $userActivityQtys = DB::table('order_details')
                    ->leftJoin('orders', 'orders.id', '=', 'order_details.order_id')
                    ->leftJoin('order_activities', 'order_activities.order_detail_id', '=', 'order_details.id')
                    ->where('orders.user_id', Auth::user()->id)
                    ->where('order_details.type_id', $request->package_type_id)
                    ->where('order_details.type_id', $request->package_type_id)
                    ->where('order_details.package_id', $request->package_id)
                    ->where('order_details.day_name', $request->day)
                    ->where('order_activities.activity_id', $request->{$activityIdType})
                    ->select(DB::raw("sum(order_activities.qty) as total"))
                    ->first();
                $dayLimit = $activity->pivot->day_limit - $dailyActivityQtys->total;
                $limitPerVisitor = $activity->pivot->limit_per_visitor - $userActivityQtys->total;

                if ($request->{$activityQtyType} > $limitPerVisitor) {
                    return response()->json([
                        'success' => false,
                        'data' => "Your maxium limit for {$activity->name} is {$limitPerVisitor}",
                        'limitPerVisitor' => $request->{$activityQtyType}
                    ]);
                }

                if ($request->{$activityQtyType} > $dayLimit) {
                    return response()->json([
                        'success' => false,
                        'data' => "{$request->day} maxium limit for {$activity->name} is {$dayLimit}",
                    ]);
                }

                return response()->json([
                    'success' => true,
                    'activity' => $activity->pivot->day_limit,
                    'activities' => $activity->pivot->limit_per_visitor,
                    'dailyActivityQtys' => $dailyActivityQtys->total,
                    'dayLimit' => $dayLimit
                ]);
            }
        }
        return response()->json([
            'success' => false,
            'data' => 'Data mismatch.',
        ]);
    }
}
