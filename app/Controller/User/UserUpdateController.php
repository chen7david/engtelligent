<?php
namespace App\Controller\User;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use Illuminate\Database\Capsule\Manager as DB;

use Core\Controller\BaseController;
use App\Model\User\User;
use Core\Model\UploadedFiles;
use Core\Model\Hash;
use Core\Model\Config;

class UserUpdateController extends BaseController
{
	public function add(Request $request, Response $response){
		
		try{
			    DB::beginTransaction();

			    	$data['username'] = 'NewUser';
			    	$data['date_of_birth'] = '2018-10-11';
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
						'name' => 'default.png',
						'type' => 'png',
					]);

			    DB::commit();
			    
			}catch(\Exception $e){
				
				 DB::rollback();
				 $this->flash("danger","Your account was not created, please try again");
				 return $this->redirect($response, 'user.index');
			}

		return $this->redirect($response, 'user.index');
	}

	public function edit(Request $request, Response $response, $args = []){
		$user = User::find($args['user_id']);
		if (!$user) {
			$this->flash('danger', 'This user could not be found!');
			return $this->redirect($response, 'user.index');
		}
		return $this->view($response,'user/edit.twig', compact('user'));
	}

	public function update(Request $request, Response $response, $args = []){

		try{
			    DB::beginTransaction();

			    	$data = $request->getParams();
					$user = User::find($args['user_id']);

					$user->update([
						'first_name' => $request->getParam('first_name'),
						'last_name' => $request->getParam('last_name'),
						'gender' => $request->getParam('gender'),
						'date_of_birth' => $request->getParam('date_of_birth'),
						'country_of_birth' => $request->getParam('country_of_birth'),
						'place_of_birth' => $request->getParam('place_of_birth'),
					]);

					$user->usernames()->update([
						'username'=>$request->getParam('username'),
					]);

					foreach ($data['email'] as $email) {
						$user->emails()->whereId($email['id'])->update([
							'email'=>$email['email'],
						]);
					}

					foreach ($data['phone_number'] as $phone_number) {
						$user->phonenumbers()->whereId($phone_number['id'])->update([
							'phone_number'=>$phone_number['phone_number'],
						]);
					}

					if ($data['middle_name']) {
						
						foreach ($data['middle_name'] as $middle_name) {
							$user->middlenames()->whereId($middle_name['id'])->update([
								'middle_name'=>$middle_name['middle_name'],
							]);
						}
					}

					if ($data['maiden_name']) {
						
						foreach ($data['maiden_name'] as $maiden_name) {
							$user->maidennames()->whereId($maiden_name['id'])->update([
								'maiden_name'=>$maiden_name['maiden_name'],
							]);
						}
					}

					if ($data['native_name']) {
						
						foreach ($data['native_name'] as $native_name) {
							$user->nativenames()->whereId($native_name['id'])->update([
								'native_name'=>$native_name['native_name'],
							]);
						}
					}

					if ($data['nick_name']) {
						
						foreach ($data['nick_name'] as $nick_name) {
							$user->nicknames()->whereId($nick_name['id'])->update([
								'nick_name'=>$nick_name['nick_name'],
							]);
						}
					}

					if ($data['conobj']) {
						
						foreach ($data['conobj'] as $conobj) {
							$user->conobj()->whereId($conobj['id'])->update([
								'text'=>$conobj['text'],
							]);
						}
					}

					$uploadedFile = new UploadedFiles();
					$uploadedFile->getFiles($request,'avatar');

					if (!$uploadedFile->hasError()) {

						if ($uploadedFile->getFileSize() > 0) {
							if (in_array($uploadedFile->getExtension(), ['png','jpeg'])) {
								// kill($uploadedFile->getFileSize());
								$uploadedFile->moveToDir(config('path.image.avatar'));
								$user->avatars()->create([
									'name' => $uploadedFile->getFileName(),
									'type' => $uploadedFile->getMediaType(),
								]);
							}
						}
					}

			    DB::commit();
			    
			}catch(\Exception $e){
				
				 DB::rollback();
				 $this->flash("danger","Your changes were not saved, please try again");
				 return $this->redirect($response, 'user.show',['user_id'=>$user->id]);
			}
		$this->flash("info","Your information was saved!");
		return $this->redirect($response, 'user.show',['user_id'=>$user->id]);
	}
}