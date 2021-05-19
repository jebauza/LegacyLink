<?php
namespace App\Http\Controllers\Admin\Auth;


use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Employee;
use Illuminate\Support\Facades\Mail;

class ForgotPasswordController extends Controller
{
    public function getEmail()
    {

       return view('auth.password.email');
    }

    public function postEmail(Request $request)
    {
        $request->validate([
            'forgot_email' => 'required|email|exists:employees,email',
        ]);

        if ($employee = Employee::where('email', $request->forgot_email)->first()) {
            $token = Str::random(60);

            DB::table('password_resets')->insert(
                ['email' => $employee->email, 'token' => $token, 'created_at' => Carbon::now()]
            );

            $employee->sendPasswordResetNotification($token);

            return back()->with('message', __('We have e-mailed your password reset link!'));
        } else {
            return back()->with('error', 'Correo inválido');
        }
    }
}
