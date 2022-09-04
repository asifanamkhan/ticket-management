<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <style>

    </style>
</head>
<body style="background-color: #EFF8FF">
    <div style="text-align: center">
        <h3>
            Hi {{auth()->user()->first_name}}
        </h3>
        <h3 style="background-color: #D4EDDA">Something went wrong. <br>
            Thanks for the purchase.
        </h3>
        <h2 class="">
            Please try again or contact with our administrator.
        </h2>
    </div>
</body>
</html>

