<?php
namespace App\Controller\Group;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

use Core\Controller\BaseController;

use App\Model\Group\Group;
use App\Model\Group\Session;
use App\Model\Learn\Lesson;
use App\Model\User\User;
use App\Model\Location\Address;

class SessionController extends BaseController
{
	public function index(Request $request, Response $response){
		$sessions = Session::all();
		return $this->view($response,'session/index.twig',compact('sessions'));
	}

	public function show(Request $request, Response $response, $args = []){
		$session = Session::find($args['session_id']);
		$group = Group::find($session->group_id);

		if (!$session) {
			$this->flash('danger', 'This session could not be found!');
			return $this->redirect($response, 'session.index');
		}
		return $this->view($response,'session/show.twig', compact('session','group'));
	}

	public function create(Request $request, Response $response,  $args = []){
		$lessons = Lesson::orderBy('name','asc')->get();
		$group = Group::find($args['group_id']);
		return $this->view($response,'session/create.twig', compact('group','lessons'));
	}

	public function store(Request $request, Response $response, $args = []){
		$data = $request->getParams();
		$session = Session::create($data);
        
		if (!$session) {
			$this->flash('danger', 'The session was not saved, please try again!');
			return $this->redirect($response, 'group.index');
		}	

		$session->lessons()->sync($data['lessons'],true);

		$this->flash('success', 'The session was saved!');
		return $this->redirect($response, 'group.show',['group_id'=>$args['group_id']]);
	}

	public function edit(Request $request, Response $response, $args = []){
		$session = Session::find($args['session_id']);
		$lessons = Lesson::all();
		if (!$session) {
			$this->flash('danger', 'This session could not be found!');
			return $this->redirect($response, 'session.index');
		}
		
		return $this->view($response,'session/edit.twig', compact('session','lessons'));
	}

	public function update(Request $request, Response $response, $args = []){

		$session = Session::find($args['session_id']);
		if (!$session) {
			$this->flash('danger', 'This session could not be updated!');
			return $this->redirect($response, 'session.index');
		}
		$session->update($request->getParams());
		$session->lessons()->sync($request->getParam('lessons'),true);

		if (!$session) {
			$this->flash('danger', 'This session could not be updated!');
			return $this->redirect($response, 'session.index');
		}

		$this->flash('success', 'Your changes were saved!');
		return $this->redirect($response,'session.edit',['session_id'=>$session->id]);		
	}

	public function delete(Request $request, Response $response, $args = []){
		$session = Session::find($args['session_id']);
		if (!$session) {
			$this->flash('danger', 'This session could not be found!');
			return $this->redirect($response, 'session.index');
		}
		$group_id = $session->group->first()->id;
		$session->delete();
		$this->flash('success', 'session successfully deleted !');
		return $this->redirect($response,'group.show',['group_id'=>$group_id]);
		
	}
}