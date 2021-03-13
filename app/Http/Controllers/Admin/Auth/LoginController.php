<?php
namespace App\Http\Controllers\Admin\Auth;


use App\Models\Employee;
use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class LoginController extends Controller
{
    public function login()
    {
      return view('auth.login');
    }

    public function authenticate(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('email', 'password');
        $credentials['is_active'] = true;
        $remember = false;

        if (Auth::attempt($credentials, $remember)) {
            // Authentication passed...
            return redirect()->intended('admin/home');
        }

        //return redirect('login')->with('error', 'Oppes! You have entered invalid credentials');
        return redirect()->route('admin.login')->with('error', 'Oppes! You have entered invalid credentials');
    }

    public function logout() {
        Auth::logout();

        return redirect()->route('admin.login');
    }
}
