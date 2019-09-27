<?php

$app->group('/auth/profile', function() use ($app, $c){

	$app->get('/index', 'ProfileController:index')->setName('profile.index');
	$app->get('/{session_id}/session', 'ProfileController:session')->setName('profile.session');
	$app->get('/{lessonvideo_id}/{session_id}/video', 'ProfileController:showvideo')->setName('profile.lessonvideo');
	$app->get('/{lessonaudio_id}/{session_id}/audio', 'ProfileController:showaudio')->setName('profile.lessonaudio');
	// $app->get('/delete/{group_id}', 'GroupController:delete')->setName('group.delete');

	// $app->get('/create', 'GroupController:store')->setName('group.create');
	// $app->post('/store', 'GroupController:store')->setName('group.store');
	// // ->add(new App\Middleware\group\CreateMiddleware($c));

	// $app->get('/edit/{group_id}', 'GroupController:edit')->setName('group.edit');
	// $app->post('/update/{group_id}', 'GroupController:update')->setName('group.update');

})->add( new Core\Middleware\AuthMiddleware($c));