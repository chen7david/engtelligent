<?php
namespace Core\Controller;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use Illuminate\Database\Capsule\Manager as DB;

use Core\Model\Hash;
use Core\Model\Config;
use App\Model\User\User;

class RegisterController extends BaseController
{
	public function getRegister(Request $request, Response $response){

		return $this->view($response,'app/view/register.twig');
	}

	public function postRegister(Request $request, Response $response){

		 try{
			    DB::beginTransaction();

			    	$data = $request->getParams();
			    	$data['user_id'] = 'ENG'.strtoupper(Hash::render(5));
					$user = User::create($data);
					$data['is_primary'] = true;
					$user->usernames()->create($data);
					$data['hash'] = Hash::render();
					$user->emails()->create($data);
					$data['hash'] = Hash::render();
					$user->phoneNumbers()->create($data);
					$data['salt'] = Hash::render();
					$data['hash'] = Hash::render();
					$data['password'] = Hash::make(Config::get('default.password'),$data['salt']);
					$user->passwords()->create($data);
					$user->addRole(Config::get('default.role'));
					$user->updateLeague(Config::get('default.league'));
					$user->avatars()->create([
						'name'=>'default.png',
						'type'=>'png'
					]);

			    DB::commit();
			    
			}catch(\Exception $e){
				
				 DB::rollback();
				 $this->flash("danger","Your account was not created, please try again");
				 return $this->redirect($response, 'app.register');
			}

		$verlink = $this->c->router->pathFor('email.verify', ['hash'=>$user->email()->hash]);
	    $mail = $this->c->mail;

	    $mail->to($user->email); 
	    $mail->setSubject('Engtelligent: Registered Confirmation');
	    $mail->setBodyFile('mail/registeredconfirmation.twig',compact('user'));
	    $mail->send();

	    $mail->to($user->email);
	    $mail->setSubject('Engtelligent: Email Activation');
	    $mail->setBodyFile('mail/emailactivation.twig',compact('user','verlink'));
	    $mail->send();

		$this->flash("primary","Your account has been created, please check your email (".$user->email.") and follow the instructions to activate your account");
		return $this->redirect($response, 'app.home');
	}
}