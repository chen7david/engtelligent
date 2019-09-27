<?php
namespace App\Controller\Media;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

use Core\Controller\BaseController;
use Core\Model\UploadedFiles;
use App\Model\Group\Group;
use App\Model\Media\Episode;
use App\Model\Media\Season;
use App\Model\Media\TvShow;


class episodeController extends BaseController
{
	public function index(Request $request, Response $response){

		$episodes = Episode::orderBy('created_at','desc')->get();
		return $this->view($response,'episode/index.twig',compact('episodes'));
	}

	public function show(Request $request, Response $response, $args = []){


		$episode = Episode::find($args['episode_id']);

		if (!$episode) {
			$this->flash('danger', 'This episode could not be found!');
			return $this->redirect($response, 'tvshow.index');
		}
		return $this->view($response,'episode/show.twig', compact('episode'));
	}

	public function create(Request $request, Response $response, $args = []){
		$season = Season::find($args['season_id']);
		return $this->view($response,'episode/create.twig',compact('season'));
	}

	public function store(Request $request, Response $response){

		$season = Season::find($request->getParam('season_id'));

		if (!$season) {
			$this->flash('danger', 'This season could not be found!');
			return $this->redirect($response, 'tvshow.index');
		}

		$data = $request->getParams();
		$uploadedFile = new UploadedFiles();
		$uploadedFile->getFiles($request,'video_file');
		if (!$uploadedFile->hasError()) {

			if ($uploadedFile->getFileSize() > 0) {
				$uploadedFile->moveToDir(config('path.tvshow.video'));
				$data['video_file'] = $uploadedFile->getFileName();
			}
		}
			
		$episode = Episode::create($data);

		if (!$episode) {
				$this->flash('danger', 'The episode was not saved, please try again!');
				return $this->redirect($response, 'tvshow.index');
			}	
			
		$this->flash('success', 'A new episode was created, the file name is: '.$episode->video_file);
		return $this->redirect($response, 'episode.create',['season_id'=>$season->id]);
	}

	public function edit(Request $request, Response $response, $args = []){
		$episode = Episode::find($args['episode_id']);

		if (!$episode) {
			$this->flash('danger', 'This episode could not be found!');
			return $this->redirect($response, 'episode.index');
		}
		
		return $this->view($response,'episode/edit.twig', compact('episode'));
	}

	public function update(Request $request, Response $response, $args = []){

		$episode = Episode::find($args['episode_id']);
		if (!$episode) {
			$this->flash('danger', 'This episode could not be updated!');
			return $this->redirect($response, 'episode.index');
		}

		$data = $request->getParams();
		$uploadedFile = new UploadedFiles();
		$uploadedFile->getFiles($request,'video_file');
		if (!$uploadedFile->hasError()) {

			if ($uploadedFile->getFileSize() > 0) {
				$uploadedFile->moveToDir(config('path.tvshow.video'));
				$data['video_file'] = $uploadedFile->getFileName();
			}
		}
		
		$episode->update($data);
		// $episode->users()->sync($request->getParam('users'),true);

		if (!$episode) {
			$this->flash('danger', 'This episode could not be updated!');
			return $this->redirect($response, 'episode.index');
		}

		$this->flash('success', 'Your changes were saved!');
		return $this->redirect($response,'episode.edit',['episode_id'=>$episode->id]);		
	}

	public function delete(Request $request, Response $response, $args = []){
		$episode = Episode::find($args['episode_id']);
		if (!$episode) {
			$this->flash('danger', 'This episode could not be found!');
			return $this->redirect($response, 'episode.index');
		}
		$episode->delete();
		$this->flash('success', 'episode successfully deleted !');
		return $this->redirect($response,'episode.index');
		
	}
}