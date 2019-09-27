<?php
namespace Core\Controller;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

use Core\Model\Hash;
use Core\Model\Password;
// use Core\Model\PhoneNumber;
// use Core\Model\Email;
use Core\Model\Auth;
use Core\Model\User;

class PasswordUpdateController extends BaseController
{
	public function getPasswordUpdate(Request $request, Response $response){
		$password = Auth::user()->password();
		return $this->view($response,'app/view/passwordupdate.twig',compact('password'));
	}

	public function postPasswordUpdate(Request $request, Response $response){

		$user = Auth::user();
		$password = Password::where('hash',$request->getParam('hash'))->latest()->first();

		if (!$password) {
			$this->flash("danger","Password update faild!");
			return $this->redirect($response,'password.update');
		}

		if (!($user->password == Hash::make($request->getParam('old_password'), $password->salt))) {
			$errors['old_password'] = ['incorrect password'];
			$old = $request->getParams();

			return $this->view($response, 'app/view/passwordupdate.twig', compact('errors','old','password'));
		}

		$password->hash = null;
		$pwdObj['salt'] = Hash::render();
		$pwdObj['hash'] = Hash::render();
		$pwdObj['password'] = Hash::make($request->getParam('new_password'),$pwdObj['salt']);
		
		if ($user->passwords()->create($pwdObj)) {
			$password->update();

			$mail = $this->c->mail;
		    $mail->to($user->email); 
		    $mail->setSubject('Engtelligent: Password Update Confirmation');
		    $mail->setBodyFile('mail/passwordchange.twig',compact('user'));
		    $mail->send();

			$this->flash("primary","Your password was successfully updated!");
			return $this->redirect($response,'app.home');
		}

		$this->flash("primary","Password update faild!");
		return $this->redirect($response,'password.update');
		
	}

}