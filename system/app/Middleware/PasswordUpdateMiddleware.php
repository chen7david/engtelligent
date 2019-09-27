<?php 
namespace Core\Middleware;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

use Core\Middleware\BaseMiddleware;
use Core\Model\Password;
use Core\Model\Validator;

class PasswordUpdateMiddleware extends BaseMiddleware
{
	public function __invoke(Request $request, Response $response, $next)
	{	

		$values = $request->getParams();

		$validator =  new Validator($values,[
			'old_password'=>'required|min:6|max:64',
			'new_password'=>'required|min:6|max:64|match:confirm_new_password',
			'confirm_new_password'=>'required|format:!empty',
		]);

		if (!$validator->passed()) {
			$errors = $validator->errors();
			$old = $values;
			$password = Password::where('hash',$request->getParam('hash'))->latest()->first();
			return $this->render($response, 'app/view/passwordupdate.twig', compact('errors','old','password'));
		}

		$response = $next($request, $response);
		
		return $response;
	}
}