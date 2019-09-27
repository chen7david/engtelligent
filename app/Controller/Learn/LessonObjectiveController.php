<?php
namespace App\Controller\Learn;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

use Core\Controller\BaseController;
use Core\Model\UploadedFiles;
use App\Model\Learn\Lesson;
use App\Model\Learn\LessonObjective;

class LessonObjectiveController extends BaseController
{

	public function create(Request $request, Response $response, $args = []){
		$lesson = Lesson::find($args['lesson_id']);

		if (!$lesson) {
			$this->flash('danger', 'This lesson question could not be found!');
			return $this->redirect($response, 'lesson.index');
		}

		return $this->view($response,'lessonobjective/create.twig', compact('lesson'));
	}

	public function store(Request $request, Response $response){	
		// kill($request->getParams());
		$lesson = Lesson::find($request->getParam('lesson_id'));
		
		
		if (!$lesson) {
			$this->flash('danger', 'The lesson text could not be found!');
			return $this->redirect($response, 'lesson.index');
		}

		$lessonobjective = $lesson->lessonobjectives()->create($request->getParams());

		if (!$lessonobjective) {
				$this->flash('danger', 'The question was not saved, please try again!');
				return $this->redirect($response, 'lesson.show',['lesson_id'=>$lesson->id]);
		}	

		$this->flash('success', 'This lesson question was succesfully created');
		return $this->redirect($response, 'lesson.show',['lesson_id'=>$lesson->id]);
	}

	public function show(Request $request, Response $response, $args = []){

		$lessonobjective = LessonObjective::find($args['lessonobjective_id']);

		if (!$lessonobjective) {
			$this->flash('danger', 'This lesson question could not be found!');
			return $this->redirect($response, 'lesson.index');
		}
		return $this->view($response,'lessonobjective/show.twig', compact('lessonobjective'));
	}

	public function edit(Request $request, Response $response, $args = []){
		$lessonobjective = LessonObjective::find($args['lessonobjective_id']);

		if (!$lessonobjective) {
			$this->flash('danger', 'This lessonobjective could not be found!');
			return $this->redirect($response, 'lesson.index');
		}
		
		return $this->view($response,'lessonobjective/edit.twig', compact('lessonobjective'));
	}

	public function update(Request $request, Response $response, $args = []){

		$lessonobjective = LessonObjective::find($args['lessonobjective_id']);
		if (!$lessonobjective) {
			$this->flash('danger', 'This objective could not be updated!');
			return $this->redirect($response, 'lesson.index');
		}

		$lessonobjective->update($request->getParams());

		if (!$lessonobjective) {
			$this->flash('danger', 'This question could not be updated!');
			return $this->redirect($response, 'lesson.index');
		}

		$this->flash('success', 'Your changes were saved!');
		return $this->redirect($response,'lessonobjective.edit',['lessonobjective_id'=>$lessonobjective->id]);		
	}

	public function delete(Request $request, Response $response, $args = []){

		$lessonobjective = LessonObjective::find($args['lessonobjective_id']);
		if (!$lessonobjective) {
			kill(1);
			$this->flash('danger', 'This Lesson objective could not be found!');
			return $this->redirect($response, 'lesson.index');
		}

		$lesson_id = $lessonobjective->lesson_id;

		$lessonobjective->delete();
		$this->flash('success', 'lesson objective successfully deleted !');
		return $this->redirect($response,'lesson.show',['lesson_id'=>$lesson_id]);
		
	}
}