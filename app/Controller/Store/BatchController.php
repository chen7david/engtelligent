<?php
namespace App\Controller\Store;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use Core\Model\Hash;
use Core\Model\Media;
use Core\Model\UploadedFiles;
use Core\Controller\BaseController;


use App\Model\Store\Product;
use App\Model\Store\Batch;


class BatchController extends BaseController
{
	public function index(Request $request, Response $response){
		$batches = Batch::all();
		return $this->view($response,'batch/index.twig',compact('batches'));
	}

	public function show(Request $request, Response $response, $args = []){
		$batch = Batch::find($args['batch_id']);
		if (!$batch) {
			$this->flash('error', 'This batch could not be found!');
			return $this->redirect($response, 'batch.index');
		}
		return $this->view($response,'batch/show.twig', compact('batch'));
	}

	public function create(Request $request, Response $response, $args = []){
		$product = Product::find($args['product_id']);
		if (!$product) {
			$this->flash('danger', 'This batch could not be found!');
			return $this->redirect($response, 'product.index');
		}
		return $this->view($response,'batch/create.twig',compact('product'));
	}

	public function store(Request $request, Response $response){

		$batch = Batch::create($request->getParams());
		if (!$batch) {
			$this->flash('danger', 'This batch could not be found!');
			return $this->redirect($response, 'product.index');
		}				
		return $this->redirect($response, 'product.show',['product_id'=>$batch->product_id]);	
	}

	public function edit(Request $request, Response $response, $args = []){
		$batch = Batch::find($args['batch_id']);
		if (!$batch) {
			$this->flash('error', 'This batch could not be found!');
			return $this->redirect($response, 'batch.index');
		}
		return $this->view($response,'batch/edit.twig', compact('batch'));
	}

	public function update(Request $request, Response $response, $args = []){
		// kill($request->getParams());
		$batch = Batch::find($args['batch_id']);

		if (!$batch) {
			$this->flash('warning', 'We were unable to find this batch!');
			return $this->redirect($response,'batch.index');	
		}

		$data = $request->getParams();		
		$batch->update($data);
		
		$this->flash('success', 'Your changes were saved!');
		return $this->redirect($response,'batch.edit',['batch_id'=>$batch->id]);		
	}

	public function delete(Request $request, Response $response, $args = []){
		$batch = Batch::find($args['batch_id']);
		if (!$batch) {
			$this->flash('error', 'This batch could not be found!');
			return $this->redirect($response, 'batch.index');
		}
		$batch->delete();
		$this->flash('success', 'batch successfully deleted !');
		return $this->redirect($response,'batch.index');
		
	}
	
}