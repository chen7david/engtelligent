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
use App\Model\Learn\LessonAudio;

class LessonAudioController extends BaseController
{
	public function index(Request $request, Response $response){

		$lessonaudios = LessonAudio::all();
		return $this->view($response,'Lessonaudio/index.twig',compact('lessonaudios'));
	}

	public function create(Request $request, Response $response, $args = []){

		$lesson = Lesson::find($args['lesson_id']);

		if (!$lesson) {
			$this->flash('danger', 'This lesson could not be found!');
			return $this->redirect($response, 'lesson.index');
		}

		return $this->view($response,'lessonaudio/create.twig', compact('lesson'));
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
		$uploadedFile->getFiles($request,'audio');
		if (!$uploadedFile->hasError()) {

			if ($uploadedFile->getFileSize() > 0) {
				$uploadedFile->moveToDir(config('path.audio.lesson.file'));
				$data['file_name'] = $uploadedFile->getFileName();
				$data['type'] = $uploadedFile->getMediaType();
			}
		}

		$uploadedFile->getFiles($request,'image');
		if (!$uploadedFile->hasError()) {

			if ($uploadedFile->getFileSize() > 0) {
				$uploadedFile->moveToDir(config('path.audio.lesson.image'));
				$data['image'] = $uploadedFile->getFileName();
				// $data['type'] = $uploadedFile->getMediaType();
			}
		}

		$lessonaudio = $lesson->lessonaudios()->create($data);

		if (!$lessonaudio) {
				$this->flash('danger', 'The audio was not saved, please try again!');
				return $this->redirect($response, 'lesson.show',['lesson_id'=>$lesson->id]);
		}	

		

		$this->flash('success', 'Your audio file was created!');
		return $this->redirect($response, 'lesson.show',['lesson_id'=>$lesson->id]);
	}

	public function show(Request $request, Response $response, $args = []){
		$lessonaudio = LessonAudio::find($args['lessonaudio_id']);

		if (!$lessonaudio) {
			$this->flash('danger', 'This lesson audio could not be found!');
			return $this->redirect($response, 'lessonaudio.index');
		}
		return $this->view($response,'lessonaudio/show.twig', compact('lessonaudio'));
	}

	public function edit(Request $request, Response $response, $args = []){
		$lessonaudio = LessonAudio::find($args['lessonaudio_id']);

		if (!$lessonaudio) {
			$this->flash('danger', 'This lessonaudio could not be found!');
			return $this->redirect($response, 'lesson.index');
		}
		
		return $this->view($response,'lessonaudio/edit.twig', compact('lessonaudio'));
	}

	public function update(Request $request, Response $response, $args = []){

		$lessonaudio = LessonAudio::find($args['lessonaudio_id']);
		if (!$lessonaudio) {
			$this->flash('danger', 'This audio could not be updated!');
			return $this->redirect($response, 'lesson.index');
		}

		$data = $request->getParams();
		$uploadedFile = new UploadedFiles();
		$uploadedFile->getFiles($request,'audio');

		if (!$uploadedFile->hasError()) {

			if ($uploadedFile->getFileSize() > 0) {

				$uploadedFile->moveToDir(config('path.audio.lesson.file'));

				$data['file_name'] = $uploadedFile->getFileName();
				$data['type'] = $uploadedFile->getMediaType();
			}
		}

		$uploadedFile->getFiles($request,'image');
		if (!$uploadedFile->hasError()) {

			if ($uploadedFile->getFileSize() > 0) {
				$uploadedFile->moveToDir(config('path.audio.lesson.image'));
				$data['image'] = $uploadedFile->getFileName();
				// $data['type'] = $uploadedFile->getMediaType();
			}
		}
		
		$lessonaudio->update($data);
		// $lessonaudio->users()->sync($request->getParam('users'),true);

		if (!$lessonaudio) {
			$this->flash('danger', 'This audio could not be updated!');
			return $this->redirect($response, 'lesson.index');
		}

		$this->flash('success', 'Your changes were saved!');
		return $this->redirect($response,'lessonaudio.edit',['lessonaudio_id'=>$lessonaudio->id]);		
	}

	public function delete(Request $request, Response $response, $args = []){
		$lessonaudio = LessonAudio::find($args['lessonaudio_id']);
		if (!$lessonaudio) {
			$this->flash('danger', 'This lessonaudio could not be found!');
			return $this->redirect($response, 'lessonaudio.index');
		}
		$lessonaudio->delete();
		$this->flash('success', 'lessonaudio successfully deleted !');
		return $this->redirect($response,'lessonaudio.index');
		
	}
}