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

class LessonTextController extends BaseController
{
	public function index(Request $request, Response $response){

		$lessontexts = LessonText::orderBy('rank','desc')->get();
		return $this->view($response,'lessontext/create.twig',compact('lessontexts'));
	}

	public function create(Request $request, Response $response, $args = []){
		$lesson = Lesson::find($args['lesson_id']);

		if (!$lesson) {
			$this->flash('danger', 'This lesson could not be found!');
			return $this->redirect($response, 'lesson.index');
		}

		return $this->view($response,'lessontext/create.twig', compact('lesson'));
	}

	public function store(Request $request, Response $response){	
		// kill($request->getParams());
		$lesson = Lesson::find($request->getParam('lesson_id'));
		
		// kill($lesson);
		if (!$lesson) {
			$this->flash('danger', 'The lesson could not be found!');
			return $this->redirect($response, 'lesson.index');
		}

		$data = $request->getParams();
		$uploadedFile = new UploadedFiles();
		$uploadedFile->getFiles($request,'image');

		if (!$uploadedFile->hasError()) {

			if ($uploadedFile->getFileSize() > 0) {
				$uploadedFile->moveToDir(config('path.lesson.text.image'));
				$data['image'] = $uploadedFile->getFileName();
				// $data['type'] = $uploadedFile->getMediaType();
			}
		}

		$uploadedFile->getFiles($request,'audio');
		if (!$uploadedFile->hasError()) {

			if ($uploadedFile->getFileSize() > 0) {
				$uploadedFile->moveToDir(config('path.lesson.text.audio'));
				$data['audio'] = $uploadedFile->getFileName();
				// $data['type'] = $uploadedFile->getMediaType();
			}
		}

		$lessontext = $lesson->lessontexts()->create($data);

		if (!$lessontext) {
				$this->flash('danger', 'The video was not saved, please try again!');
				return $this->redirect($response, 'lesson.show',['lesson_id'=>$lesson->id]);
		}	

		$this->flash('success', 'This text was succesfully created');
		return $this->redirect($response, 'lesson.show',['lesson_id'=>$lesson->id]);
	}

		public function show(Request $request, Response $response, $args = []){
			// kill();
			$lessontext = LessonText::find($args['lessontext_id']);

			if (!$lessontext) {
				$this->flash('danger', 'This lesson video could not be found!');
				return $this->redirect($response, 'lesson.index');
			}
			return $this->view($response,'lessontext/show.twig', compact('lessontext'));
		}

	public function edit(Request $request, Response $response, $args = []){
		$lessontext = LessonText::find($args['lessontext_id']);

		if (!$lessontext) {
			$this->flash('danger', 'This lessontext could not be found!');
			return $this->redirect($response, 'lesson.index');
		}
		
		return $this->view($response,'lessontext/edit.twig', compact('lessontext'));
	}

	public function update(Request $request, Response $response, $args = []){

		$lessontext = LessonText::find($args['lessontext_id']);
		if (!$lessontext) {
			$this->flash('danger', 'This video could not be updated!');
			return $this->redirect($response, 'lesson.index');
		}

		$data = $request->getParams();
		$uploadedFile = new UploadedFiles();
		$uploadedFile->getFiles($request,'image');

		if (!$uploadedFile->hasError()) {

			if ($uploadedFile->getFileSize() > 0) {
				$uploadedFile->moveToDir(config('path.lesson.text.image'));
				$data['image'] = $uploadedFile->getFileName();
				// $data['type'] = $uploadedFile->getMediaType();
			}
		}

		$uploadedFile->getFiles($request,'audio');
		if (!$uploadedFile->hasError()) {

			if ($uploadedFile->getFileSize() > 0) {
				$uploadedFile->moveToDir(config('path.lesson.text.audio'));
				$data['audio'] = $uploadedFile->getFileName();
				// $data['type'] = $uploadedFile->getMediaType();
			}
		}
		
		$lessontext->update($data);

		// $lessontext->users()->sync($request->getParam('users'),true);

		if (!$lessontext) {
			$this->flash('danger', 'This video could not be updated!');
			return $this->redirect($response, 'lesson.index');
		}

		$this->flash('success', 'Your changes were saved!');
		return $this->redirect($response,'lessontext.edit',['lessontext_id'=>$lessontext->id]);		
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