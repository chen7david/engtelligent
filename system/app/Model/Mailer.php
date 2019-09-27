<?php
namespace Core\Model;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use Slim\Views\Twig;
use Core\Model\Config;
use Core\Model\User;
/**
 * 
 */
class Mailer
{
	protected $mailer,
			  $view;

	public function __construct($view, $mailer){

    	$this->view = $view;
    	$this->mailer = $mailer;
    }

	public function from($mail){

		$this->mailer->setFrom($mail);
	}

	public function to($email){

		$this->mailer->addAddress($email);
	}

	public function setSubject(string $subject){
		$this->mailer->Subject = $subject;
	}

	public function setBody(string $body){

		$this->mailer->Body = $body;
	}

	public function setBodyFile(string $file, $data = []){
		$this->setBody($this->view->fetch($file, $data));
	}

	public function setAltBody(string $altBody){

		$this->mailer->AltBody = $altBody;
	}

	public function send(){

		$this->mailer->send();
	}
	
}







                            

    