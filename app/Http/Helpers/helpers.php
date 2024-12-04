<?php

use App\Models\GeneralSetting;
use App\Models\Permission;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

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
        'CAD' => 'CAD',
        'CAD 50 Days From BL Date' => 'CAD 50 Days From BL Date',
        'LC At Sight' => 'LC At Sight',
        'BC At Sight' => 'BC At Sight',
        'DP At Sight' => 'DP At Sight',
        'TT Advance' => 'TT Advance',
        'LC 30 Days From BL Date' => 'LC 30 Days From BL Date',
        'LC 60 Days From BL Date' => 'LC 60 Days From BL Date',
        'LC 90 Days From BL Date' => 'LC 90 Days From BL Date',
        'BC 40 Days' => 'BC 40 Days',
        'BC 45 Days From BL Date' => 'BC 45 Days From BL Date',
        'BC 40 Days From BL Date' => 'BC 40 Days From BL Date',
        'BC 60 Days From BL Date' => 'BC 60 Days From BL Date',
        'BC 120 Days' => 'BC 120 Days',
        'DA' => 'DA',
        'DA 30 Days' => 'DA 30 Days',
        'DA 45 Days' => 'DA 45 Days',
        'DA 60 Days' => 'DA 60 Days',
        'DA 90 Days' => 'DA 90 Days',
        'DA 120 Days' => 'DA 120 Days',
        'LC 120 Days' => 'LC 120 Days'
    ];

    return $data;
}

function currency()
{
    $data = [
        "$" => "USD",
        "¥" => "CNY",
        "RS" => "PKR",
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
        'Chinese Airport' => 'Chinese Airport',
        'Shanghai Sea Port' => 'Shanghai Sea Port',
        'Shanghai Air Port' => 'Shanghai Air Port',
        'Nhava Sheva Sea Port' => 'Nhava Sheva Sea Port',
        'Shenzen Sea Port' => 'Shenzen Sea Port',
        'Ningbo Sea Port' => 'Ningbo Sea Port',
        'Qingdao Sea Port' => 'Qingdao Sea Port',
        'Qingdao Airport' => 'Qingdao Airport',
        'Tianjin Sea Port' => 'Tianjin Sea Port',
        'Dehli Air Port' => 'Dehli Air Port',
        'Beijing Airport' => 'Beijing Airport',
        'Mumbai Air Port' => 'Mumbai Air Port',
        'Hyderabad Airport' => 'Hyderabad Airport',
        'Xiamen Airport' => 'Xiamen Airport',
        'Xiamen Sea Port' => 'Xiamen Sea Port',
        'Taipei Airport' => 'Taipei Airport',
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

function units()
{
    $data = [
        'KG' => 'KG',
        'GM' => 'GM',
        'LTR' => 'LTR',
        'PC' => 'PC'
    ];

    return $data;
}

function paymentRemarks()
{
    $data = [
        'Pending' => 'Pending',
        'Done' => 'Done'
    ];

    return $data;
}

function shipmentLotDetails()
{
    $data = [
        '1st Lot' => '1st Lot',
        '2nd Lot' => '2nd Lot',
        '3rd Lot' => '3rd Lot',
        '4th Lot' => '4th Lot',
        '5th Lot' => '5th Lot'
    ];

    return $data;
}

function renew()
{
    $gnl = GeneralSetting::first();

    if ($gnl) {
        $today = Carbon::today();
        $expired_at = Carbon::parse($gnl->expired_at);

        if ($today->greaterThanOrEqualTo($expired_at) && $gnl->expired == 0) {
            $gnl->expired = 1;
            $gnl->save();
        }

        if ($gnl->expired == 1) {
            return 1;
        }
    }

    return 0;
}


function get_user_permission($user_id)
{
    $Permisions = DB::table('permissions')->where('user_id', $user_id)->get();
    return $Permisions;
}

function Get_Sidebar()
{
    $Nav = DB::table('navs')->get();
    return $Nav;
}

function Get_Navkeys($nav_id)
{
    $Navkeys = DB::table('nav_keys')->where('nav_id', $nav_id)->get();
    return $Navkeys;
}

function Get_Sidebar_User($user_id)
{
    $Permisions = Permission::select('nav_id')
        ->where('user_id', $user_id)
        ->groupBy('nav_id')
        ->get();
    return $Permisions;
}

function checkSidebar($role_id, $nav_id, $key)
{
    $permission = DB::table('permissions')
        ->join('nav_keys', 'nav_keys.id', '=', 'permissions.nav_key_id')
        ->where('permissions.nav_id', $nav_id)
        ->where('permissions.user_id', $role_id)
        ->where('nav_keys.key', $key)
        ->select('permissions.*', 'nav_keys.key')
        ->count();

    if ($permission) {
        return true;
    } else {
        return false;
    }
}

function get_navkey_by_nav_id($nav_id)
{
    $Permisions = DB::table('nav_keys')->where('nav_id', $nav_id)->get();
    return $Permisions;
}

function get_user_permissions($role_id, $nav_id, $nav_key_id)
{
    $Permisions = Permission::where('user_id', $role_id)->where('nav_id', $nav_id)->where('nav_key_id', $nav_key_id)->get();
    return $Permisions;
}

function Get_Permission($nav_id, $role_id)
{
    $arr = [];
    $navs = Get_Sidebar();
    foreach ($navs as $nav) {
        if ($nav->id == $nav_id) {
            $navs_keys = get_navkey_by_nav_id($nav->id);
            foreach ($navs_keys as $navs_key) {
                $perm = get_user_permissions($role_id, $nav->id, $navs_key->id);
                foreach ($perm as $perm) {
                    $arr[] = $navs_key->key;
                }
            }
        }
    }
    return $arr;
}

function updateEnv($data = [])
{
    $envPath = base_path('.env');

    // Read the current .env content
    $envContent = File::get($envPath);

    // Process each key-value pair
    foreach ($data as $key => $value) {
        // Add quotes around values with special characters
        $quotedValue = preg_match('/[\s"\'\=\:]/', $value) ? '"' . addslashes($value) . '"' : $value;

        // Check if the key already exists in the .env content
        $pattern = "/^{$key}=.*/m";
        if (preg_match($pattern, $envContent)) {
            // Replace the existing line with the new key-value pair
            $envContent = preg_replace($pattern, "{$key}={$quotedValue}", $envContent);
        } else {
            // Append new key-value pair if the key doesn't exist
            $envContent .= "\n{$key}={$quotedValue}";
        }
    }

    // Write the updated content back to the .env file
    File::put($envPath, $envContent);
}

function uploadImage($file, $directory, $old_file = '')
{
    if (!$file || !$directory) {
        return '';
    }

    deleteImage($old_file);

    $filename = uniqid() . '.' . $file->getClientOriginalExtension();
    $path = $file->move($directory, $filename);
    return $directory . $filename;
}

function deleteImage($file)
{
    if (!empty($file) && file_exists(public_path($file))) {
        unlink(public_path($file));
    }
}
