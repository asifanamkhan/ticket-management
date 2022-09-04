<?php

use App\Repositories\Cart;
use App\Repositories\Country\Country;

if (!function_exists('cart_total')) {
    function cart_total()
    {
        return Cart::total();
    }
}

if (!function_exists('countries')) {
    function countries()
    {
        $countries = Country::all();

        if ($countries['status'] === 'success') {
            return $countries['data'];
        }

        return [];
    }
}