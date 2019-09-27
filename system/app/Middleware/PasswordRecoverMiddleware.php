<?php 
namespace Core\Middleware;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

use Core\Middleware\BaseMiddleware;
use Core\Model\Validator;

class PasswordRecoverMiddleware extends BaseMiddleware
{
	public function __invoke(Request $request, Response $response, $next)
	{	

		$values = $request->getParams();

		$validator =  new Validator($values,[
			'password'=>'required|min:6|max:64|match:confirm_password',
			'confirm_password'=>'required|format:!empty',
		]);

		if (!$validator->passed()) {
			$errors = $validator->errors();
			$old = $values;
			return $this->render($response, 'app/view/passwordchange.twig', compact('errors','old'));
		}

		$response = $next($request, $response);
		
		return $response;
	}
}