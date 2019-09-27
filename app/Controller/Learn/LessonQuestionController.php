<?php
namespace App\Controller\Learn;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

use Core\Controller\BaseController;
use Core\Model\UploadedFiles;
use App\Model\Learn\Lesson;
use App\Model\Learn\LessonQuestion;


class LessonQuestionController extends BaseController
{

	public function create(Request $request, Response $response, $args = []){
		$lesson = Lesson::find($args['lesson_id']);

		if (!$lesson) {
			$this->flash('danger', 'This lesson question could not be found!');
			return $this->redirect($response, 'lesson.index');
		}

		return $this->view($response,'lessonquestion/create.twig', compact('lesson'));
	}

	public function store(Request $request, Response $response){	
		// kill($request->getParams());
		$lesson = Lesson::find($request->getParam('lesson_id'));
		
		
		if (!$lesson) {
			$this->flash('danger', 'The lesson text could not be found!');
			return $this->redirect($response, 'lesson.index');
		}

		$lessonquestion = $lesson->lessonquestions()->create($request->getParams());

		if (!$lessonquestion) {
				$this->flash('danger', 'The question was not saved, please try again!');
				return $this->redirect($response, 'lesson.show',['lesson_id'=>$lesson->id]);
		}	

		$this->flash('success', 'This lesson question was succesfully created');
		return $this->redirect($response, 'lesson.show',['lesson_id'=>$lesson->id]);
	}

	public function show(Request $request, Response $response, $args = []){

		$lessonquestion = LessonQuestion::find($args['lessonquestion_id']);

		if (!$lessonquestion) {
			$this->flash('danger', 'This lesson question could not be found!');
			return $this->redirect($response, 'lesson.index');
		}
		return $this->view($response,'lessonquestion/show.twig', compact('lessonquestion'));
	}

	public function edit(Request $request, Response $response, $args = []){
		$lessonquestion = LessonQuestion::find($args['lessonquestion_id']);

		if (!$lessonquestion) {
			$this->flash('danger', 'This lessonquestion could not be found!');
			return $this->redirect($response, 'lesson.index');
		}
		
		return $this->view($response,'lessonquestion/edit.twig', compact('lessonquestion'));
	}

	public function update(Request $request, Response $response, $args = []){

		$lessonquestion = LessonQuestion::find($args['lessonquestion_id']);
		if (!$lessonquestion) {
			$this->flash('danger', 'This question could not be updated!');
			return $this->redirect($response, 'lesson.index');
		}

		$lessonquestion->update($request->getParams());

		if (!$lessonquestion) {
			$this->flash('danger', 'This question could not be updated!');
			return $this->redirect($response, 'lesson.index');
		}

		$this->flash('success', 'Your changes were saved!');
		return $this->redirect($response,'lessonquestion.edit',['lessonquestion_id'=>$lessonquestion->id]);		
	}

	public function delete(Request $request, Response $response, $args = []){

		$lesson = Lesson::find($args['lesson_id']);
		if (!$lesson) {
			$this->flash('danger', 'This lesson could not be found!');
			return $this->redirect($response, 'lesson.index');
		}
		$lesson_id = $lesson->lesson_id;
		$lesson->delete();
		$this->flash('success', 'lesson successfully deleted !');
		return $this->redirect($response,'lesson.show',['lesson_id'=>$lesson_id]);
		
	}
}