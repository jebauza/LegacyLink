<?php
namespace App\Http\Middleware\API;


use Closure;
use Illuminate\Http\Request;
use App\Models\DeceasedProfile;

class CheckProfile
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $profile_id = $request->route('profile_id');

        $profile = DeceasedProfile::find($profile_id);

        if (!$profile) {

            return response()->json([
                'success' => false,
                'message' => __('Bad Request'),
            ], 400);
        }

        session(['profileWeb' => $profile]);
        return $next($request);
    }
}
