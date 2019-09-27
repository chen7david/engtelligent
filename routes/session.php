<?php

$app->group('/auth/session', function() use ($app, $c){

	$app->get('/show/{session_id}', 'SessionController:show')->setName('session.show');
	$app->get('/delete/{session_id}', 'SessionController:delete')->setName('session.delete');

	$app->get('/create/{group_id}', 'SessionController:create')->setName('session.create');
	$app->post('/store/{group_id}', 'SessionController:store')->setName('session.store');


	$app->get('/edit/{session_id}', 'SessionController:edit')->setName('session.edit');
	$app->post('/update/{session_id}', 'SessionController:update')->setName('session.update');

	$app->post('/points/{session_id}', 'PointController:store')->setName('points.store');

})->add( new Core\Middleware\AuthMiddleware($c));

