<?php
namespace App\Http\Controllers\Admin\Auth;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Office;
use Illuminate\Support\Facades\Auth;


class LoginController extends Controller
{
    public function login()
    {
        if (Auth::check()) {
            return redirect()->route('admin.home');
        }

        return view('auth.login');
    }

    public function authenticate(Request $request)
    {
        if (Auth::check()) {
            return redirect()->route('admin.home');
        }

        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string'
        ]);

        $credentials = $request->only('email', 'password');
        $credentials['is_active'] = true;
        $remember = $request->remember ? true : false;

        if (Auth::attempt($credentials, $remember)) {
            return redirect()->intended('admin/home');
        }

        return back()->withInput()->withErrors(['email' => __('auth.failed')]);
    }

    public function logout() {
        Auth::logout();

        return redirect()->route('admin.login');
    }
}
