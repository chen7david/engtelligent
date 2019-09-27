<?php

$app->group('/auth/lessonvideo', function() use ($app, $c){

	$app->get('/show/{lessonvideo_id}', 'LessonVideoController:show')->setName('lessonvideo.show');

	$app->get('/{lesson_id}/create', 'LessonVideoController:create')->setName('lessonvideo.create');
	$app->post('/store', 'LessonVideoController:store')->setName('lessonvideo.store');
	// ->add(new App\Middleware\lesson\CreateMiddleware($c));

	$app->get('/edit/{lessonvideo_id}', 'LessonVideoController:edit')->setName('lessonvideo.edit');
	$app->post('/{lessonvideo_id}/update/', 'LessonVideoController:update')->setName('lessonvideo.update');
	$app->get('/{lessonvideo_id}/delte/', 'LessonVideoController:delete')->setName('lessonvideo.delete');

})->add(new App\Middleware\AdminMiddleware($c))->add( new Core\Middleware\AuthMiddleware($c));