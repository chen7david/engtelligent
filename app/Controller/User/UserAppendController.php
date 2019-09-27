<?php
namespace App\Controller\User;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use Illuminate\Database\Capsule\Manager as DB;

use Core\Controller\BaseController;
use App\Model\User\User;
use Core\Model\Hash;
use Core\Model\Config;

class UserAppendController extends BaseController
{
	public function append(Request $request, Response $response, $args = []){

		// echo "<pre>";
		// print_r($args);
		// die();
		
		$user = User::find($args['user_id']);
		if (!$user) {
			$this->flash('danger', 'Entity append failed because the user could not be found!');
			return $this->redirect($response, 'user.index');
		}

		try{
			    DB::beginTransaction();

			    switch ($args['obj']) {
			    	case 'email':
						$user->emails()->create([]);
						break;
			    	case 'phone_number':
						$user->phonenumbers()->create([]);
						break;
					case 'middle_name':
						$user->middlenames()->create([]);
						break;
					case 'maiden_name':
						$user->maidennames()->create([]);
						break;
					case 'native_name':
						$user->nativenames()->create([]);
						break;
					case 'nick_name':
						$user->nicknames()->create([]);
						break;
					case 'wechat':
						$user->wechats()->create([]);
						break;
					case 'qq':
						$user->qqs()->create([]);
						break;
					case 'skype':
						$user->skypes()->create([]);
						break;
					
					default:
						# code...
						break;
				}

			    DB::commit();
			    
			}catch(\Exception $e){
				
				 DB::rollback();
				 $this->flash("danger","Entitiy counld not be appended");
				 return $this->redirect($response, 'user.show',['user_id'=>$user->id]);
			}

		return $this->redirect($response, 'user.show',['user_id'=>$user->id]);
	}

	public function edit(Request $request, Response $response, $args = []){
		
		return $this->view($response,'user/edit.twig', compact('user'));
	}


}