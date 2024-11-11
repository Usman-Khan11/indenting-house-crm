<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\GeneralSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        $username = $request->username;
        $password = $request->password;

        $user = User::where('username', $username)->first();
        if ($user) {
            $pass_check = Hash::check($password, $user->password);
            if ($pass_check) {
                if (renew() == 1) {
                    return back()->withError('Subscription expired please renew now!');
                }
                Auth::login($user, request()->has('remember'));
                return redirect()->route('dashboard')->withSuccess('Login successfully.');
            }
        }

        return back()->withError('User not found.');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login')->withSuccess('Logout successfully.');
    }
}
