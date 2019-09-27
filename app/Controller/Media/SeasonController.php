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


class SeasonController extends BaseController
{
	public function index(Request $request, Response $response){

		$seasons = Season::orderBy('created_at','desc')->get();
		return $this->view($response,'season/index.twig',compact('seasons'));
	}

	public function show(Request $request, Response $response, $args = []){
		$season = Season::find($args['season_id']);

		if (!$season) {
			$this->flash('danger', 'This season could not be found!');
			return $this->redirect($response, 'season.index');
		}
		return $this->view($response,'season/show.twig', compact('season'));
	}

	public function create(Request $request, Response $response, $args = []){
		$tvshow = TvShow::find($args['tvshow_id']);
		return $this->view($response,'season/create.twig',compact('tvshow'));
	}

	public function store(Request $request, Response $response){
			// kill($request->getParams());
		$season = Season::create($request->getParams());

		if (!$season) {
				$this->flash('danger', 'The season was not saved, please try again!');
				return $this->redirect($response, 'tvshow.index');
			}	
			
		$this->flash('success', 'A new season was created.');
		return $this->redirect($response, 'tvshow.show',['tvshow_id'=>$season->tv_show_id]);
	}

	public function edit(Request $request, Response $response, $args = []){
		$season = Season::find($args['season_id']);
		$users = $users = User::all();

		if (!$season) {
			$this->flash('danger', 'This season could not be found!');
			return $this->redirect($response, 'season.index');
		}
		
		return $this->view($response,'season/edit.twig', compact('season','users'));
	}

	public function update(Request $request, Response $response, $args = []){

		$season = Season::find($args['season_id']);
		if (!$season) {
			$this->flash('danger', 'This season could not be updated!');
			return $this->redirect($response, 'season.index');
		}

		$data = $request->getParams();
		$uploadedFile = new UploadedFiles();
		$uploadedFile->getFiles($request,'image');
		if (!$uploadedFile->hasError()) {

			if ($uploadedFile->getFileSize() > 0) {
				$uploadedFile->moveToDir(config('path.image.season'));
				$data['file_name'] = $uploadedFile->getFileName();
			}
		}
		
		$season->update($data);
		// $season->users()->sync($request->getParam('users'),true);

		if (!$season) {
			$this->flash('danger', 'This season could not be updated!');
			return $this->redirect($response, 'season.index');
		}

		$this->flash('success', 'Your changes were saved!');
		return $this->redirect($response,'season.edit',['season_id'=>$season->id]);		
	}

	public function delete(Request $request, Response $response, $args = []){
		$season = Season::find($args['season_id']);
		if (!$season) {
			$this->flash('danger', 'This season could not be found!');
			return $this->redirect($response, 'season.index');
		}
		$season->delete();
		$this->flash('success', 'season successfully deleted !');
		return $this->redirect($response,'season.index');
		
	}
}