<?php
namespace Core\Controller;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

use Core\Model\Hash;
use Core\Model\Password;
use Core\Model\PhoneNumber;
use Core\Model\Email;
use Core\Model\Username;
use Core\Model\User;

class PasswordRecoverController extends BaseController
{
	public function getPasswordRecoverForm(Request $request, Response $response){

		return $this->view($response,'app/view/passwordrecover.twig');
	}
// 
	public function sendPasswordRecoverEmail(Request $request, Response $response){

		$username = $request->getParam('username');

		if (!preg_match("/[^0-9]/",$username)) 
		   {$obj = PhoneNumber::where('phone_number', $username)->first();}
		else if (!filter_var($username, FILTER_VALIDATE_EMAIL))
			{$obj = Username::where('username', $username)->first();}
		else if (preg_match("/[^a-zA-Z0-9]/",$username))
			{$obj = Email::where('email', $username)->first();}

		if (!$obj) {
			$errors['username'] = ['we could not find this username in our records.'];
			$old = $request->getParams();
			return $this->view($response, 'app/view/passwordrecover.twig', compact('errors','old'));
		}

		$user = $obj->user;
		$verlink = $this->c->router->pathFor('password.change', ['hash'=>$user->password()->hash]);
		$mail = $this->c->mail;
	    $mail->to($user->email); 
	    $mail->setSubject('Engtelligent: Password Recovery');
	    $mail->setBodyFile('mail/passwordrecover.twig',compact('user','verlink'));
	    $mail->send();

		$this->flash("primary","Your password recovery code was emailed to ".$user->email);
		return $this->redirect($response,'app.home');

	}

	public function getPasswordChangeForm(Request $request, Response $response, $args = []){
		
		$password = Password::where('hash',$args['hash'])->latest()->first();

		if (!$password) {
			$this->flash("danger","Invalid password recovery code");
			return $this->redirect($response,'app.home');
		}

		return $this->view($response, 'app/view/passwordchange.twig',compact('password'));
	}

	public function postPasswordChangeForm(Request $request, Response $response){
		$password = Password::where('hash', $request->getParam('hash'))->latest()->first();

		if (!$password) {
			$this->flash("danger","Faild to change password!");
			return $this->redirect($response,'app.home');
		}

		$password->hash = null;
		$data = $request->getParams();
		$user = $password->user;
		$data['salt'] = Hash::render();
		$data['hash'] = Hash::render();
		$data['password'] = Hash::make($request->getParam('password'),$data['salt']);
		$user->passwords()->create($data);
		$password->update();

		$mail = $this->c->mail;
	    $mail->to($user->email); 
	    $mail->setSubject('Engtelligent: Password Change Confirmation');
	    $mail->setBodyFile('mail/passwordchange.twig',compact('user'));
	    $mail->send();

		$this->flash("primary","Your password was successfully updated. You may now login with your new password.");
		return $this->redirect($response,'app.home');
	}


}