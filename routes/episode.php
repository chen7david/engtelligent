<?php

$app->group('/auth/episode', function() use ($app, $c){

	$app->get('/index', 'EpisodeController:index')->setName('episode.index');
	$app->get('/{episode_id}/show', 'EpisodeController:show')->setName('episode.show');
	$app->get('/{episode_id}/delete', 'EpisodeController:delete')->setName('episode.delete');

	$app->get('/{season_id}/create', 'EpisodeController:create')->setName('episode.create');
	$app->post('/store', 'EpisodeController:store')->setName('episode.store');
	// ->add(new App\Middleware\episode\CreateMiddleware($c));

	$app->get('/{episode_id}/edit', 'EpisodeController:edit')->setName('episode.edit');
	$app->post('/{episode_id}/update', 'EpisodeController:update')->setName('episode.update');

})->add(new App\Middleware\AdminMiddleware($c))->add( new Core\Middleware\AuthMiddleware($c));