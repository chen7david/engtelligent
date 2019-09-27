<?php

$app->group('/auth/lessonaudio', function() use ($app, $c){

	$app->get('/show/{lessonaudio_id}', 'LessonAudioController:show')->setName('lessonaudio.show');

	$app->get('/{lesson_id}/create', 'LessonAudioController:create')->setName('lessonaudio.create');
	$app->post('/store', 'LessonAudioController:store')->setName('lessonaudio.store');
	// ->add(new App\Middleware\lesson\CreateMiddleware($c));

	$app->get('/edit/{lessonaudio_id}', 'LessonAudioController:edit')->setName('lessonaudio.edit');
	$app->post('/update/{lessonaudio_id}', 'LessonAudioController:update')->setName('lessonaudio.update');

})->add(new App\Middleware\AdminMiddleware($c))->add( new Core\Middleware\AuthMiddleware($c));