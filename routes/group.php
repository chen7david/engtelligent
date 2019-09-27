<?php

$app->group('/auth/group', function() use ($app, $c){

	$app->get('/index', 'GroupController:index')->setName('group.index');
	$app->get('/show/{group_id}', 'GroupController:show')->setName('group.show');
	$app->get('/delete/{group_id}', 'GroupController:delete')->setName('group.delete');

	$app->get('/create', 'GroupController:create')->setName('group.create');
	$app->post('/store', 'GroupController:store')->setName('group.store');
	// ->add(new App\Middleware\group\CreateMiddleware($c));

	$app->get('/edit/{group_id}', 'GroupController:edit')->setName('group.edit');
	$app->post('/update/{group_id}', 'GroupController:update')->setName('group.update');

})->add(new App\Middleware\AdminMiddleware($c))->add( new Core\Middleware\AuthMiddleware($c));