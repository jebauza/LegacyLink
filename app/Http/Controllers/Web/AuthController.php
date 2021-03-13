<?php
namespace App\Http\Controllers\Web;



use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;


class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        $credentials['is_active'] = true;
        $remember = false;

        if (Auth::attempt($credentials, $remember)) {
            // Authentication passed...
            return redirect()->intended('dashboard');
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        return response()->json([__('Logged out successfully')], 204);
    }

    public function refreshUserAuth(Request $request)
    {
        $auth_user = $request->user();
        return [
            'authUser' => $auth_user,
            'userPermissions' => $auth_user->getAllPermissions()->pluck('name')
        ];
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
