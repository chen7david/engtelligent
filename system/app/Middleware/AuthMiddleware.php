<?php 
namespace Core\Middleware;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

use Core\Middleware\BaseMiddleware;

class AuthMiddleware extends BaseMiddleware
{
	public function __invoke(Request $request, Response $response, $next)
	{	
		$auth = $request->getAttribute('auth');
		if(!$auth){
			$this->flash('warning','Please login before accessing this resource!');
			return $this->redirect($response, 'app.login');
		}

		$response = $next($request, $response);
		return $response;
	}
}