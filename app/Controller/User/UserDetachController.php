<?php
namespace App\Controller\User;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use Illuminate\Database\Capsule\Manager as DB;

use Core\Controller\BaseController;
use App\Model\User\User;
use Core\Model\Hash;
use Core\Model\Config;

class UserDetachController extends BaseController
{
	public function detach(Request $request, Response $response, $args = []){

		// echo "<pre>";
		// print_r($args);
		// die();
		
		$user = User::find($args['user_id']);
		if (!$user) {
			$this->flash('error', 'Entity detach failed because the user could not be found!');
			return $this->redirect($response, 'user.index');
		}


		try{
			    DB::beginTransaction();

			    switch ($args['obj']) {
			    	case 'email':
						$user->emails()->whereId($args['obj_id'])->delete();
						break;
			    	case 'phone_number':
						$user->phonenumbers()->whereId($args['obj_id'])->delete();
						break;
					case 'middle_name':
						$user->middlenames()->whereId($args['obj_id'])->delete();
						break;
					case 'maiden_name':
						$user->maidennames()->whereId($args['obj_id'])->delete();
						break;
					case 'native_name':
						$user->nativenames()->whereId($args['obj_id'])->delete();
						break;
					case 'nick_name':
						$user->nicknames()->whereId($args['obj_id'])->delete();
						break;
					case 'conobj':
						$user->conobj()->whereId($args['obj_id'])->delete();
						break;				
					default:
						# code...
						break;
				}

			    DB::commit();
			    
			}catch(\Exception $e){
				
				 DB::rollback();
				 $this->flash("danger","Entitiy counld not be detached");
				 return $this->redirect($response, 'user.show',['user_id'=>$user->id]);
			}

		return $this->redirect($response, 'user.show',['user_id'=>$user->id]);
	}


}