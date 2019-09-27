<?php

$app->group('/auth/batch', function() use ($app, $c){

	$app->get('/index', 'BatchController:index')->setName('batch.index');
	$app->get('/{batch_id}/show', 'BatchController:show')->setName('batch.show');
	$app->get('/{batch_id}/delete', 'BatchController:delete')->setName('batch.delete');

	$app->get('/{product_id}/create', 'BatchController:create')->setName('batch.create');
	$app->post('/store', 'BatchController:store')->setName('batch.store');
	// ->add(new App\Middleware\batch\CreateMiddleware($c));

	$app->get('/{batch_id}/edit', 'BatchController:edit')->setName('batch.edit');
	$app->post('{batch_id}/update/', 'BatchController:update')->setName('batch.update');

})->add(new App\Middleware\AdminMiddleware($c))->add( new Core\Middleware\AuthMiddleware($c));