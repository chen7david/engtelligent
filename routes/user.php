<?php

$app->group('/auth/user', function() use ($app, $c){

	$app->get('/index', 'UserController:index')->setName('user.index');
	$app->get('/{user_id}/show', 'UserController:show')->setName('user.show');
	$app->get('/{user_id}/delete', 'UserController:delete')->setName('user.delete');

	$app->get('/user/add', 'UserUpdateController:add')->setName('user.add');

	$app->get('/{user_id}/edit', 'UserUpdateController:edit')->setName('user.edit');
	$app->post('/{user_id}/update', 'UserUpdateController:update')->setName('user.update');

	$app->get('/{user_id}/append/{obj}', 'UserAppendController:append')->setName('user.append');
	$app->get('/{user_id}/detach/{obj_id}/{obj}', 'UserDetachController:detach')->setName('user.detach');

	$app->get('/contactobject/{user_id}/append', 'UserContactObjectController:getAppend')->setName('user.getappend.contactobject');
	$app->post('/append/contactobject', 'UserContactObjectController:postAppend')->setName('user.postappend.contactobject');


})->add(new App\Middleware\AdminMiddleware($c))->add( new Core\Middleware\AuthMiddleware($c));







