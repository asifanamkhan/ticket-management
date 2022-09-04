@extends('visitors.layout.master')
@section('content')
    <div class="flex items-center p-5 border-b border-gray-200 dark:border-dark-5">
        <h2 class="font-medium text-base mr-auto">
            Purchases details
        </h2>
    </div>

    <div class="intro-y box p-5 ">
        @if (session()->has('order-add-on-update'))
            <div class="alert alert-success-soft show flex items-center mb-2" role="alert">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
                     class="feather feather-alert-triangle w-6 h-6 mr-2">
                    <path
                        d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path>
                    <line x1="12" y1="9" x2="12" y2="13"></line>
                    <line x1="12" y1="17" x2="12.01" y2="17"></line>
                </svg> {{ session('order-add-on-update') }} </div>
        @endif
        @if (session()->has('payment-cancel'))
            <div class="alert alert-success-soft show flex items-center mb-2" role="alert">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
                     class="feather feather-alert-triangle w-6 h-6 mr-2">
                    <path
                        d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path>
                    <line x1="12" y1="9" x2="12" y2="13"></line>
                    <line x1="12" y1="17" x2="12.01" y2="17"></line>
                </svg> {{ session('payment-cancel') }} </div>
        @endif
        <div>
            <table class="table table-bordered">
                <tbody style="text-align: left">
                <tr>
                    <th width="15%">Order Id:</th>
                    <td width="35%">{{$order->cart_id}}</td>
                    <th>Transfer reference:</th>
                    <td>{{$order->tran_ref}}</td>
                </tr>
                <tr>
                    <th width="15%">Total:</th>
                    <td width="35%">{{$order->cart_total}}</td>
                    <th>Status:</th>
                    <td>
                        {{$order->status}}
                        @if($order->status == 'pending')
                            <a href="{{route('visitor.order.payment',$order->id)}}" class="ml-4 btn btn-primary">
                                Pay now
                            </a>
                        @endif
                    </td>
                </tr>
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            <table class="table table-bordered" style="background-color: white">
                <thead>
                <tr>
                    <th width="15" class="border border-b-2 dark:border-dark-5 whitespace-nowrap">Package</th>
                    <th width="20%" class="border border-b-2 dark:border-dark-5 whitespace-nowrap">Information</th>
                    <th width="20%" class="border border-b-2 dark:border-dark-5 whitespace-nowrap">Name</th>
                    <th width="45%" class="border border-b-2 dark:border-dark-5 whitespace-nowrap">Add ons</th>
                </tr>
                </thead>
                <tbody>
                @if(count($order->orderDetails) > 0)
                    @foreach($order->orderDetails as $orderDetail)
                        <tr>
                            <td class="border">{{$orderDetail->name}}</td>
                            <td class="border">
                                <table style="margin: 0; padding: 0">
                                    <tr>
                                        <th class="border border-b-2 dark:border-dark-5 whitespace-nowrap">Type</th>
                                        <td class="border">{{$orderDetail->type_name}}</td>
                                    </tr>
                                    <tr>
                                        <th class="border border-b-2 dark:border-dark-5 whitespace-nowrap">Day</th>
                                        <td class="border">{{$orderDetail->day_name}}</td>
                                    </tr>
                                    <tr>
                                        <th class="border border-b-2 dark:border-dark-5 whitespace-nowrap">Quantity</th>
                                        <td class="border">{{$orderDetail->qty}}</td>
                                    </tr>
                                    <tr>
                                        <th class="border border-b-2 dark:border-dark-5 whitespace-nowrap">Price</th>
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
                                        <th width="" class="border border-b-2 dark:border-dark-5 whitespace-nowrap">
                                            Name
                                        </th>
                                        <th width="" class="border border-b-2 dark:border-dark-5 whitespace-nowrap">
                                            Price
                                        </th>
                                        <th width="" class="border border-b-2 dark:border-dark-5 whitespace-nowrap">
                                            Quantity
                                        </th>
                                        @if($order->status != 'pending')
                                            <th width="" class="border border-b-2 dark:border-dark-5 whitespace-nowrap">
                                                Action
                                            </th>
                                        @endif
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                    @if(isset($orderDetail->package) && $orderDetail->package->activities && count($orderDetail->package->activities) > 0 )
                                        @foreach($orderDetail->package->activities as $k=>$activity)
                                            <tr>
                                                <td class="border">
                                                    {{$activity->name}}
                                                </td>
                                                <td class="border" width="">
                                                    {{$activity->price == 0 ? "Free" :  $activity->price}}
                                                </td>

                                                @php
                                                    $add_on = [];
                                                    $add_qty = [];

                                                    foreach ($orderDetail->activities as $key => $value){
                                                            $add_on[] = $value->activity_id;
                                                            $add_qty[] = $value->qty;
                                                    }

                                                @endphp

                                                <td class="border">
                                                    @for($i = 0; $i < sizeof($add_on); $i++)
                                                        @if($add_on[$i] == $activity->id)
                                                            {{ $add_qty[$i]}}
                                                        @endif
                                                    @endfor
                                                </td>
                                                @if($order->status != 'pending')
                                                    <td class="border" width="32%">
                                                        @if($activity->price != 0)
                                                            <div class="text-center">
                                                                <a href="javascript:;" data-toggle="modal"
                                                                   data-target="#add-modal-preview"
                                                                   onclick="addOnItem('{{$order->id}}','{{$orderDetail->id}}', '{{$orderDetail->package_id}}', '{{$activity->id}}', '{{$activity->name}}', '{{$activity->price}}','{{$orderDetail->type_name}}', '{{$orderDetail->day_name}}')"
                                                                   class="btn btn-warning ">
                                                                    @if(in_array($activity->id, $add_on))
                                                                        Add more
                                                                    @else
                                                                        Add new
                                                                    @endif
                                                                </a>
                                                            </div>
                                                        @endif
                                                    </td>
                                                @endif
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

        <!-- BEGIN: Modal Toggle -->

        <div id="add-modal-preview" class="modal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body p-10 text-center">
                        <form action="{{route('visitor.add.order.addon')}}" method="post">
                            @csrf
                            <div class="">
                                <label for="" class="form-label">Quantity <i class="text-theme-24">*</i></label>
                                <input type="number" name="qty" placeholder="quantity"
                                       class="form-control border-gray-300 @error('qty') border-theme-24 @enderror"
                                       value="1" min="1" autocomplete="qty" autofocus>

                                @error('qty')
                                <span class="text-theme-24 mt-2">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <input type="hidden" id="order_id" name="order_id" value="">
                            <input type="hidden" id="order_detail_id" name="order_detail_id" value="">
                            <input type="hidden" id="package_id" name="package_id" value="">
                            <input type="hidden" id="activity_id" name="activity_id" value="">
                            <input type="hidden" id="activity_name" name="activity_name" value="">
                            <input type="hidden" id="adon_price" name="adon_price" value="">
                            <input type="hidden" id="package_type" name="package_type" value="">
                            <input type="hidden" id="day" name="day" value="">
                            <div class="mt-4">
                                <button class="btn btn-primary w-24">Checkout</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- END: Modal Content -->

    </div>
@endsection
@section('script')
    <script>

        function addOnItem(order_id, order_detail_id, package_id, activity_id, activity_name, adon_price, package_type, day,) {

            $('#order_id').val(order_id);
            $('#order_detail_id').val(order_detail_id);
            $('#package_id').val(package_id);
            $('#activity_id').val(activity_id);
            $('#activity_name').val(activity_name);
            $('#adon_price').val(adon_price);
            $('#package_type').val(package_type);
            $('#day').val(day);
        }

    </script>
@endsection
