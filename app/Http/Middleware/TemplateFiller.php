<?php namespace App\Http\Middleware;

use Closure;
use App\lookup;
use Illuminate\Support\Facades\Session;

class TemplateFiller {


    /**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{

        $lookupManager = new lookup();
        $categories = $lookupManager->getCategories();

        // Using session flash here, as can't find a way to pass a variable from middleware to view directly
        Session::flash('api_categories', $categories);

		return $next($request);
	}

}
