<?php

namespace App\Http\Controllers\Admin\Order;



use App\Http\Controllers\Controller;

use App\Repositories\Activity;
use App\Repositories\Day;
use App\Repositories\Order\Order;
use App\Repositories\Order\OrderActivity;
use App\Repositories\Order\OrderDetails;
use App\Repositories\Package;
use App\Repositories\PackageType;
use App\Repositories\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class OrderManageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $response = Order::all(['orderBy' => ['created_at', 'DESC']]);

        if($response['status'] === 'success'){
            $orders = $response['data'];
        }

        return view('admin.order.index',compact('orders'));
    }

    public function statusFilter(Request $request){
        $response = Order::statusFilter(['status'=>$request->status]);

        if($response['status'] === 'success'){
            $orders = $response['data'];
        }

        return view('admin.order.index',compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $userResponse = User::all();
        $packageTypeResponse = PackageType::all();
        $dayResponse = Day::all();

        $users = [];
        $packageTypes = [];
        $days = [];

        if($userResponse['status'] === 'success'){
            $users = $userResponse['data'];
            //dd($users);
        }

        if($packageTypeResponse['status'] === 'success'){
            $packageTypes = $packageTypeResponse['data'];
        }

        if($dayResponse['status'] === 'success'){
            $days = $dayResponse['data'];
        }


        return view('admin.order.create',compact(
            'users','packageTypes','days'
        ));
    }





    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
<<<<<<< HEAD
        //dd($request->all('types'));
=======
        $types = $request->types ?? [];
        $items = [];
        $total = 0;
>>>>>>> d0a2ce3882c91d352dab7f21ae54a82d3182f501

        try{
            $errors = [];

            $request->validate([
                'user' => 'required',
                'types' => 'required|array|min:1',
                'days' => 'required|array|min:1',
                'packages' => 'required|array|min:1',
            ]);


<<<<<<< HEAD
            $PackageTotal = 0;
            $activityTotal = 0;
            $singlePackageTotal = 0;
            $orderDetails = [];

            $cart_id_response = Order::cartNoGenerate();
            if($cart_id_response ['status']  === 'success'){
                $cart_id = $cart_id_response ['data'];
            }

            $requestPackage = $request->packages ?? [];
            $requestPackageQty = $request->package_activity_qty ?? [];

            if (count($requestPackage) > 0){
                foreach ($request->packages as $key => $package){
                    $package = Package::first($package);
                    if($package['status'] === 'success'){
                        $price = $package['data']->price;
                        $singlePackageTotal = (float)$price * $request->package_qty[$key];
=======
                $package = Package::first($package_id);

                if ($package['status'] == 'success') {
                    $total += $package['data']->price * $package_qty;

                    $activities = $request->package_activities[$package_id] ?? [];
                    $quantities = $request->package_activity_qty[$package_id] ?? [];
    
                    if (!isset($items[$type_id][$day_id][$package_id]['activities'])) {
                        $items[$type_id][$day_id][$package_id]['activities'] = [];
                    }
    
                    //sizeof($activities) ==  sizeof($quantities)
    
                    if (sizeof($activities) > 0 && sizeof($quantities) > 0) {
                        foreach ($activities as $activity_id) {
                            $activity_qty = $quantities[$activity_id];

                            if ($activity_qty < 1) continue;

                            $activity = Activity::first($activity_id);

                            if ($activity['status'] == 'success') {
                                $total += $activity['data'] *  $activity_qty;
                            }

                            $items[$type_id][$day_id][$package_id]['activities'][$activity_id]['qty'] =  $activity_qty;
                        }
>>>>>>> d0a2ce3882c91d352dab7f21ae54a82d3182f501
                    }

                    $PackageTotal += $singlePackageTotal;
                }
            }

            if (count($requestPackageQty) > 0){
                foreach ($request->package_activity_qty as $item => $activity_quantity){

                    foreach($activity_quantity as $activity_id => $qty){

                        if($qty > 0){
                            $activity = Activity::first($activity_id);

                            if ($activity['status'] === 'success'){
                                $price = $activity['data']->price;
                                $singleActivityTotal = (float)$qty * (float)$price;
                            }

                            $activityTotal = $activityTotal + $singleActivityTotal;
                        }

                    }

                }
            }

            $cart_total = $PackageTotal + $activityTotal;
            //dd($cart_total);

            $order = Order::save([
                'user_id' => $request->user,
                'cart_id' => $cart_id,
                'cart_total' => $cart_total,
                'status' => 'completed',
                'is_admin' => 1,
            ]);

            $orderDetails ['order_id'] = $order['data']->id;

            $types = $request->types ?? [];
            $items = [];
            $total = 0;

            if (sizeof($types) > 0) {

                foreach ($types as $key => $type_id) {
                    if (!isset($items[$type_id])) {
                        $items[$type_id] = [];
                    }

                    $package_type = PackageType::first($type_id);

                    if($package_type['status'] === 'success'){
                        $orderDetails['type_id'] = $package_type['data']->id;
                        $orderDetails['type_name'] = $package_type['data']->name;
                        $orderDetails['type_arabic_name'] = $package_type['data']->arabic_name;
                    }

                    $day_id = $request->days[$key] ?? null;

                    if (!isset($items[$type_id][$day_id])) {
                        $items[$type_id][$day_id] = [];

                    }

                    $day = \App\Models\Day::whereId($day_id)->first();


                    //assign order package day
                    $orderDetails['day_code'] = $day->code;
                    $orderDetails['day_name'] = $day->name;
                    $orderDetails['day_arabic_name'] = $day->arabic_name;
                    $orderDetails['day_from'] = $day->day_from;
                    $orderDetails['day_to'] = $day->day_to;

                    $package_id = $request->packages[$key] ?? null;

                    if (!isset($items[$type_id][$day_id][$package_id])) {
                        $items[$type_id][$day_id][$package_id] = [];
                    }

                    $package_qty = $request->package_qty[$key] ?? null;

                    if (!isset($items[$type_id][$day_id][$package_id]['qty'])) {
                        $items[$type_id][$day_id][$package_id]['qty'] = $package_qty;
                    }

                    $package = Package::first($package_id);

                    if ($package['status'] === 'success') {

                        $orderDetails['package_id']         = $package['data']->id;
                        $orderDetails['name']               = $package['data']->name;
                        $orderDetails['arabic_name']        = $package['data']->arabic_name;
                        $orderDetails['description']        = $package['data']->description;
                        $orderDetails['arabic_description'] = $package['data']->arabic_description;
                        $orderDetails['price']              = $package['data']->price;
                        $orderDetails['gate_access']        = $package['data']->gate_access;
                        $orderDetails['qty']                = $package_qty;
                        $orderDetails['fixed_quantity']     = $package['data']->fixed_quantity;

                        $orderDetail = OrderDetails::save($orderDetails);
                        //dd($orderDetail);

                        if ($orderDetail['status'] === 'success') {
                            $activities = $request->package_activities[$package_id] ?? [];
                            $quantities = $request->package_activity_qty[$package_id] ?? [];

                            if (!isset($items[$type_id][$day_id][$package_id]['activities'])) {
                                $items[$type_id][$day_id][$package_id]['activities'] = [];
                            }

                            $freeActivities = $package['data']->activities()->wherePrice(0)->get();

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
                                        'qty'                   => $package_qty,
                                        'images'                => $activity->images,
                                    ]);
                                }
                            }

                            //sizeof($activities) ==  sizeof($quantities)

                            if (sizeof($activities) > 0 && sizeof($quantities) > 0) {
                                //dd($activities);
                                foreach ($activities as $activity_id) {
                                    $activity_qty = $quantities[$activity_id];

                                    if ($activity_qty < 1) continue;

                                    $activity = Activity::first($activity_id);

                                    if ($activity['status'] === 'success') {
                                        $response = OrderActivity::save([
                                            'order_detail_id'       => $orderDetail['data']->id,
                                            'name'                  => $activity['data']->name,
                                            'activity_id'           => $activity['data']->id,
                                            'arabic_name'           => $activity['data']->arabic_name,
                                            'description'           => $activity['data']->description,
                                            'arabic_description'    => $activity['data']->arabic_description,
                                            'price'                 => $activity['data']->price,
                                            'qty'                   => $activity_qty,
                                            'images'                => $activity['data']->images,
                                        ]);
                                    }

                                    $items[$type_id][$day_id][$package_id]['activities'][$activity_id]['qty'] =  $activity_qty;
                                }
                            }
                        }

                    }
                }
            }

            Session::flash('order-create', 'Order placed successfully.');

            return back();

        }catch (\Exception $ex){
            throw new \Exception($ex->getMessage());
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $response = Order::first($id);
        $order = $response['data'];

        if ($response['status'] === 'error' ) {
            throw new \Exception($order);
        }

        return view('admin.order.show', compact('order'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try{
            $userResponse = User::all();
            $packageTypeResponse = PackageType::all();
            $dayResponse = Day::all();
            $packageResponse = Package::all();

            $users = [];
            $packageTypes = [];
            $days = [];
            $packages = [];

            if($userResponse['status'] === 'success'){
                $users = $userResponse['data'];
                //dd($users);
            }

            if($packageTypeResponse['status'] === 'success'){
                $packageTypes = $packageTypeResponse['data'];
            }

            if($dayResponse['status'] === 'success'){
                $days = $dayResponse['data'];
            }

            if($packageResponse['status'] === 'success'){
                $packages = $packageResponse['data'];
            }

            $orderResponse = Order::first($id);

            if($orderResponse['status'] === 'success'){
                $order = $orderResponse['data'];
            }
            return view('admin.order.edit', compact(
                'order',
                'users',
                'packageTypes',
                'days',
                'packages'
            ));
        }
        catch (\Exception $exception){
            throw new \Exception($exception->getMessage());
        }
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

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function getDays($type_id)
    {
        try {
            $packageType = PackageType::first($type_id, 'id', ['package_days']);

            if ($packageType['status'] == 'success') {
                return response()->json([
                    'success' => true,
                    'days' => $packageType['data']->package_days
                ]);
            }

            return response()->json([
                'success' => false,
                'error' => 'Package type not found.'
            ]);

        } catch (\Exception $ex) {
            return response()->json([
                'success' => false,
                'error' => $ex->getMessage(),
                'status' => $ex->getCode()
            ]);
        }
    }

    public function getPackages($day_id)
    {
        try {
            $day = Day::first($day_id, 'id', ['packages']);

            if ($day['status'] == 'success') {
                return response()->json([
                    'success' => true,
                    'packages' => $day['data']->packages
                ]);
            }

            return response()->json([
                'success' => false,
                'error' => 'Day not found.'
            ]);

        } catch (\Exception $ex) {
            return response()->json([
                'success' => false,
                'error' => $ex->getMessage(),
                'status' => $ex->getCode()
            ]);
        }
    }

    public function getActivities($package_id)
    {
        try {
            $package = Package::first($package_id, 'id', ['activities']);

            if ($package['status'] == 'success') {
                $html = view('admin.order.activities', ['package' => $package['data']])->render();
                return response()->json([
                    'success' => true,
                    'packages' => $package['data']->packages,
                    'html' => $html
                ]);
            }

            return response()->json([
                'success' => false,
                'error' => 'Day not found.'
            ]);

        } catch (\Exception $ex) {
            return response()->json([
                'success' => false,
                'error' => $ex->getMessage(),
                'status' => $ex->getCode()
            ]);
        }
    }
}
