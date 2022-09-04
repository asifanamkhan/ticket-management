<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
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
    <h3 style="background-color: #D4EDDA">Your payment has been completed successfully. <br>
        Thanks for the purchase.
    </h3>
    <h2 class="">
        Purchases details
    </h2>

</div>

<div style="background-color: #EFF8FF">
    <div style="background-color: #EFF8FF; padding: 10px">
        <table class="border mp" style="width: 100%;">
            <tbody style="text-align: left">
            <tr >
                <th class="border mp" width="15%">Order Id: </th>
                <td class="border mp" >{{$cartId}}</td>
                <th class="border mp" >Transfer reference: </th>
                <td class="border mp" >{{$transactionId ?? '--'}}</td>
            </tr>
            <tr>

            </tr>
            <tr>
                <th class="border mp"  width="15%">Total (15% vat include): </th>
                <td class="border mp" width="35%">{{$price}}</td>
                <th class="border mp" > Status: </th>
                <td class="border mp" >Complete</td>
            </tr>
            </tbody>
        </table>
    </div>

    <div style="background-color: #EFF8FF; padding: 10px">
        <table class="border" style="width: 100%; margin-top: 20px">
            <thead>
                @if(isset($data) && count($data) > 0)
                    <tr>
                        <th width="30%" class="border mp">Package Type</th>
                        <td class="border mp">{{$data['package_type']}}</td>
                    </tr>
                    <tr>
                        <th class="border mp">Day</th>
                        <td class="border mp">{{$data['day']}}</td>
                    </tr>
                    <tr>
                        <th class="border mp">Package name</th>
                        <td class="border mp">{{$data['package_name']}}</td>
                    </tr>
                    <tr>
                        <th class="border mp">Add on name</th>
                        <td class="border mp">{{$data['activity_name']}}</td>
                    </tr>
                    <tr>
                        <th class="border mp">Add on price</th>
                        <td class="border mp">{{$data['adon_price']}}</td>
                    </tr>
                    <tr>
                        <th class="border mp">Add on quantity</th>
                        <td class="border mp">{{$data['qty']}}</td>
                    </tr>

                @endif
            </tbody>
        </table>
    </div>

</div>
</body>
</html>

