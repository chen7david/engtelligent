<?php

$app->group('/auth/product', function() use ($app, $c){

	$app->get('/index', 'ProductController:index')->setName('product.index');
	$app->get('/{product_id}/show', 'ProductController:show')->setName('product.show');
	$app->get('/delete/{product_id}', 'ProductController:delete')->setName('product.delete');

	$app->get('/create', 'ProductController:create')->setName('product.create');
	$app->post('/store', 'ProductController:store')->setName('product.store');
	// ->add(new App\Middleware\product\CreateMiddleware($c));

	$app->get('/edit/{product_id}', 'ProductController:edit')->setName('product.edit');
	$app->post('/update/{product_id}', 'ProductController:update')->setName('product.update');

})->add(new App\Middleware\AdminMiddleware($c))->add( new Core\Middleware\AuthMiddleware($c));