<?php
namespace App\Controller\Store;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use Core\Model\Hash;
use Core\Model\Media;
use Core\Model\UploadedFiles;
use Core\Controller\BaseController;

use App\Model\Store\Product;


class ProductController extends BaseController
{
	public function index(Request $request, Response $response){
		$products = Product::orderBy('created_at','desc')->get();
		return $this->view($response,'product/index.twig',compact('products'));
	}

	public function show(Request $request, Response $response, $args = []){
		$product = Product::find($args['product_id']);
		if (!$product) {
			$this->flash('error', 'This product could not be found!');
			return $this->redirect($response, 'product.index');
		}
		return $this->view($response,'product/show.twig', compact('product'));
	}

	public function create(Request $request, Response $response){
		return $this->view($response,'product/create.twig');
	}

	public function store(Request $request, Response $response){
		
		$data = $request->getParams();
		$uploadedFile = new UploadedFiles();
		$uploadedFile->getFiles($request,'image');
		if (!$uploadedFile->hasError()) {

			if ($uploadedFile->getFileSize() > 0) {
				$uploadedFile->moveToDir(config('path.image.product'));
				$data['file_name'] = $uploadedFile->getFileName();
				$data['size'] = $uploadedFile->getFileSize();
				$data['type'] = $uploadedFile->getMediaType();
				$media = Media::create($data);
			}
		}

		$product = Product::create($data);
						
		return $this->redirect($response, 'product.index');
		
	}

	public function edit(Request $request, Response $response, $args = []){
		$product = Product::find($args['product_id']);
		if (!$product) {
			$this->flash('error', 'This product could not be found!');
			return $this->redirect($response, 'product.index');
		}
		return $this->view($response,'product/edit.twig', compact('product'));
	}

	public function update(Request $request, Response $response, $args = []){

		$product = Product::find($args['product_id']);

		if (!$product) {
			$this->flash('warning', 'We were unable to find this product!');
			return $this->redirect($response,'product.index');	
		}

		$data = $request->getParams();
		$uploadedFile = new UploadedFiles();
		$uploadedFile->getFiles($request,'image');
		if (!$uploadedFile->hasError()) {

			if ($uploadedFile->getFileSize() > 0) {
				$uploadedFile->moveToDir(config('path.image.product'));
				$data['file_name'] = $uploadedFile->getFileName();
			}
		}
		
		$product->update($data);
		
		$this->flash('success', 'Your changes were saved!');
		return $this->redirect($response,'product.edit',['product_id'=>$product->id]);	
	}

	public function delete(Request $request, Response $response, $args = []){
		$product = Product::find($args['product_id']);
		if (!$product) {
			$this->flash('error', 'This product could not be found!');
			return $this->redirect($response, 'product.index');
		}
		$product->delete();
		$this->flash('success', 'product successfully deleted !');
		return $this->redirect($response,'product.index');
		
	}
	
}