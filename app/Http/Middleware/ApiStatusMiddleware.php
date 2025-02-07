<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ApiStatusMiddleware
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


      $userRole = auth()->user()?->status;

      if ($userRole != 'active') {
        abort(response()->json([
          'status' => 0,
          'message' => 'Inactive account.'
        ], 403));
      }

    return $next($request);


  }
}
