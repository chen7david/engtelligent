<?php

$app->group('/auth/order', function() use ($app, $c){

	$app->get('/index', 'OrderController:index')->setName('order.index');
	$app->get('/show/{order_id}', 'OrderController:show')->setName('order.show');
	$app->get('/delete/{order_id}', 'OrderController:delete')->setName('order.delete');

	$app->post('{batch_id}/order', 'OrderController:create')->setName('order.create');

	$app->get('/redeem/{code}', 'OrderController:redeem')->setName('order.redeem')->add(new App\Middleware\AdminMiddleware($c));
	$app->get('/redeemed/{code}', 'OrderController:redeemed')->setName('order.redeemed')->add(new App\Middleware\AdminMiddleware($c));

	// $app->get('/redeem/{order_id}', 'OrderController:redeem')->setName('order.create');
	// $app->post('/store', 'OrderController:store')->setName('order.store');
	// // ->add(new App\Middleware\order\CreateMiddleware($c));

	// $app->get('/edit/{order_id}', 'OrderController:edit')->setName('order.edit');
	// $app->post('/update/{order_id}', 'OrderController:update')->setName('order.update');

})->add( new Core\Middleware\AuthMiddleware($c));