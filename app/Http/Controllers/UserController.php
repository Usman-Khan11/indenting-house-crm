<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function dashboard()
    {
        $data['page_title'] = "Dashboard";
        return view('dashboard', $data);
    }
}
