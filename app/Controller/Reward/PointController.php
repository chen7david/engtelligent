<?php
namespace App\Controller\Reward;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

use Core\Controller\BaseController;

use App\Model\Group\Group;
use App\Model\Reward\Point;
use App\Model\User\User;
use Core\Model\Auth;

class PointController extends BaseController
{
	public function deposit(Request $request, Response $response){

		$points = $request->getParam('points');
		$session_id =  $request->getParam('session_id');

		if ($points) {
			
			foreach ($points as $point) {
				if ($point['amount'] != 0) {
					$obj = Point::create($point);

					if (!$obj) {
						$this->flash('danger','Points store failed');
						return $this->redirect($response, 'group.index');
					}
				}

			}
			$this->flash('notice','Points were stored!');
			return $this->redirect($response, 'session.show',['session_id'=>$session_id]);
		}else{

			$this->flash('danger','Points store failed');
			return $this->redirect($response, 'group.index');
		}
		
	}

}