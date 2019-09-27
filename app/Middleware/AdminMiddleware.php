<?php 
namespace App\Middleware;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

use Core\Middleware\BaseMiddleware;

class AdminMiddleware extends BaseMiddleware
{
	public function __invoke(Request $request, Response $response, $next)
	{	
		$auth = $request->getAttribute('auth');

		if(!$auth->user()->hasRole('super_admin')){
			$this->flash('warning','You are not authorized to access that resource!');
			return $this->redirect($response, 'profile.index');
		}

		$response = $next($request, $response);
		return $response;
	}
}