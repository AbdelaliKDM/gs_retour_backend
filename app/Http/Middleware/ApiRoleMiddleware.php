<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ApiRoleMiddleware
{
  /**
   * Handle an incoming request.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
   * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
   */
  public function handle(Request $request, Closure $next, ...$roles)
  {

    if ($roles) {
      $userRole = auth()->user()?->role;

      if (!in_array($userRole, $roles)) {
        abort(response()->json([
          'status' => 0,
          'message' => 'Forbidden'
        ], 403));
      }
    }


    return $next($request);


  }
}
