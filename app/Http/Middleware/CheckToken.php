<?php

namespace App\Http\Middleware;

use App\User;
use Closure;
use Illuminate\Http\Response;

class CheckToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(empty($request->get('token'))) {
            return response()->json([
                'error' => true,
                'messages' => 'missing token parameter'
            ], Response::HTTP_BAD_REQUEST);
        }

        $user = User::where([
            'token' => $request->get('token'),
        ])->first();

        if (empty($user)) {
            return response()->json([
                'error' => true,
                'messages' => [
                    'invalid token',
                ]
            ], Response::HTTP_UNAUTHORIZED);
        }

        return $next($request);
    }
}
