<?php
namespace App\Controller\User;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use Illuminate\Database\Capsule\Manager as DB;

use Core\Controller\BaseController;
use App\Model\User\User;
use App\Model\User\Conapp;
use Core\Model\Hash;
use Core\Model\Auth;
use Core\Model\Config;

class UserContactObjectController extends BaseController
{

	public function getAppend(Request $request, Response $response, $args = []){

		$user = User::find($args['user_id']);
		$conapps = Conapp::all();
		return $this->view($response,'user/create/conobj.twig',compact('user','conapps'));
	}

	public function postAppend(Request $request, Response $response, $args = []){
		
		$user = User::find($request->getParam('user_id'));
		if (!$user) {
			$this->flash('danger', 'Entity append failed because the user could not be found!');
			return $this->redirect($response, 'user.index');
		}

		try{
			    DB::beginTransaction();

			    $user->conobjs()->create($request->getParams());
			   
			    DB::commit();
			    
			}catch(\Exception $e){
				
				 DB::rollback();
				 $this->flash("danger","Entitiy counld not be appended");
				 return $this->redirect($response, 'user.edit',['user_id'=>$user->id]);
			}

		return $this->redirect($response, 'user.edit',['user_id'=>$user->id]);
	}

}