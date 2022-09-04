@extends('admin.layouts.master')

@section('content')
    <!-- BEGIN: Content -->
    <div class="content">
        <div class="intro-y flex items-center mt-8">
            <div class="breadcrumb mr-auto custom-breadcrumb">
                <a href="{{ route('admin.orders.index') }}" class="breadcrumb-link">Orders</a>
                <i data-feather="chevron-right" class="breadcrumb__icon"></i>
                <span class="breadcrumb--active">Show order</span>
            </div>
        </div>

        <!-- BEGIN: HTML Table Data -->
        <div class="intro-y box p-5 mt-5">
            <div class="main-dataTable mt-5">

                <div>
                    <table class="table table-bordered">
                        <tbody style="text-align: left">
                        <tr>
                            <th width="15%" class="border ">Order Id:</th>
                            <td width="35%" class="border">{{$order->cart_id}}</td>
                            <th class="border ">Transfer reference:</th>
                            <td class="border">{{$order->tran_ref}}</td>
                        </tr>
                        <tr>
                            <th width="15%" class="border ">Total:</th>
                            <td width="35%" class="border">{{$order->cart_total}}</td>
                            <th class="border ">Payment Status:</th>
                            <td class="border">{{$order->status}}</td>
                        </tr>
                        <tr>
                            <th width="15%" class="border ">Customer:</th>
                            <td width="35%"
                                class="border">{{$order->user->first_name.' '.$order->user->last_name}}</td>
                            <th class="border ">Payment Response code:</th>
                            <td class="border">{{$order->resp_code}}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>

                <div class="mt-8">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th width="20" class="border border-b-2 dark:border-dark-5 whitespace-nowrap">Package
                            </th>
                            <th width="17%" class="border border-b-2 dark:border-dark-5 whitespace-nowrap">
                                Information
                            </th>
                            <th width="23%" class="border border-b-2 dark:border-dark-5 whitespace-nowrap">Name</th>
                            <th width="40%" class="border border-b-2 dark:border-dark-5 whitespace-nowrap">Add ons
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(count($order->orderDetails) > 0)
                            @foreach($order->orderDetails as $orderDetail)
                                <tr style="background-color: white">
                                    <td class="border">{{$orderDetail->name}}</td>
                                    <td class="border">
                                        <table>
                                            <tr>
                                                <th class="border border-b-2 dark:border-dark-5 whitespace-nowrap">
                                                    Type
                                                </th>
                                                <td class="border">{{$orderDetail->type_name}}</td>
                                            </tr>
                                            <tr>
                                                <th class="border border-b-2 dark:border-dark-5 whitespace-nowrap">
                                                    Day
                                                </th>
                                                <td class="border">{{$orderDetail->day_name}}</td>
                                            </tr>
                                            <tr>
                                                <th class="border border-b-2 dark:border-dark-5 whitespace-nowrap">
                                                    Quantity
                                                </th>
                                                <td class="border">{{$orderDetail->qty}}</td>
                                            </tr>
                                            <tr>
                                                <th class="border border-b-2 dark:border-dark-5 whitespace-nowrap">
                                                    Price
                                                </th>
                                                <td class="border">{{$orderDetail->price}}</td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td class="border">
                                        <table class="table table-bordered">
                                            <tbody>
                                            @if(count($orderDetail->names) > 0)
                                                @foreach($orderDetail->names as $name)
                                                    <tr>
                                                        <td class="border">{{$name->name}}</td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                            </tbody>
                                        </table>
                                    </td>
                                    <td class="border">
                                        <table class="table table-bordered">
                                            <thead>
                                            <tr>
                                                <th width=""
                                                    class="border border-b-2 dark:border-dark-5 whitespace-nowrap">
                                                    Name
                                                </th>
                                                <th width=""
                                                    class="border border-b-2 dark:border-dark-5 whitespace-nowrap">
                                                    Price
                                                </th>
                                                <th width=""
                                                    class="border border-b-2 dark:border-dark-5 whitespace-nowrap">
                                                    Quantity
                                                </th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                            @if(count($orderDetail->activities) > 0 )
                                                @foreach($orderDetail->activities as $k=>$activity)
                                                    <tr>
                                                        <td class="border">
                                                            {{$activity->name}}
                                                        </td>
                                                        <td class="border" width="">
                                                            {{$activity->price == 0 ? "Free" :  $activity->price}}
                                                        </td>

                                                        <td class="border">
                                                            {{$activity->qty}}
                                                        </td>
                                                    </tr>

                                                    @endforeach
                                                    @endif
                                                    </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>

                            @endforeach
                        @endif
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
    <!-- END: Content -->
@endsection

@push('scripts')

@endpush
