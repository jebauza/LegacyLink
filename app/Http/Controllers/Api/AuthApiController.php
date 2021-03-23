<?php
namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\DeceasedProfile;
use Illuminate\Support\Facades\Auth;

/**
 * @OA\Tag(
 *     name="Auth",
 *     description="API Endpoints of Auth"
 * )
 */
class AuthApiController extends Controller
{

    /**
     * @OA\Post(
     *      path="/auth/login",
     *      operationId="auth/login",
     *      tags={"Auth"},
     *      summary="Login",
     *      description="",
     *
     *      @OA\RequestBody(
     *          required=true,
     *          description="Pass user credentials",
     *          @OA\JsonContent(
     *              required={"email","password"},
     *              @OA\Property(property="email", type="string", format="email", example="jebauza@gmail.com"),
     *              @OA\Property(property="password", type="string", format="password", example="123456"),
     *          ),
     *      ),
     *
     *      @OA\Response(response=200, description="OK",
     *          @OA\JsonContent(
     *              @OA\Property(property="success", example=true),
     *              @OA\Property(property="message", example="User login successfully."),
     *              @OA\Property(property="token_type", example="Bearer"),
     *              @OA\Property(property="expires_at", example="2022-03-02 17:10:15"),
     *              @OA\Property(property="access_token", example="eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiM2NhOGI5NzhiNDRmMDM5ODYyZDcyZDcwYmQ1ZDFlNGNhNWRiOWFhOWZiM2ZlOGRiN2Y3ZjMwNGFlZWRmOTg4NGRiYjZjZjI1ZGQ5NDNkZTQiLCJpYXQiOjE1OTcxMjk3MjAsIm5iZiI6MTU5NzEyOTcyMCwiZXhwIjoxNjI4NjY1NzE5LCJzdWIiOiI3Iiwic2NvcGVzIjpbXX0.PmPKlqkpQS0UxYVqXb6KdZtoouIUO7NyKW7bj9XweDMwmLUwmvvyCg7Z9wAMgJM0MsQl1-dTgd0XwP9e8Y9DbrAcvkjFVhOHnRPMsILSqNYk6XdFEIvqRtooOMjcdebRjuFO4Y39Tz8EAlfvVdYZu88J-j3ujJuIkE1fxo_wIeGL6gyjwUqeSiiUmM_BqFBvcBUfIaLYBXqkGtnrwNrKX10QcLfimCm6qgk3NtiQuEflFqWzkkq_uQoXOAOmk5UlPgUAWzxfvmmnSJ_B4rpKXa1DWCuP-ePL7ttA_DzuhWYlpTS4ovfdIvbTRg2p5eFOAqfko-1rzOwX1tjRQI4n6dsfVmyNAsfPTTVuF4se4gTomTx4uE-gDJ_yj52zeUHca5z4zkbTHZlH44TzF_MC2RfMQe6MLpNdT2EYlSzhWqlCDIMFF0-z101"),
     *          )
     *      ),
     *
     *      @OA\Response(response=403, ref="#/components/requestBodies/response_403"),
     * )
     */

    /**
     * Login api.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('email', 'password');

        if(!Auth::guard('api-user')->attempt($credentials)) {
            return response()->json([
                'success' => false,
                'message' => __('auth.failed'),
            ], 403);
        }

        $user = Auth::guard('api-user')->user();
        $user->tokens()
                ->where('revoked', false)
                ->update(['revoked' => true]);
                // ->delete();

        $tokenResult = $user->createToken($user->email);

        $token = $tokenResult->token;
        if ($request->remember_me) {
            $token->expires_at = Carbon::now()->addMonths(1);
        }
        $token->save();

        return response()->json([
            'success' => true,
            'message' => 'User login successfully.',
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse($token->expires_at)->toDateTimeString(),
            'access_token' => $tokenResult->accessToken
        ]);
    }

    /**
     * @OA\Get(
     *      path="/auth/logout",
     *      operationId="auth/logout",
     *      tags={"Auth"},
     *      summary="logout",
     *      description="",
     *      security={{"api_key": {}}},
     *
     *      @OA\Response(response=200, ref="#/components/requestBodies/response_200"),
     *
     *      @OA\Response(response=401, ref="#/components/requestBodies/response_401"),
     *
     * )
     */
    public function logout(Request $request)
    {
        $request->user()->token()->revoke();

        return response()->json([
            'success' => true,
            'message' => __('Session closed successfully'),
        ]);
    }

