<?php

$app->group('/auth/season', function() use ($app, $c){

	$app->get('/index', 'SeasonController:index')->setName('season.index');
	$app->get('/{season_id}/show', 'SeasonController:show')->setName('season.show');
	$app->get('/{season_id}/delete', 'SeasonController:delete')->setName('season.delete');

	$app->get('/{tvshow_id}/create', 'SeasonController:create')->setName('season.create');
	$app->post('/store', 'SeasonController:store')->setName('season.store');
	// ->add(new App\Middleware\season\CreateMiddleware($c));

	$app->get('/{season_id}/edit', 'SeasonController:edit')->setName('season.edit');
	$app->post('/{season_id}/update', 'SeasonController:update')->setName('season.update');

})->add(new App\Middleware\AdminMiddleware($c))->add( new Core\Middleware\AuthMiddleware($c));