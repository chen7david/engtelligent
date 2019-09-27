<?php
namespace App\Controller\Store;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use Core\Model\Hash;
use Core\Model\Media;
use Core\Model\UploadedFiles;
use Core\Model\Auth;
use Core\Controller\BaseController;

use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;

use App\Model\User\User;
use App\Model\Store\Product;
use App\Model\Store\Batch;
use App\Model\Store\Order;


class OrderController extends BaseController
{
	public function index(Request $request, Response $response){
		$orders = Auth::user()->orders;
		return $this->view($response,'order/index.twig',compact('orders'));
	}

	public function show(Request $request, Response $response, $args = []){
		$order = Order::find($args['order_id']);
		if (!$order) {
			$this->flash('danger', 'This order could not be found!');
			return $this->redirect($response, 'order.index');
		}
		$qr = new QRCode;
		return $this->view($response,'order/show.twig', compact('order','qr'));
	}

	public function create(Request $request, Response $response, $args = []){
		
		$batch = Batch::find($request->getParam('batch_id'));
		if ($batch->amount <= 0) {
			$this->flash('warning', 'This product is currenlty out of stock!');
			return $this->redirect($response, 'store.show',['batch_id'=>$batch->id]);
		}
		$amount = $request->getParam('amount');
		$user = Auth::user();
		if (!$user || !$batch ) {
			$this->flash('danger', 'Something went wrong.');
			return $this->redirect($response, 'store.show',['batch_id'=>$batch->id]);
		}
		$total = $amount * $batch->price;

		if (!$user->hasFunds($total)) {
			$this->flash('warning', 'You do not have sufficient funds to purchase this item.');
			return $this->redirect($response, 'store.show',['batch_id'=>$batch->id]);
		}

		$order = new Order();
		$order->batch_id = $batch->id;
		$order->amount = $amount;
		$order->code = strtoupper(Hash::render(11));

		if (!$user->pay($total)) {
			$this->flash('warning', 'Your payment faild, please try again.');
			return $this->redirect($response, 'store.show',['batch_id'=>$batch->id]);
		}

		$user->orders()->save($order);
		$batch->reduceAmount($amount);

		$this->flash('success', 'Product purchased, you can view your orders in the page orders page.');
		return $this->redirect($response, 'store.show',['batch_id'=>$batch->id]);
	}

	public function redeem(Request $request, Response $response, $args = []){
		
		$order = Order::where('code',$args['code'])->first();
		if (!$order) {
			$this->flash('danger', 'Invalid redemption code!');
			return $this->redirect($response, 'order.index');
		}

		return $this->view($response,'order/redeemcode.twig', compact('order'));
	}

	public function redeemed(Request $request, Response $response, $args = []){
		
		$order = Order::where('code',$args['code'])->first();
		if (!$order) {
			$this->flash('danger', 'Invalid redemption code!');
			return $this->redirect($response, 'order.index');
		}

		$order->setRedeemedTo(true);

		if (!$order->redeemed()) {
			$this->flash('danger', 'Faild to redeem order!');
			return $this->redirect($response, 'order.index');
		}
		$order->update();
		$this->flash('success', 'Order was redeemd!');
		return $this->redirect($response, 'order.redeem',['code'=>$order->code]);
	}

	// public function redeem(Request $request, Response $response, $args = []){

	// }

	

	
}