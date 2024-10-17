<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GeneralSetting;

class UserController extends Controller
{
    public function dashboard()
    {
        $data['page_title'] = "Dashboard";
        return view('dashboard', $data);
    }
}
