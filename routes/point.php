<?php

$app->group('/auth/point', function() use ($app, $c){

	$app->post('/deposit', 'PointController:deposit')->setName('point.deposit');
	// $app->get('/show/{group_id}', 'PointController:show')->setName('group.show');
	// $app->get('/delete/{group_id}', 'PointController:delete')->setName('group.delete');

	// $app->get('/create', 'PointController:store')->setName('group.create');
	// $app->post('/store', 'PointController:store')->setName('group.store');
	// // ->add(new App\Middleware\group\CreateMiddleware($c));

	// $app->get('/edit/{group_id}', 'PointController:edit')->setName('group.edit');
	// $app->post('/update/{group_id}', 'PointController:update')->setName('group.update');

})->add( new Core\Middleware\AuthMiddleware($c));