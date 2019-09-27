<?php 
namespace Core\Middleware;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

use Core\Middleware\BaseMiddleware;
use Core\Model\Validator;


class RegisterValidationMiddleware extends BaseMiddleware
{
	public function __invoke(Request $request, Response $response, $next)
	{	
		$values = $request->getParams();

		$validator =  new Validator($values,[
			'username'=>'required|min:3|max:64|format:alphaNum|distinct:usernames',
			'email'=>'required|min:4|max:64|format:email|distinct:emails',
			'phone_number'=>'required|format:num|min:11|max:11|distinct:phone_numbers',
			'gender'=>'required|format:!empty',
			'date_of_birth'=>'required|format:!empty',
		]);

		if (!$validator->passed()) {
			$errors = $validator->errors();
			$old = $values;
			return $this->render($response, 'app/view/register.twig', compact('errors','old'));
		}

		$response = $next($request, $response);
		
		return $response;
	}
}