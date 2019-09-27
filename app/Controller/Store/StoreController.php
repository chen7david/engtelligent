<?php
namespace App\Controller\Store;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use Core\Model\Hash;
use Core\Model\Media;
use Core\Model\UploadedFiles;
use Core\Model\Auth;
use Core\Controller\BaseController;

use App\Model\User\User;
use App\Model\Store\Product;
use App\Model\Store\Batch;
use App\Model\Store\Order;


class StoreController extends BaseController
{
	public function index(Request $request, Response $response){
		$products = Product::all();
		return $this->view($response,'store/index.twig',compact('products'));
	}

	public function show(Request $request, Response $response, $args = []){
		$batch = Batch::find($args['batch_id']);
		if (!$batch) {
			$this->flash('danger', 'This batch could not be found!');
			return $this->redirect($response, 'store.index');
		}
		return $this->view($response,'store/show.twig', compact('batch'));
	}

}