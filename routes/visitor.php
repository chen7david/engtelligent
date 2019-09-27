<?php
// Only non-authenticated users are able to access these routes

$app->group('/visitor', function() use ($app, $c){

	$app->get('/register', 'RegisterController:getRegister')->setName('app.register');
	$app->post('/register', 'RegisterController:postRegister')->add(new \Core\Middleware\RegisterValidationMiddleware($c));

	$app->get('/login', 'AuthController:getLogin')->setName('app.login');
	$app->post('/login', 'AuthController:postLogin');

})->add(new Core\Middleware\VisitorMiddleware($c));