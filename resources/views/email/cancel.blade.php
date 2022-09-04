<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <style>
        .border{
            border: 1px solid gray;
        }
        .mp{

            padding: 2px ;
        }
    </style>
</head>
<body style="background-color: #EFF8FF">
<div style="text-align: center">
    {{--<h3>--}}
        {{--Hi {{auth()->user()->first_name}}--}}
    {{--</h3>--}}
    <h3 style="background-color: #F8D7DA">
        Your payment has been canceled. <br>
        Please try again or contact with our administrator.
    </h3>
    <h2 class="">
        Order details
    </h2>
</div>

<div style="background-color: #EFF8FF">
    <div style="background-color: #EFF8FF; padding: 10px">
        <table class="border mp" style="width: 100%;">
            <tbody style="text-align: left">
            <tr >
                <th class="border mp" width="15%">Order Id: </th>
                <td class="border mp" >{{$order->cart_id}}</td>
                <th class="border mp" >Transfer reference: </th>
                <td class="border mp" >{{$order->tran_ref ?? '--'}}</td>
            </tr>
            <tr>

            </tr>
            <tr>
                <th class="border mp"  width="15%">Total: </th>
                <td class="border mp" width="35%">{{$order->cart_total}}</td>
                <th class="border mp" > Status: </th>
                <td class="border mp" >Pending</td>
            </tr>
            </tbody>
        </table>
    </div>

    <div style="background-color: #EFF8FF; padding: 10px">
        <table class="border" style="width: 100%; margin-top: 20px">
            <thead>
            <tr style="background-color: gray; color: wheat">
                <th class="border mp" width="15">Package</th>
                <th class="border mp" width="20%" >Information</th>
                <th class="border mp" width="20%" >Name</th>
                <th class="border mp" width="45%" >Add ons</th>
            </tr>
            </thead>
            <tbody>
            @if(count($order->orderDetails) > 0)
                @foreach($order->orderDetails as $orderDetail)
                    <tr>
                        <td class="border mp">{{$orderDetail->package->name}}</td>
                        <td class="border mp">
                            <table class="border mp" style="width: 100%;">
                                <tr>
                                    <th style="background-color: #d4d4d4; color: black" width="40%" class="border mp">Type</th>
                                    <td class="border mp" >{{$orderDetail->package->package_type->name}}</td>
                                </tr>
                                <tr>
                                    <th style="background-color: #d4d4d4; color: black" class="border mp" >Day</th>
                                    <td class="border mp" >{{$orderDetail->package->day->name}}</td>
                                </tr>
                                <tr>
                                    <th style="background-color: #d4d4d4; color: black" class="border mp" >Quantity</th>
                                    <td class="border mp" >{{$orderDetail->qty}}</td>
                                </tr>
                                <tr>
                                    <th style="background-color: #d4d4d4; color: black" class="border mp" >Price</th>
                                    <td class="border mp" >{{$orderDetail->package->price}}</td>
                                </tr>
                            </table>
                        </td>
                        <td  class="border mp">
                            <table class="border mp" style="width: 100%;">
                                <tbody>
                                @if(count($order->orderNames) > 0)
                                    @foreach($order->orderNames as $name)
                                        @if($name->package_id == $orderDetail->package_id)
                                            <tr>
                                                <td class="border mp" >{{$name->name}}</td>
                                            </tr>
                                        @endif
                                    @endforeach
                                @endif
                                </tbody>
                            </table>
                        </td>
                        <td  class="border mp">
                            <table class="border mp" style="width: 100%;">
                                <thead>
                                <tr style="background-color: #d4d4d4; color: black">
                                    <th width="" class="border mp" >Name</th>
                                    <th width="" class="border mp"  >Price</th>
                                    <th width="" class="border mp" >Quantity</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                @if(isset($order->orderActivities) && count($order->orderActivities) > 0)
                                    @foreach($order->orderActivities as $k=>$activity)
                                        @if($orderDetail->package_id === $activity->package_id)
                                            <tr>
                                                <td  class="border mp" >
                                                    {{$activity->activity->name}}
                                                </td >
                                                <td class="border mp" >
                                                    {{$activity->adon_price == 0 ? "Free" :  $activity->adon_price}}
                                                </td >

                                                <td  class="border mp">
                                                    {{$activity->qty}}
                                                </td>

                                            </tr>
                                            @endif
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
</body>
</html>

