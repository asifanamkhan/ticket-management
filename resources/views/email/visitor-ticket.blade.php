<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <style>
        .border {
            border: 1px solid gray;
        }

        .mp {

            padding: 2px;
        }
    </style>
</head>
<body style="background-color: #EFF8FF">
<div style="text-align: center">
    <h3>
        Hi {{$visitor->first_name}} {{$visitor->last_name}}
    </h3>
    <h3 style="background-color: #D4EDDA">Thanks for the purchase. Here is your ticket.</h3>
</div>

<div style="background-color: #EFF8FF">
    <div style="text-align: center">
        <img src="{!! $message->embedData(QrCode::format('png')->generate(route('scan.packages', ['id' => $visitor->id])), 'QrCode.png', 'image/png') !!}" />
    </div>
</div>

</body>
</html>