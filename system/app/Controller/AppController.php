<?php
namespace Core\Controller;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

use App\Model\App\Hash;
use App\Model\Auth\Password;
use App\Model\Auth\Session;
use Core\Model\User;
use Core\Model\Auth;

class AppController extends BaseController
{
	public function home(Request $request, Response $response){
		if (Auth::user()) {
			return $this->redirect($response,'profile.index');
		}
		return $this->redirect($response,'app.login');
	}
}