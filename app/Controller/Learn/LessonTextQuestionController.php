<?php
namespace App\Controller\Learn;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

use Core\Controller\BaseController;
use Core\Model\UploadedFiles;
use App\Model\Group\Group;
use App\Model\User\User;
use Core\Model\Auth;
use App\Model\Learn\Lesson;
use App\Model\Learn\LessonText;
use App\Model\Learn\LessonTextQuestion;

class LessonTextQuestionController extends BaseController
{

	public function create(Request $request, Response $response, $args = []){
		$lessontext = LessonText::find($args['lessontext_id']);

		if (!$lessontext) {
			$this->flash('danger', 'This lesson text could not be found!');
			return $this->redirect($response, 'lesson.index');
		}

		return $this->view($response,'lessontextquestion/create.twig', compact('lessontext'));
	}

	public function store(Request $request, Response $response){	
		// kill($request->getParams());
		$lessontext = LessonText::find($request->getParam('lessontext_id'));
		
		// kill($lessontext);
		if (!$lessontext) {
			$this->flash('danger', 'The lesson text could not be found!');
			return $this->redirect($response, 'lesson.index');
		}

		$data = $request->getParams();
		$lessontextquestion = $lessontext->lessontextquestions()->create($data);

		if (!$lessontext) {
				$this->flash('danger', 'The question was not saved, please try again!');
				return $this->redirect($response, 'lessontext.show',['lessontext_id'=>$lessontext->id]);
		}	

		$this->flash('success', 'This text question was succesfully created');
		return $this->redirect($response, 'lessontext.show',['lessontext_id'=>$lessontext->id]);
	}

	public function show(Request $request, Response $response, $args = []){

		$lessontextquestion = LessonTextQuestion::find($args['lessontextquestion_id']);

		if (!$lessontextquestion) {
			$this->flash('danger', 'This lesson question could not be found!');
			return $this->redirect($response, 'lesson.index');
		}
		return $this->view($response,'lessontextquestion/show.twig', compact('lessontextquestion'));
	}

	public function edit(Request $request, Response $response, $args = []){
		$lessontextquestion = LessonTextQuestion::find($args['lessontextquestion_id']);

		if (!$lessontextquestion) {
			$this->flash('danger', 'This lessontextquestion could not be found!');
			return $this->redirect($response, 'lesson.index');
		}
		
		return $this->view($response,'lessontextquestion/edit.twig', compact('lessontextquestion'));
	}

	public function update(Request $request, Response $response, $args = []){

		$lessontextquestion = LessonTextQuestion::find($args['lessontextquestion_id']);
		if (!$lessontextquestion) {
			$this->flash('danger', 'This question could not be updated!');
			return $this->redirect($response, 'lesson.index');
		}

		$data = $request->getParams();
		$lessontextquestion->update($data);

		if (!$lessontextquestion) {
			$this->flash('danger', 'This question could not be updated!');
			return $this->redirect($response, 'lesson.index');
		}

		$this->flash('success', 'Your changes were saved!');
		return $this->redirect($response,'lessontextquestion.edit',['lessontextquestion_id'=>$lessontextquestion->id]);		
	}

	public function delete(Request $request, Response $response, $args = []){

		$lessontext = LessonText::find($args['lessontext_id']);
		if (!$lessontext) {
			$this->flash('danger', 'This lessontext could not be found!');
			return $this->redirect($response, 'lesson.index');
		}
		$lesson_id = $lessontext->lesson_id;
		$lessontext->delete();
		$this->flash('success', 'lessontext successfully deleted !');
		return $this->redirect($response,'lesson.show',['lesson_id'=>$lesson_id]);
		
	}
}