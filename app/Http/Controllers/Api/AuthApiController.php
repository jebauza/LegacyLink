<?php
namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use App\Models\User;
use App\Helpers\SMSHelper;
use App\Models\Invitation;
use Illuminate\Http\Request;
use App\Models\DeceasedProfile;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use App\Http\Resources\Api\UserApiResource;


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
     *
     *      @OA\Response(response=422, description="Error: Unprocessable Entity",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", example="The given data was invalid."),
     *              @OA\Property(property="errors", description="these are the fields of the request",
     *                  @OA\Property(property="email", example={"El campo correo es obligatorio."}),
     *                  @OA\Property(property="password", example={"El campo password es obligatorio."}),
     *              )
     *          )
     *      ),
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
     *      path="/auth/user/{profile_id}",
     *      operationId="/auth/user/{profile_id}",
     *      tags={"Auth"},
     *      summary="Authenticated user information",
     *      description="",
     *      security={{"api_key": {}}},
     *
     *      @OA\Parameter(ref="#/components/parameters/profile_id"),
     *
     *      @OA\Response(response=200, description="OK",
     *          @OA\JsonContent(
     *              @OA\Property(property="success", example=true),
     *              @OA\Property(property="message", example="User login successfully."),
     *              @OA\Property(property="data", ref="#/components/schemas/UserAuthApiResource")),
     *          )
     *      ),
     *
     *      @OA\Response(response=401, ref="#/components/requestBodies/response_401"),
     * )
     */
    public function user(Request $request)
    {
        $profile = session('profileWeb');

        $user = auth()->user();
        $user->add_profile = $profile->id;
        $user->add_role = $profile->pivot->role;

        return $this->sendResponse(null, (new UserApiResource($user)));
    }


  /**
     * @OA\GET(
     *      path="/auth/login/declarant",
     *      operationId="/auth/login/declarant",
     *      tags={"Auth"},
     *      summary="Login Profile",
     *      description="",
     *
     *      @OA\Parameter(
     *          name="token",
     *          in="query",
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
     *
     *      @OA\Response(response=422, description="Error: Unprocessable Entity",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", example="The given data was invalid."),
     *              @OA\Property(property="errors", description="these are the fields of the request",
     *                  @OA\Property(property="token", example={"El campo token es obligatorio."}),
     *              )
     *          )
     *      ),
     * )
     */

    /**
     * Attempt user admin by token
     *
     * @param Request $request
     * @param string $token
     * @return void
     */
    public function loginProfile(Request $request)
    {
        $request->validate([
            'token' => 'required|string',
        ]);

        $profile = DeceasedProfile::where('token', $request->token)->first();

        $user = $profile ? $profile->clients()->wherePivot('declarant', true)->first() : null;

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

    /**
     * @OA\Post(
     *      path="/auth/profile/join",
     *      operationId="/auth/profile/join",
     *      tags={"Auth"},
     *      summary="Add user to profile",
     *      description="Add user to profile",
     *      security={{"api_key": {}}},
     *
     *      @OA\RequestBody(
     *          required=true,
     *          description="Pass user credentials",
     *          @OA\JsonContent(
     *              required={"token"},
     *              @OA\Property(property="token", type="string", example="Dfghre3rtt5"),
     *          ),
     *      ),
     *
     *      @OA\Response(response=200, description="OK",
     *          @OA\JsonContent(
     *              @OA\Property(property="success", example=true),
     *              @OA\Property(property="message", example="Added to invitation profile successfully"),
     *              @OA\Property(property="profile_id", example=3),
     *          )
     *      ),
     *
     *      @OA\Response(response=401, ref="#/components/requestBodies/response_401"),
     *
     *      @OA\Response(response=403, ref="#/components/requestBodies/response_403"),
     *
     *      @OA\Response(response=422, description="Error: Unprocessable Entity",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", example="The given data was invalid."),
     *              @OA\Property(property="errors", description="these are the fields of the request",
     *                  @OA\Property(property="token", example={"El campo correo es obligatorio."})
     *              )
     *          )
     *      ),
     * )
     */
    public function profileJoin(Request $request)
    {
        $request->validate([
            'token' => 'required|string',
        ]);

        $invitation = Invitation::where('token',  $request->token)->first();

        if (!$invitation || $invitation->used_by) {
            return response()->json([
                'success' => false,
                'message' => __('The invitation is invalid or has already been used'),
            ], 403);
        }

        $profile = $invitation->profile;

        try {
            DB::beginTransaction();
            $client = $profile->clients()->find(auth()->user()->id);
            if ($client) {
                $profile->clients()->updateExistingPivot(auth()->user()->id, ['role' => $invitation->role]);
            } else {
                $profile->clients()->attach(auth()->user()->id, ['role' => $invitation->role]);
            }
            $invitation->used_by = now();
            $invitation->to = auth()->user()->id;
            $invitation->save();

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => __('Added to invitation profile successfully'),
                'profile_id'=> $profile->id
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return $this->sendError500($e->getMessage());
        }
    }


    /**
     * @OA\Post(
     *      path="/auth/register",
     *      operationId="/auth/register",
     *      tags={"Auth"},
     *      summary="Register user",
     *      description="Register user",
     *      security={{"api_key": {}}},
     *
     *      @OA\RequestBody(
     *          required=true,
     *          description="Pass user credentials",
     *          @OA\JsonContent(
     *              required={"name","lastname","email","phone","password","password_confirmation"},
     *              @OA\Property(property="name", type="string", example="Maria Luisa", title="required|string|max:255"),
     *              @OA\Property(property="lastname", type="string", example="Perez Perez", title="required|string|max:255"),
     *              @OA\Property(property="email", type="string", example="maria@gmail.com", title="required|string|email|max:255|unique:users,email"),
     *              @OA\Property(property="phone", type="string", example="+34622459652", title="required|string|phone:ES,mobile|max:20"),
     *              @OA\Property(property="password", type="string", example="qweasd12", title="required|string|min:8|confirmed"),
     *              @OA\Property(property="password_confirmation", type="string", example="Dfghre3rtt5", title="required"),
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
     *      @OA\Response(response=422, description="Error: Unprocessable Entity",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", example="The given data was invalid."),
     *              @OA\Property(property="errors", description="these are the fields of the request",
     *                  @OA\Property(property="name", example={"El campo correo es obligatorio."}),
     *                  @OA\Property(property="lastname", example={"El campo correo es obligatorio."}),
     *                  @OA\Property(property="email", example={"El campo correo es obligatorio."}),
     *                  @OA\Property(property="phone", example={"El campo correo es obligatorio."}),
     *                  @OA\Property(property="password", example={"El campo correo es obligatorio."}),
     *                  @OA\Property(property="password_confirmation", example={"El campo correo es obligatorio."})
     *              )
     *          )
     *      ),
     *
     *      @OA\Response(response=500, ref="#/components/requestBodies/response_500"),
     * )
     */
    public function register(Request $request)
    {
            $request->validate([
                'name' => 'required|string|max:255',
                'lastname' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users,email',
                'phone' => 'required|string|phone:ES,mobile|max:20',
                'password' => 'required|string|min:8|confirmed',
                'password_confirmation' => 'required',
            ]);

            try {
                DB::beginTransaction();
                $newUser = new User($request->all());
                $newUser->password = Hash::make($request->password);
                if ($newUser->save()) {
                    DB::commit();

                    $response = Http::withHeaders([
                        'Accept' => 'application/json',
                        'x-requested-with' => 'XMLHttpRequest'
                    ])
                    ->withOptions([
                        // 'verify' => false
                    ])
                    ->post(route('api.auth.login'), [
                        'email' => $newUser->email,
                        'password' => $request->password,
                    ]);

                    if ($response->successful()) {
                        $login = json_decode($response->getBody(), true);
                        return response()->json($login);
                    } elseif ($response->failed()) {
                        return $this->sendError500($response->getBody()->getContents());
                    }

                    return $this->sendError500($response->getBody()->getContents());
                }
            } catch (\Exception $e) {
                DB::rollBack();
                return $this->sendError500($e->getMessage());
            }
    }
}
