<?php

namespace App\Repositories;

use Illuminate\Support\Facades\Session;

class Cart
{
    public static function total()
    {
        $cart = Session::has('cart') ? Session::get('cart') : [];
        $total = 0;
        if (count($cart) > 0) {
            foreach ($cart as $package_type => $days) {
                if (is_array($days) && count($days) > 0) {
                    foreach($days as $day => $packages) {
                        if (is_array($packages) && count($packages) > 0) {
                            foreach($packages as $package) {
                                $qty = $package['qty'] ?? 0;
                                $price = $package['price'] ?? 0;
                                $activities = $package['activities'] ?? [];
                                $concerts = $package['concerts'] ?? [];

                                if ($qty > 0 && $price > 0 && empty($concerts)) {
                                    $total += $qty * $price;

                                    if (count($activities) > 0) {
                                        foreach ($activities as $activity) {
                                            if (isset($activity['price'], $activity['qty'])) {
                                                $total += $activity['price'] * $activity['qty'];
                                            }
                                        }
                                    }
                                } else {

                                    foreach ($concerts as $concert) {
                                        if (isset($concert['price'], $concert['qty'])) {
                                            $total += $concert['price'] * $concert['qty'];
                                        }
                                    }

                                    if (count($activities) > 0) {
                                        foreach ($activities as $activity) {
                                            if (isset($activity['price'], $activity['qty'])) {
                                                $total += $activity['price'] * $activity['qty'];
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }

        return $total;
    }
}