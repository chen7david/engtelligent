<?php
namespace Core\Controller;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

class BaseController
{
	protected $c;
	function __construct($c)
	{
		$this->c = $c;
	}

	public function view(Response $response, $pagePath, $data = []){
		$this->c->view->render($response, $pagePath, $data);
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
}