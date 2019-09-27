<?php 
namespace Core\Middleware;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

use Core\Middleware\BaseMiddleware;
use Core\Model\Cookie;
use Core\Model\Token;
use Core\Model\Auth;
use App\Model\User\User as User;
use Core\Model\Mail;
use Slim\Views\Twig;
use Core\Model\Hash;
use App\Model\User\Conapp;
use App\Model\User\Conobj;
use App\Model\Learn\LessonText;

use App\Model\Store\Batch;



class AppMiddleware extends BaseMiddleware
{
	public function __invoke(Request $request, Response $response, $next)
	{	
		// kill((LessonText::find(1))->lessontextquestions());
		// $user = Auth::user();
		// kill($user->avatars()->count());
		// kill((Batch::find(2)->reduceAmount())->amount);
		// kill(User::find(109)->avatars());
		// kill(Auth::user()->groups()->latest());
		// kill(config('media.video.tvshow'));
		// makedir(config('path.image.avatar'));
		// kill((Lesson::find(1))->lessonvideos());
		if (Cookie::issetToken()) {

			$auth = new Auth;
			$request = $request->withAttribute('auth', $auth);
			$this->addGlobal('auth', $auth);
			
			$token = Token::get(Cookie::getToken());
			
			if (!$token || !$token->isActive()) {
				Cookie::unsetToken();
				$this->flash('danger', 'invalid token!');	
				return $this->redirect($response, 'app.login');
			}

			if ($token->hasExpired()) {
				$token->delete();
				Cookie::unsetToken();
				$this->flash('warning', 'Your token has expired, please login!');	
				return $this->redirect($response, 'app.login');
			}

			if ($token->refreshIn()<86400) {
				$token->refreshAt();
				$cookie = Cookie::setToken($token);

				if (!$cookie) {
					$token->delete();
					$this->flash('danger', 'Cookie extention faild!');	
					return $this->redirect($response, 'app.login');
				}

			}

			$token->logCallCount();
			
		}

		$response = $next($request, $response);
		
		return $response;
	}
}