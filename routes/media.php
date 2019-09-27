<?php
// Only non-authenticated users are able to access these routes

$app->group('/media', function() use ($app, $c){

	$app->get('/tvshows', 'TvShowController:collection')->setName('tvshow.collection');
	$app->get('/{tvshow_id}/tvshow/{season_rank}/season', 'TvShowController:info')->setName('tvshow.info');
	$app->get('/tvshow/watch/{episode_id}/episode', 'TvShowController:watch')->setName('tvshow.watch');
	// $app->post('/register', 'RegisterController:postRegister')->add(new \Core\Middleware\RegisterValidationMiddleware($c));

	// $app->get('/login', 'AuthController:getLogin')->setName('app.login');
	// $app->post('/login', 'AuthController:postLogin');

})->add(new Core\Middleware\AuthMiddleware($c));