<?php

$app->group('/auth/store', function() use ($app, $c){

	$app->get('/index', 'StoreController:index')->setName('store.index');
	$app->get('/{batch_id}/show', 'StoreController:show')->setName('store.show');
	$app->get('{user_id}/user/{batch_id}/order', 'StoreController:order')->setName('store.not');

})->add( new Core\Middleware\AuthMiddleware($c));