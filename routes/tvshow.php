<?php

$app->group('/auth/tvshow', function() use ($app, $c){

	$app->get('/index', 'TvShowController:index')->setName('tvshow.index');
	$app->get('/{tvshow_id}/show', 'TvShowController:show')->setName('tvshow.show');
	$app->get('/{tvshow_id}/delete', 'TvShowController:delete')->setName('tvshow.delete');

	$app->get('/create', 'TvShowController:create')->setName('tvshow.create');
	$app->post('/store', 'TvShowController:store')->setName('tvshow.store');
	// ->add(new App\Middleware\tvshow\CreateMiddleware($c));

	$app->get('/{tvshow_id}/edit', 'TvShowController:edit')->setName('tvshow.edit');
	$app->post('/{tvshow_id}/update', 'TvShowController:update')->setName('tvshow.update');

})->add(new App\Middleware\AdminMiddleware($c))->add( new Core\Middleware\AuthMiddleware($c));