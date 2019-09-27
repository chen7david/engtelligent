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


class TvShowController extends BaseController
{
	public function index(Request $request, Response $response){

		$tvshows = TvShow::orderBy('created_at','desc')->get();
		return $this->view($response,'tvshow/index.twig',compact('tvshows'));
	}

	public function show(Request $request, Response $response, $args = []){
		$tvshow = TvShow::find($args['tvshow_id']);

		if (!$tvshow) {
			$this->flash('danger', 'This tvshow could not be found!');
			return $this->redirect($response, 'tvshow.index');
		}
		return $this->view($response,'tvshow/show.twig', compact('tvshow'));
	}

	public function create(Request $request, Response $response){
		
		return $this->view($response,'tvshow/create.twig',compact('tvshows'));
	}

	public function store(Request $request, Response $response){

		$data = $request->getParams();
		$uploadedFile = new UploadedFiles();
		$uploadedFile->getFiles($request,'image');
		if (!$uploadedFile->hasError()) {

			if ($uploadedFile->getFileSize() > 0) {
				$uploadedFile->moveToDir(config('path.tvshow.image'));
				$data['image'] = $uploadedFile->getFileName();
			}
		}
			
		$tvshow = TvShow::create($data);

		if (!$tvshow) {
				$this->flash('danger', 'The tvshow was not saved, please try again!');
				return $this->redirect($response, 'tvshow.index');
			}	
			
		$this->flash('success', 'A new tvshow was created.');
		return $this->redirect($response, 'tvshow.index');
	}

	public function edit(Request $request, Response $response, $args = []){
		$tvshow = TvShow::find($args['tvshow_id']);

		if (!$tvshow) {
			$this->flash('danger', 'This tvshow could not be found!');
			return $this->redirect($response, 'tvshow.index');
		}
		
		return $this->view($response,'tvshow/edit.twig', compact('tvshow','users'));
	}

	public function update(Request $request, Response $response, $args = []){

		$tvshow = TvShow::find($args['tvshow_id']);
		if (!$tvshow) {
			$this->flash('danger', 'This tvshow could not be updated!');
			return $this->redirect($response, 'tvshow.index');
		}

		$data = $request->getParams();
		$uploadedFile = new UploadedFiles();
		$uploadedFile->getFiles($request,'image');
		if (!$uploadedFile->hasError()) {

			if ($uploadedFile->getFileSize() > 0) {
				$uploadedFile->moveToDir(config('path.tvshow.image'));
				$data['image'] = $uploadedFile->getFileName();
			}
		}
		
		$tvshow->update($data);
		// $tvshow->users()->sync($request->getParam('users'),true);

		if (!$tvshow) {
			$this->flash('danger', 'This tvshow could not be updated!');
			return $this->redirect($response, 'tvshow.index');
		}

		$this->flash('success', 'Your changes were saved!');
		return $this->redirect($response,'tvshow.edit',['tvshow_id'=>$tvshow->id]);		
	}

	public function delete(Request $request, Response $response, $args = []){
		$tvshow = TvShow::find($args['tvshow_id']);
		if (!$tvshow) {
			$this->flash('danger', 'This tvshow could not be found!');
			return $this->redirect($response, 'tvshow.index');
		}
		$tvshow->delete();
		$this->flash('success', 'tvshow successfully deleted !');
		return $this->redirect($response,'tvshow.index');
		
	}

// User accessable interface

	public function collection(Request $request, Response $response){
		$tvshows = TvShow::orderBy('name','desc')->get();
		return $this->view($response,'tvshow/collection.twig',compact('tvshows'));
	}

	public function info(Request $request, Response $response, $args = []){
		$tvshow = TvShow::find($args['tvshow_id']);
		$thisseason = $tvshow->seasons()->where('rank', $args['season_rank'])->first();

		if (!$tvshow && !$thisseason) {
			$this->flash('danger','we could not find this tv show');
			return $this->redirect($response,'tvshow.collection');
		}
		return $this->view($response,'tvshow/info.twig',compact('tvshow','thisseason'));
	}

	public function watch(Request $request, Response $response, $args = []){
		$episode = Episode::find($args['episode_id']);

		if (!$episode) {
			$this->flash('danger','we could not find this episode');
			return $this->redirect($response,'tvshow.collection');
		}
		return $this->view($response,'tvshow/watch.twig',compact('episode'));
	}
}