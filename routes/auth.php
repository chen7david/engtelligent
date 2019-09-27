<?php
// Only authenticated users are able to access these routes

$app->group('/auth', function() use ($app, $c){

	$app->get('/logout', 'AuthController:logout')->setName('app.logout');
	$app->get('/password/update', 'PasswordUpdateController:getPasswordUpdate')->setName('password.update');
	$app->post('/password/update', 'PasswordUpdateController:postPasswordUpdate')->add(new Core\Middleware\PasswordUpdateMiddleware($c));
	$app->get('/authorization/check', 'AuthorizationController:check')->setName('authorization.check');
	$app->get('/authorization/report', 'AuthorizationController:report')->setName('authorization.report');

})->add(new Core\Middleware\AuthMiddleware($c));
