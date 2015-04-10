<?php namespace App\Http\Middleware;

use Closure;
use Auth;

class IsLogin {

	public function __construct()
	{
	}

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
		if (!Auth::user())
		{
			if ($request->ajax())
			{
				return response('Unauthorized.', 401);
			}
			else
			{
				return redirect('auth/login');
			}
		}
		return $next($request);
	}

}
