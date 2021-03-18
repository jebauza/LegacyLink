<?php
namespace App\Http\Controllers\Admin\Auth;


use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
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

        $email = $request->forgot_email;

        $token = Str::random(60);

        DB::table('password_resets')->insert(
            ['email' => $email, 'token' => $token, 'created_at' => Carbon::now()]
        );

        Mail::send('auth.password.verify',['token' => $token], function($message) use ($email) {
                  //$message->from($email);
                  $message->to($email);
                  $message->subject('Reset Password Notification');
               });

        return back()->with('message', 'We have e-mailed your password reset link!');
    }
}
