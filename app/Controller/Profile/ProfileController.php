<?php
namespace App\Controller\Profile;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

use Core\Controller\BaseController;

use App\Model\Group\Group;
use App\Model\Group\Session;
use App\Model\User\User;
use Core\Model\Auth;
use App\Model\Learn\Lesson;
use App\Model\Learn\LessonVideo;
use App\Model\Learn\LessonAudio;

class ProfileController extends BaseController
{
	public function index(Request $request, Response $response){

		return $this->view($response,'profile/index.twig',compact('groups'));
	}

	public function session(Request $request, Response $response, $args = []){
		$session = Session::find($args['session_id']);
		return $this->view($response,'profile/session.twig',compact('session'));
	}



	public function show(Request $request, Response $response, $args = []){
		$group = Group::find($args['group_id']);
		$users = $group->users;

		if (!$group) {
			$this->flash('error', 'This group could not be found!');
			return $this->redirect($response, 'group.index');
		}
		return $this->view($response,'group/show.twig', compact('group','users'));
	}

	public function store(Request $request, Response $response){

		$group = Group::create([
			'name'=>'New Group',
			'description'=>'Write your description here.',
		]);

		if (!$group) {
				$this->flash('error', 'The group was not saved, please try again!');
			}	
		return $this->redirect($response, 'group.index');
	}

	public function edit(Request $request, Response $response, $args = []){
		$group = Group::find($args['group_id']);
		$users = $users = User::all()->except(Auth::id());

		if (!$group) {
			$this->flash('error', 'This group could not be found!');
			return $this->redirect($response, 'group.index');
		}
		
		return $this->view($response,'group/edit.twig', compact('group','users'));
	}

	public function update(Request $request, Response $response, $args = []){

		$group = Group::find($args['group_id']);
		if (!$group) {
			$this->flash('error', 'This group could not be updated!');
			return $this->redirect($response, 'group.index');
		}
		$group->update($request->getParams());
		$group->users()->sync($request->getParam('users'),true);

		if (!$group) {
			$this->flash('error', 'This group could not be updated!');
			return $this->redirect($response, 'group.index');
		}

		$this->flash('success', 'Your changes were saved!');
		return $this->redirect($response,'group.edit',['group_id'=>$group->id]);		
	}

	public function delete(Request $request, Response $response, $args = []){
		$group = Group::find($args['group_id']);
		if (!$group) {
			$this->flash('error', 'This group could not be found!');
			return $this->redirect($response, 'group.index');
		}
		$group->delete();
		$this->flash('success', 'group successfully deleted !');
		return $this->redirect($response,'group.index');
		
	}

	public function showaudio(Request $request, Response $response, $args = []){

		$lessonaudio = LessonAudio::find($args['lessonaudio_id']);
		$session = Session::find($args['session_id']);

		if (!$lessonaudio || !$session) {
			$this->flash('danger', 'This lesson audio could not be found!');
			return $this->redirect($response, 'profile.index');
		}
		return $this->view($response,'profile/lessonaudio.twig', compact('lessonaudio','session'));
	}

	public function showvideo(Request $request, Response $response, $args = []){
		$lessonvideo = LessonVideo::find($args['lessonvideo_id']);
		$session = Session::find($args['session_id']);

		if (!$lessonvideo) {
			$this->flash('danger', 'This lesson video could not be found!');
			return $this->redirect($response, 'profile.index');
		}
		return $this->view($response,'profile/lessonvideo.twig', compact('lessonvideo','session'));
	}
}