<?php 
namespace Core\Middleware;
use \Psr\Http\Message\ResponseInterface as Response;

class BaseMiddleware
{

	protected $c;

	public function __construct($container){
		$this->c = $container;
	}

	public function render(Response $response, $pagePath, $data = []){
		return $this->c->view->render($response, $pagePath, $data);
	}

	public function redirect($response,$pathName,$parameters = []){
		 return $response->withRedirect($this->c->router->pathFor($pathName, $parameters)); 
	}

	public function addGlobal($key, $data){
		$this->c->view->getEnvironment()->addGlobal($key, $data);
	}

	public function flash($key,$value){
		$this->c->flash->addMessage($key,$value);
	}

	public function view(){
		return $this->c->view;
	}
	
}