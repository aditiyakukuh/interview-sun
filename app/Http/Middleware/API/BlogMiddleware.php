<?php

namespace App\Http\Middleware\API;

use Closure;
use Illuminate\Http\Request;

class BlogMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $user = auth()->user();
        if ($user->role == 'blog') {
            return $next($request);
        }
        return response()->json([
            'message' => 'your are not Blog Role account'
        ], 403);
    }
}
