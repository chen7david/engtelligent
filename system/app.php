<?php
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use Core\Model\Config;
use Core\Model\Mailer;
use Slim\Views\Twig;

$app = new \Slim\App([
	'settings' => [
		'determineRouteBeforeAppMiddleware' => true,
		'displayErrorDetails' 				=> true,
	]
]);

$c = $app->getContainer();

$capsule = new \Illuminate\Database\Capsule\Manager;
$capsule->addConnection(Config::get('db'));
$capsule->setAsGlobal();
$capsule->bootEloquent();

$c['view'] = function($c){
	$options['cache']=false;
	$view = new Twig(__DIR__."/../view", $options);

	$view->addExtension(new \Slim\Views\TwigExtension(
		$c->router,
		$c->request->getUri()
	));

	$filter = new Twig_SimpleFilter('phone', function ($num) {
        return ($num)?''.substr($num,0,3).'-'.substr($num,3,4).'-'.substr($num,8,10):'&nbsp;';
    });

    $view->getEnvironment()->addFilter($filter);

	$view->getEnvironment()->addGlobal('flash', $c->flash);
	$view->getEnvironment()->addGlobal('domain', Config::get('mail.domain'));

	return $view;
};

$c['flash'] = function($c) { return new Slim\Flash\Messages(); };

$c['mail'] = function($c){

	$mailer = new PHPMailer();
	$mailer->SMTPDebug = Config::get('mail.smtp_debug');
	$mailer->isSMTP();
	$mailer->Host = Config::get('mail.host');
	$mailer->SMTPAuth = Config::get('mail.smtp_auth');
	$mailer->Username = Config::get('mail.username');
	$mailer->Password = Config::get('mail.password');
	$mailer->SMTPSecure = Config::get('mail.smtp_secure');
	$mailer->Port = Config::get('mail.port');
	$mailer->isHTML(true); 
	$mailer->setFrom(Config::get('mail.username'));

	return new Mailer($c->view, $mailer);
};

$app->add(new Core\Middleware\AppMiddleware($c));
$c['AppController'] = function($c) { return new Core\Controller\AppController($c); };
$c['RegisterController'] = function($c) { return new Core\Controller\RegisterController($c); };
$c['AuthController'] = function($c) { return new Core\Controller\AuthController($c); };
$c['EmailActivationController'] = function($c) { return new Core\Controller\EmailActivationController($c); };
$c['PasswordRecoverController'] = function($c) { return new Core\Controller\PasswordRecoverController($c); };
$c['PasswordUpdateController'] = function($c) { return new Core\Controller\PasswordUpdateController($c); };





