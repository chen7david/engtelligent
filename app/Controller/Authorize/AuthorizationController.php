<?php
namespace App\Controller\Authorize;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

use Core\Controller\BaseController;
use App\Model\User\User;
use Core\Model\Hash;
use Core\Model\Auth;


use App\Model\Authorize\Authorization;

class AuthorizationController extends BaseController
{
	public function check(Request $request, Response $response){
		$user = Auth::user();
		$authorize = Authorization::create([
			'user_id'=>$user->id,
			'code'=>strtoupper(Hash::render(8)),
			'type'=>1,
		]);

		if (!$user || !$authorize) {
			$this->flash('danger','Please login before accessing this page.');
			return $this->redirect($response,'app.login');
		}

		$this->flash('success','This user is authorized to perform this action.');
		return $this->view($response,'authorize/index.twig', compact('user','authorize'));
	}

	public function report(Request $request, Response $response){

		$authorizations = Authorization::orderBy('created_at','desc')->get();
		if (!$authorizations) {
			$this->flash('danger','Please try again.');
			return $this->redirect($response,'app.home');
		}

		$this->flash('success','Here you can see who is authorized.');
		return $this->view($response,'authorize/show.twig', compact('authorizations'));
	}
}