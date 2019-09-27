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
use App\Model\Learn\LessonVideo;

class LessonVideoController extends BaseController
{
	public function index(Request $request, Response $response){

		$lessonvideos = LessonVideo::orderBy('rank','desc')->get();
		return $this->view($response,'Lessonvideo/index.twig',compact('lessonvideos'));
	}

	public function create(Request $request, Response $response, $args = []){
		$lesson = Lesson::find($args['lesson_id']);

		if (!$lesson) {
			$this->flash('danger', 'This lesson could not be found!');
			return $this->redirect($response, 'lesson.index');
		}

		return $this->view($response,'lessonvideo/create.twig', compact('lesson'));
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
		$uploadedFile->getFiles($request,'video');
		if (!$uploadedFile->hasError()) {

			if ($uploadedFile->getFileSize() > 0) {
				$uploadedFile->moveToDir(config('path.video.lesson.file'));
				$data['file_name'] = $uploadedFile->getFileName();
				$data['type'] = $uploadedFile->getMediaType();
			}
		}

		$lessonvideo = $lesson->lessonvideos()->create($data);

		if (!$lessonvideo) {
				$this->flash('danger', 'The video was not saved, please try again!');
			}	
		return $this->redirect($response, 'lesson.show',['lesson_id'=>$lesson->id]);
	}

		public function show(Request $request, Response $response, $args = []){
			$lessonvideo = LessonVideo::find($args['lessonvideo_id']);

			if (!$lessonvideo) {
				$this->flash('danger', 'This lesson video could not be found!');
				return $this->redirect($response, 'lesson.index');
			}
			return $this->view($response,'lessonvideo/show.twig', compact('lessonvideo'));
		}

	public function edit(Request $request, Response $response, $args = []){
		$lessonvideo = LessonVideo::find($args['lessonvideo_id']);

		if (!$lessonvideo) {
			$this->flash('danger', 'This lessonvideo could not be found!');
			return $this->redirect($response, 'lesson.index');
		}
		
		return $this->view($response,'lessonvideo/edit.twig', compact('lessonvideo'));
	}

	public function update(Request $request, Response $response, $args = []){

		$lessonvideo = LessonVideo::find($args['lessonvideo_id']);
		if (!$lessonvideo) {
			$this->flash('danger', 'This video could not be updated!');
			return $this->redirect($response, 'lesson.index');
		}

		$data = $request->getParams();
		$uploadedFile = new UploadedFiles();
		$uploadedFile->getFiles($request,'video');
		if (!$uploadedFile->hasError()) {

			if ($uploadedFile->getFileSize() > 0) {
				$uploadedFile->moveToDir(config('path.video.lesson.file'));
				$data['file_name'] = $uploadedFile->getFileName();
				$data['type'] = $uploadedFile->getMediaType();
			}
		}

		$lessonvideo->update($data);
		// $lessonvideo->users()->sync($request->getParam('users'),true);

		if (!$lessonvideo) {
			$this->flash('danger', 'This video could not be updated!');
			return $this->redirect($response, 'lesson.index');
		}

		$this->flash('success', 'Your changes were saved!');
		return $this->redirect($response,'lessonvideo.edit',['lessonvideo_id'=>$lessonvideo->id]);		
	}

	public function delete(Request $request, Response $response, $args = []){
		$lessonvideo = LessonVideo::find($args['lessonvideo_id']);
		if (!$lessonvideo) {
			$this->flash('danger', 'This lessonvideo could not be found!');
			return $this->redirect($response, 'lesson.index');
		}

		$lessonvideo->delete();
		$this->flash('success', 'lessonvideo successfully deleted !');
		return $this->redirect($response,'lesson.show',['lesson_id'=>$lesson_id]);
		
	}
}