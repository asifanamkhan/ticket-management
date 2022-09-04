<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Repositories\PackageType;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // Session::forget('cart');
        $pacakageType = PackageType::all();
        $types = [];
        $total = 0;
        $cart_items = 0;
        
        if ($pacakageType['status'] === 'success') {
            $types = $pacakageType['data'];

            $cart = Session::has('cart') ? Session::get('cart') : [];

            // dd($cart);

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
                                        $total += $package->price * $qty;
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        Session::put('cart_items', $cart_items);
        $ses_package = [];
        if (request()->ajax()) {
            $html = view('welcome', compact('types', 'total', 'ses_package'))->render();
            return response()->json([
                'success' => true, 
                'html' => $html
            ]);
        }
        return view('welcome', compact('types', 'total', 'ses_package'));
    }
}