    /**
     * @OA\Get(
     *      path="/auth/user",
     *      operationId="auth/user",
     *      tags={"Auth"},
     *      summary="Authenticated user information",
     *      description="",
     *      security={{"api_key": {}}},
     *
     *      @OA\Response(response=200, ref="#/components/requestBodies/response_200"),
     *
     *      @OA\Response(response=401, ref="#/components/requestBodies/response_401"),
     * )
     */
    public function user(Request $request)
    {
        $user = $request->user();

        return $user;
    }


  /**
     * @OA\GET(
     *      path="/auth/profile/{token}",
     *      operationId="/auth/profile/{token}",
     *      tags={"Auth"},
     *      summary="Login Profile",
     *      description="",
     *
     *      @OA\Parameter(
     *          name="token",
     *          in="path",
     *          description="Token profile",
     *          @OA\Schema(
     *               type="string",
     *          ),
     *      ),
     *
     *      @OA\Response(response=200, description="OK",
     *          @OA\JsonContent(
     *              @OA\Property(property="success", example=true),
     *              @OA\Property(property="message", example="User login successfully."),
     *              @OA\Property(property="profile_id", example=1),
     *              @OA\Property(property="token_type", example="Bearer"),
     *              @OA\Property(property="expires_at", example="2022-03-02 17:10:15"),
     *              @OA\Property(property="access_token", example="eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiM2NhOGI5NzhiNDRmMDM5ODYyZDcyZDcwYmQ1ZDFlNGNhNWRiOWFhOWZiM2ZlOGRiN2Y3ZjMwNGFlZWRmOTg4NGRiYjZjZjI1ZGQ5NDNkZTQiLCJpYXQiOjE1OTcxMjk3MjAsIm5iZiI6MTU5NzEyOTcyMCwiZXhwIjoxNjI4NjY1NzE5LCJzdWIiOiI3Iiwic2NvcGVzIjpbXX0.PmPKlqkpQS0UxYVqXb6KdZtoouIUO7NyKW7bj9XweDMwmLUwmvvyCg7Z9wAMgJM0MsQl1-dTgd0XwP9e8Y9DbrAcvkjFVhOHnRPMsILSqNYk6XdFEIvqRtooOMjcdebRjuFO4Y39Tz8EAlfvVdYZu88J-j3ujJuIkE1fxo_wIeGL6gyjwUqeSiiUmM_BqFBvcBUfIaLYBXqkGtnrwNrKX10QcLfimCm6qgk3NtiQuEflFqWzkkq_uQoXOAOmk5UlPgUAWzxfvmmnSJ_B4rpKXa1DWCuP-ePL7ttA_DzuhWYlpTS4ovfdIvbTRg2p5eFOAqfko-1rzOwX1tjRQI4n6dsfVmyNAsfPTTVuF4se4gTomTx4uE-gDJ_yj52zeUHca5z4zkbTHZlH44TzF_MC2RfMQe6MLpNdT2EYlSzhWqlCDIMFF0-z101"),
     *          )
     *      ),
     *
     *      @OA\Response(response=403, ref="#/components/requestBodies/response_403"),
     * )
     */

    /**
     * Attempt user admin by token
     *
     * @param Request $request
     * @param string $token
     * @return void
     */
    public function loginProfile(Request $request,string $token)
    {
        $profile= DeceasedProfile::where('token',$token)->first();

        $user=$profile?  $profile->clients()->wherePivot('declarant', true)->first():null;

        if(!$user) {
            return response()->json([
                'success' => false,
                'message' => __('auth.failed'),
            ], 403);
        }

        Auth::guard('api-user')->login($user);
        $user->tokens()
                ->where('revoked', false)
                ->update(['revoked' => true]);

        $tokenResult = $user->createToken($user->email);

        $token = $tokenResult->token;
        if ($request->remember_me) {
            $token->expires_at = Carbon::now()->addMonths(1);
        }
        $token->save();

        return response()->json([
            'success' => true,
            'message' => 'User login successfully.',
            'profile_id'=> $profile->id,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse($token->expires_at)->toDateTimeString(),
            'access_token' => $tokenResult->accessToken
        ]);
    }
}
