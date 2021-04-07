<?php
namespace App\Http\Middleware\API;


use Closure;
use Illuminate\Http\Request;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        $profile_id = $request->route('profile_id');
        $profile = null;

        if (auth()->check()) {
            $profile = auth()->user()->deceased_profiles()
                                    ->where('deceased_profiles.id', $profile_id)
                                    ->first();
        }

        if (!$profile || !in_array($profile->pivot->role, $roles)) {
            return response()->json([
                'success' => false,
                'message' => __('You do not have permissions for the requested resources'),
            ], 403);
        }

        session(['profileWeb' => $profile]);
        return $next($request);
    }
}
