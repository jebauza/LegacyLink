<?php
namespace App\Http\Controllers\Admin\Auth;


use App\Models\Employee;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;


class RegisterController extends Controller
{
  public function register(Request $request)
  {
        $request->validate([
            'name' => 'required|string|max:255',
            'signup_email' => 'required|string|email|max:255|unique:employees,email',
            'signup_password' => 'required|string|min:8|confirmed',
            'signup_password_confirmation' => 'required',
        ]);

        Employee::create([
            'name' => $request->name,
            'email' => $request->signup_email,
            'password' => Hash::make($request->signup_password),
        ]);

        return redirect()->route('admin.login')->with('message', 'You have successfully registered');
  }

}
