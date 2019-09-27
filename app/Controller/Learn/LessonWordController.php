<?php
namespace App\Controller\Learn;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

use Core\Controller\BaseController;
use Core\Model\UploadedFiles;
use App\Model\Learn\Lesson;
use App\Model\Learn\LessonWord;

class LessonWordController extends BaseController
{

	public function create(Request $request, Response $response, $args = []){
		$lesson = Lesson::find($args['lesson_id']);

		if (!$lesson) {
			$this->flash('danger', 'This lesson question could not be found!');
			return $this->redirect($response, 'lesson.index');
		}

		return $this->view($response,'lessonword/create.twig', compact('lesson'));
	}

	public function store(Request $request, Response $response){	

		$lesson = Lesson::find($request->getParam('lesson_id'));
		
		
		if (!$lesson) {
			$this->flash('danger', 'The lesson text could not be found!');
			return $this->redirect($response, 'lesson.index');
		}

		$lessonword = $lesson->lessonwords()->create($request->getParams());

		if (!$lessonword) {
				$this->flash('danger', 'The question was not saved, please try again!');
				return $this->redirect($response, 'lesson.show',['lesson_id'=>$lesson->id]);
		}	

		$this->flash('success', 'This lesson word was succesfully created');
		return $this->redirect($response, 'lesson.show',['lesson_id'=>$lesson->id]);
	}

	public function show(Request $request, Response $response, $args = []){

		$lessonword = lessonword::find($args['lessonword_id']);

		if (!$lessonword) {
			$this->flash('danger', 'This lesson question could not be found!');
			return $this->redirect($response, 'lesson.index');
		}
		return $this->view($response,'lessonword/show.twig', compact('lessonword'));
	}

	public function edit(Request $request, Response $response, $args = []){
		$lessonword = lessonword::find($args['lessonword_id']);

		if (!$lessonword) {
			$this->flash('danger', 'This lessonword could not be found!');
			return $this->redirect($response, 'lesson.index');
		}
		
		return $this->view($response,'lessonword/edit.twig', compact('lessonword'));
	}

	public function update(Request $request, Response $response, $args = []){

		$lessonword = lessonword::find($args['lessonword_id']);
		if (!$lessonword) {
			$this->flash('danger', 'This objective could not be updated!');
			return $this->redirect($response, 'lesson.index');
		}
		
		$lessonword->update($request->getParams());

		if (!$lessonword) {
			$this->flash('danger', 'This question could not be updated!');
			return $this->redirect($response, 'lesson.index');
		}

		$this->flash('success', 'Your changes were saved!');
		return $this->redirect($response,'lessonword.edit',['lessonword_id'=>$lessonword->id]);		
	}

	public function delete(Request $request, Response $response, $args = []){

		$lessonword = LessonWord::find($args['lessonword_id']);
		if (!$lessonword) {
			$this->flash('danger', 'This lesson could not be found!');
			return $this->redirect($response, 'lesson.index');
		}
		$lesson_id = $lessonword->lesson_id;
		$lessonword->delete();
		$this->flash('success', 'lesson word was successfully deleted !');
		return $this->redirect($response,'lesson.show',['lesson_id'=>$lesson_id]);
		
	}
}