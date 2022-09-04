<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\Activity;
use App\Repositories\Order\Order;
use App\Repositories\Package;
use App\Repositories\User;
use App\Repositories\Visitor;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $totalVisitorsResponse = Visitor::totalCount();
        $totalAddOnsResponse = Activity::totalCount();
        $totalSaleResponse = Order::totalCount();
        $totalPackagesResponse = Package::totalCount();
        $latestOrderResponse = Order::latestOrder($interval = 0);

        $totalVisitors = [];
        $totalAddOns = [];
        $totalSale = [];
        $totalPackages = [];
        $latestOrder = [];

        if ($totalVisitorsResponse['status'] === 'success') {
            $totalVisitors = $totalVisitorsResponse['data'];
        }

        if ($totalAddOnsResponse['status'] === 'success') {
            $totalAddOns = $totalAddOnsResponse['data'];
        }

        if ($totalSaleResponse['status'] === 'success') {
            $totalSale = $totalSaleResponse['data'];
        }

        if ($totalPackagesResponse['status'] === 'success') {
            $totalPackages = $totalPackagesResponse['data'];
        }


        if ($latestOrderResponse['status'] === 'success') {
            $latestOrder = $latestOrderResponse['data'];
        }

        return view('admin.index',compact(
            'totalVisitors',
            'totalAddOns',
            'totalSale',
            'totalPackages',
            'latestOrder'
        ));
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
