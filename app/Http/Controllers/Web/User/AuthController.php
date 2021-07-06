<?php

namespace App\Http\Controllers\Web\User;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\EmailVerificationRequest;

class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function emailVerify(EmailVerificationRequest $request)
    {
        $user = User::find($request->route('id'));

        if (! $user->hasVerifiedEmail()) {
            $user->markEmailAsVerified();

            event(new Verified($user));
            // $user->changePassword();
        }

        $profile_user = DB::table('deceased_profile_user')
                        ->where('deceased_profile_user.user_id', $user->id)
                        ->join('deceased_profiles', 'deceased_profiles.id', '=', 'deceased_profile_user.profile_id')
                        ->join('invitations', function ($join) {
                            $join->on('deceased_profile_user.profile_id', '=', 'invitations.profile_id')
                                 ->where('invitations.role', '=', 'deceased_profile_user.role');
                        })
                        ->select('deceased_profile_user.*', 'deceased_profiles.web_code', 'invitations.token')
                        ->latest('deceased_profile_user.updated_at')
                        ->first();

        if ($profile_user) {
            return redirect()->away(config('albia.web_client_url') . '/invitation?token=' . $profile_user->token . '&profile=' . $profile_user->web_code);
        }

        return view('auth.user.emailVerify');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getResetPassword(Request $request)
    {
        $isValid = DB::table('password_resets')->where('email', $request->email)
                                    ->where('token', $request->token)
                                    ->first();

        if (!$isValid) {
            return redirect('/');
        }

        return view('auth.user.resetPassword', $request->only(['email','token']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required|string|min:6|confirmed',
            'password_confirmation' => 'required',
            'token' => 'required|string',
        ]);

        $updatePassword = DB::table('password_resets')
                            ->where(['email' => $request->email, 'token' => $request->token])
                            ->first();

        if(!$updatePassword)
        {
            return back()->withInput()->withErrors(['email' => 'Invalid email or token!']);
        }

        $user = User::where('email', $request->email)
                    ->update(['password' => Hash::make($request->password)]);

        DB::table('password_resets')->where(['email'=> $request->email])->delete();

        //return back()->with('message', 'Your password has been changed!');

        return redirect('/');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
