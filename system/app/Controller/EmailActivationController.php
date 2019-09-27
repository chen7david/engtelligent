<?php
namespace Core\Controller;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

use Core\Model\Email;

class EmailActivationController extends BaseController
{
	public function verifyEmail(Request $request, Response $response, $args = []){
		$email = Email::where('hash',$args['hash'])->latest()->first();
		if (!$email) {
			$this->flash("danger","Invalid email verification code");
			return $this->redirect($response, 'app.home');
		}

		if ($email->is_verified == true) {
			$this->flash("warning","Your email is already verified, please directly proceed to login!");
			return $this->redirect($response, 'app.login');
		}

		$email->is_verified = true;
		$email->update();

		$this->flash("primary","Thansk for activating your account! You can now login!");
		return $this->redirect($response, 'app.login');
	}

	public function resendVerCode(Request $request, Response $response, $args = []){
		$email = Email::where('hash',$args['hash'])->latest()->first();
		if (!$email) {
			$this->flash("danger","Invalid email verification code!");
			return $this->redirect($response, 'app.login');
		}

		$verlink = $this->c->router->pathFor('email.verify', ['hash'=>$email->hash]);
		$user = $email->user;
		$mail = $this->c->mail;
	    $mail->to($email->email); 
	    $mail->setSubject('Engtelligent: Email Verification');
	    $mail->setBodyFile('mail/emailactivation.twig',compact('user','verlink'));
	    $mail->send();

	    $this->flash("info","A new confirmation was emailed to (".$user->email.") you. Sometimes it might also endup in your spam/junk-mail.");
		return $this->redirect($response, 'app.login');
	}
}