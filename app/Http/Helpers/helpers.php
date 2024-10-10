<?php

use App\Models\GeneralSetting;

function general()
{
    return GeneralSetting::first();
}

function menuActive($routeName, $type = null)
{
    if ($type == 3) {
        $class = 'side-menu-open';
    } elseif ($type == 2) {
        $class = 'active open';
    } else {
        $class = 'active';
    }
    if (is_array($routeName)) {
        foreach ($routeName as $key => $value) {
            if (request()->routeIs($value)) {
                return $class;
            }
        }
    } elseif (request()->routeIs($routeName)) {
        return $class;
    }
}

function partialShipment()
{
    $data = [
        "Not Allowed" => "Not Allowed",
        "Allowed" => "Allowed"
    ];

    return $data;
}

function transShipment()
{
    $data = [
        "Not Allowed" => "Not Allowed",
        "Allowed" => "Allowed"
    ];

    return $data;
}

function packing()
{
    $data = [
        "Export Standard" => "Export Standard",
        "None" => "None"
    ];

    return $data;
}

function shipment()
{
    $data = [
        "1 Week" => "1 Week",
        "2 Week" => "2 Week",
        "3 Week" => "3 Week",
        "4 Week" => "4 Week",
        "5 Week" => "5 Week",
        "6 Week" => "6 Week",
        "7 Week" => "7 Week",
        "8 Week" => "8 Week",
        "Prompt" => "Prompt"
    ];

    return $data;
}

function shippingMode()
{
    $data = [
        "By Air" => "By Air",
        "By Sea" => "By Sea",
        "By Road" => "By Road",
        "By Courier" => "By Courier"
    ];

    return $data;
}

function shippingType()
{
    $data = [
        "CFR" => "CFR",
        "CIF" => "CIF",
        "CNF" => "CNF",
        "FOB" => "FOB",
        "CPT" => "CPT",
        "Ex-Works" => "Ex-Works"
    ];

    return $data;
}

function origin()
{
    $data = [
        "China" => "China",
        "India" => "India"
    ];

    return $data;
}

function paymentTerms()
{
    $data = [
        'LC At Sight' => 'LC At Sight',
        'BC At Sight' => 'BC At Sight',
        'DP At Sight' => 'DP At Sight',
        'TT Advance' => 'TT Advance',
        'LC 30 Days From BL Date' => 'LC 30 Days From BL Date',
        'LC 60 Days From BL Date' => 'LC 60 Days From BL Date',
        'LC 90 Days From BL Date' => 'LC 90 Days From BL Date'
    ];

    return $data;
}

function currency()
{
    $data = [
        "$" => "USD",
        "¥" => "CNY",
        "₨" => "PKR",
        "C$" => "CAD",
        "A$" => "AUD",
        "₹" => "IND"
    ];

    return $data;
}

function portOfShipment()
{
    $data = [
        'Chinese Sea Port' => 'Chinese Sea Port',
        'Shanghai Sea Port' => 'Shanghai Sea Port',
        'Nhava Sheva Sea Port' => 'Nhava Sheva Sea Port',
        'Shenzen Sea Port' => 'Shenzen Sea Port',
        'Ningbo Sea Port' => 'Ningbo Sea Port',
        'Qingdao Sea Port' => 'Qingdao Sea Port',
        'Tianjin Sea Port' => 'Tianjin Sea Port',
        'Dehli Air Port' => 'Dehli Air Port',
        'Beijing Airport' => 'Beijing Airport',
        'Mumbai Air Port' => 'Mumbai Air Port',
        'Hyderabad Airport' => 'Hyderabad Airport',
        'Xiamen Airport' => 'Xiamen Airport',
    ];

    return $data;
}


function portOfDestination()
{
    $data = [
        'Karachi Sea Port' => 'Karachi Sea Port',
        'Karachi Air Port' => 'Karachi Air Port',
        'Lahore Air Port' => 'Lahore Air Port',
        'Islamabad Air Port' => 'Islamabad Air Port'
    ];

    return $data;
}
