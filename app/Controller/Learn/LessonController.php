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

class LessonController extends BaseController
{
	public function index(Request $request, Response $response){

		$lessons = Lesson::orderBy('created_at','desc')->get();
		return $this->view($response,'lesson/index.twig',compact('lessons'));
	}

	public function show(Request $request, Response $response, $args = []){
		$lesson = Lesson::find($args['lesson_id']);

		if (!$lesson) {
			$this->flash('danger', 'This lesson could not be found!');
			return $this->redirect($response, 'lesson.index');
		}
		return $this->view($response,'lesson/show.twig', compact('lesson'));
	}

	public function create(Request $request, Response $response){
		
		return $this->view($response,'lesson/create.twig',compact('lessons'));
	}

	public function store(Request $request, Response $response){

		$data = $request->getParams();
		$uploadedFile = new UploadedFiles();
		$uploadedFile->getFiles($request,'image');
		if (!$uploadedFile->hasError()) {

			if ($uploadedFile->getFileSize() > 0) {
				$uploadedFile->moveToDir(config('path.image.lesson'));
				$data['file_name'] = $uploadedFile->getFileName();
			}
		}
			
		$lesson = Lesson::create($data);

		if (!$lesson) {
				$this->flash('danger', 'The lesson was not saved, please try again!');
				return $this->redirect($response, 'lesson.index');
			}	
			
		$this->flash('success', 'A new lesson was created.');
		return $this->redirect($response, 'lesson.index');
	}

	public function edit(Request $request, Response $response, $args = []){
		$lesson = Lesson::find($args['lesson_id']);
		$users = $users = User::all();

		if (!$lesson) {
			$this->flash('danger', 'This lesson could not be found!');
			return $this->redirect($response, 'lesson.index');
		}
		
		return $this->view($response,'lesson/edit.twig', compact('lesson','users'));
	}

	public function update(Request $request, Response $response, $args = []){

		$lesson = Lesson::find($args['lesson_id']);
		if (!$lesson) {
			$this->flash('danger', 'This lesson could not be updated!');
			return $this->redirect($response, 'lesson.index');
		}

		$data = $request->getParams();
		$uploadedFile = new UploadedFiles();
		$uploadedFile->getFiles($request,'image');
		if (!$uploadedFile->hasError()) {

			if ($uploadedFile->getFileSize() > 0) {
				$uploadedFile->moveToDir(config('path.image.lesson'));
				$data['file_name'] = $uploadedFile->getFileName();
			}
		}
		
		$lesson->update($data);
		// $lesson->users()->sync($request->getParam('users'),true);

		if (!$lesson) {
			$this->flash('danger', 'This lesson could not be updated!');
			return $this->redirect($response, 'lesson.index');
		}

		$this->flash('success', 'Your changes were saved!');
		return $this->redirect($response,'lesson.edit',['lesson_id'=>$lesson->id]);		
	}

	public function delete(Request $request, Response $response, $args = []){
		$lesson = Lesson::find($args['lesson_id']);
		if (!$lesson) {
			$this->flash('danger', 'This lesson could not be found!');
			return $this->redirect($response, 'lesson.index');
		}
		$lesson->delete();
		$this->flash('success', 'lesson successfully deleted !');
		return $this->redirect($response,'lesson.index');
		
	}
}