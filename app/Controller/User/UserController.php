<?php
namespace App\Controller\User;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use Illuminate\Database\Capsule\Manager as DB;

use Core\Controller\BaseController;
use Core\Model\Auth;
use App\Model\User\User;
use Core\Model\Hash;
use Core\Model\Config;


class UserController extends BaseController
{
	public function index(Request $request, Response $response){
		$users = User::orderBy('created_at','desc')->get()->except(Auth::id());
		return $this->view($response,'user/index.twig',compact('users'));
	}

	public function show(Request $request, Response $response, $args = []){
		$user = User::find($args['user_id']);
		if (!$user) {
			$this->flash('error', 'This user could not be found!');
			return $this->redirect($response, 'user.index');
		}
		return $this->view($response,'user/show.twig', compact('user'));
	}

	public function delete(Request $request, Response $response, $args = []){
		$user = User::find($args['user_id']);
		if (!$user) {
			$this->flash('error', 'This user could not be found!');
			return $this->redirect($response, 'user.index');
		}

		$user->delete();
		$this->flash('info', 'User successfully deleted !');
		return $this->redirect($response,'user.index');	
	}

	

	
}