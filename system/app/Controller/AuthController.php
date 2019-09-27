<?php
namespace Core\Controller;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

use Carbon\Carbon;
use Core\Model\Hash;
use Core\Model\Config;
use Core\Model\Cookie;
use Core\Model\Token;
use Core\Model\Email;
use Core\Model\Username;
use Core\Model\PhoneNumber;


class AuthController extends BaseController
{

	public function getLogin(Request $request, Response $response){
		return $this->view($response,'app/view/login.twig');
	}

	public function postLogin(Request $request, Response $response){

		$username = $request->getParam('username');

		if (!preg_match("/[^0-9]/",$username)) 
		   {$obj = PhoneNumber::where('phone_number', $username)->latest()->first(); $authType = Config::get('auth.phone_number');}
		else if (!filter_var($username, FILTER_VALIDATE_EMAIL))
			{$obj = Username::where('username', $username)->latest()->first(); $authType = Config::get('auth.username');}
		else if (preg_match("/[^a-zA-Z0-9]/",$username))
			{$obj = Email::where('email', $username)->latest()->first(); $authType = Config::get('auth.email');}

		if (!$obj) {
			$errors['username'] = ['username is not registered'];
			$old = $request->getParams();
			return $this->view($response, 'app/view/login.twig', compact('errors','old'));
		}

		$user = $obj->user;

		if (!$user->email()->is_verified()) {

			$this->flash('linktitle','Email NOT Activated:');
			$this->flash('textbeforelink','Please activate your email and try again. look for an email titled "Activation Email". If you did not receive it then click');
			$this->flash('textlink','here');
			$this->flash('textafterlink',' to resend.');
			$this->flash('paramone', $user->email()->hash);

			return $this->redirect($response, 'app.login');
		}

		if (!($user->password == Hash::make($request->getParam('password'), $user->password()->salt))) {
			$errors['password'] = ['incorrect password'];
			$old = $request->getParams();
			return $this->view($response, 'app/view/login.twig', compact('errors','old'));
		}

		$user->limitActiveTokens();
		
		$token = $user->tokens()->create([
			'auth' => $authType,
			'active' => true,
			'hash' => Hash::render(),
			'calls' => 0,
			'persited_at'=> Carbon::NOW(),
		]);

		if (!$token) {
			$this->flash('danger', 'Login faild, something went wrong!');	
			return $this->redirect($response, 'app.login');
		}

		$cookie = Cookie::setToken($token);

		if (!$cookie) {
			$token->delete();
			$this->flash('danger', 'Login faild, we could not set your cookie!');	
			return $this->redirect($response, 'app.login');
		}

		$this->flash('success', 'Welcome back '.$user->name."!");	
		return $this->redirect($response, 'profile.index');
		
	}

	public function logout(Request $request, Response $response){
		$token = Token::where('hash',Cookie::getToken())->latest()->first();
		if (!$token) {
			$this->flash('danger', 'We failed to log you out, please try again!');	
			return $this->redirect($response, 'app.login');
		}

		Cookie::unsetToken();
		$token->delete();

		$this->flash('success', 'Bye now, see you later!');	
		return $this->redirect($response, 'app.login');
	}
}