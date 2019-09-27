<?php
namespace App\Controller\Group;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

use Core\Controller\BaseController;

use App\Model\Group\Group;
use App\Model\User\User;
use Core\Model\Auth;
use Core\Model\Hash;

class GroupController extends BaseController
{
	public function index(Request $request, Response $response){

		$groups = Group::orderBy('created_at','desc')->get();
		return $this->view($response,'group/index.twig',compact('groups'));
	}

	public function show(Request $request, Response $response, $args = []){
		$group = Group::find($args['group_id']);
		$users = $group->users;

		if (!$group) {
			$this->flash('danger', 'This group could not be found!');
			return $this->redirect($response, 'group.index');
		}
		return $this->view($response,'group/show.twig', compact('group','users'));
	}

	public function create(Request $request, Response $response){
		$users = User::orderBy('first_name','asc')->get();
		return $this->view($response,'group/create.twig', compact('users'));
	}

	public function store(Request $request, Response $response){

		$data = $request->getParams();
		$data['group_id'] = strtoupper(Hash::render(6));
		$group = Group::create($data);

		if (!$group) {
				$this->flash('danger', 'The group was not saved, please try again!');
				return $this->redirect($response, 'group.index');
			}

		$group->users()->sync($data['users'],true);

		$this->flash('success', 'Group was successfully created!');
		return $this->redirect($response, 'group.show',['group_id'=>$group->id]);
	}

	public function edit(Request $request, Response $response, $args = []){
		$group = Group::find($args['group_id']);
		$users = $users = User::all();

		if (!$group) {
			$this->flash('danger', 'This group could not be found!');
			return $this->redirect($response, 'group.index');
		}
		
		return $this->view($response,'group/edit.twig', compact('group','users'));
	}

	public function update(Request $request, Response $response, $args = []){

		$group = Group::find($args['group_id']);
		if (!$group) {
			$this->flash('danger', 'This group could not be updated!');
			return $this->redirect($response, 'group.index');
		}
		$group->update($request->getParams());
		$group->users()->sync($request->getParam('users'),true);

		if (!$group) {
			$this->flash('danger', 'This group could not be updated!');
			return $this->redirect($response, 'group.index');
		}

		$this->flash('success', 'Your changes were saved!');
		return $this->redirect($response,'group.edit',['group_id'=>$group->id]);		
	}

	public function delete(Request $request, Response $response, $args = []){
		$group = Group::find($args['group_id']);
		if (!$group) {
			$this->flash('danger', 'This group could not be found!');
			return $this->redirect($response, 'group.index');
		}
		$group->delete();
		$this->flash('success', 'group successfully deleted !');
		return $this->redirect($response,'group.index');
		
	}
}