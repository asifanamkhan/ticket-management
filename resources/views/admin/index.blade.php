@extends('admin.layouts.master')

@section('content')
<div class="grid grid-cols-12 gap-6">
    <div class="col-span-12 2xl:col-span-9">
        <div class="grid grid-cols-12 gap-6">
            <div class="col-span-12 xl:col-span-12 mt-6">
                <div class="intro-y flex items-center h-10">
                    <h2 class="text-lg font-medium truncate mr-5">
                        Weekly Best Sellers
                    </h2>
                </div>
                <div class="mt-5 grid grid-cols-12 gap-3">
                    <div class="intro-y lg:col-span-4">
                        <div class="box px-4 py-8 flex items-center zoom-in">
                            <div class="ml-4 mr-auto">
                                <div class="font-medium">Total Visitors</div>
                            </div>
                            <div class="py-1 px-3 rounded-full text-xs bg-theme-10 text-white cursor-pointer font-medium">{{$totalVisitors}}</div>
                        </div>
                    </div>
                    <div class="intro-y lg:col-span-4">
                        <div class="box px-4 py-8 flex items-center zoom-in">
                            <div class="ml-4 mr-auto">
                                <div class="font-medium">Total Add ons</div>
                            </div>
                            <div class="py-1 px-3 rounded-full text-xs bg-theme-10 text-white cursor-pointer font-medium">{{$totalAddOns}}</div>
                        </div>
                    </div>
                    <div class="intro-y lg:col-span-4">
                        <div class="box px-4 py-8 flex items-center zoom-in">
                            <div class="ml-4 mr-auto">
                                <div class="font-medium">Total Sales</div>
                            </div>
                            <div class="py-1 px-3 rounded-full text-xs bg-theme-10 text-white cursor-pointer font-medium">{{$totalSale}}</div>
                        </div>
                    </div>
                    <div class="intro-y lg:col-span-4">
                        <div class="box px-4 py-8 flex items-center zoom-in">
                            <div class="ml-4 mr-auto">
                                <div class="font-medium">Total Analytics</div>
                            </div>
                            <div class="py-1 px-3 rounded-full text-xs bg-theme-10 text-white cursor-pointer font-medium">300</div>
                        </div>
                    </div>
                    <div class="intro-y lg:col-span-4">
                        <div class="box px-4 py-8 flex items-center zoom-in">
                            <div class="ml-4 mr-auto">
                                <div class="font-medium">Total Packages</div>
                            </div>
                            <div class="py-1 px-3 rounded-full text-xs bg-theme-10 text-white cursor-pointer font-medium">{{$totalPackages}}</div>
                        </div>
                    </div>
                    <div class="intro-y lg:col-span-4">
                        <div class="box px-4 py-8 flex items-center zoom-in">
                            <div class="ml-4 mr-auto">
                                <div class="font-medium">Latest Orders</div>
                            </div>
                            <div class="py-1 px-3 rounded-full text-xs bg-theme-10 text-white cursor-pointer font-medium">{{$latestOrder}}</div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
