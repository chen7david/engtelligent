<?php

$app->group('/auth/lesson', function() use ($app, $c){

	$app->get('/index', 'LessonController:index')->setName('lesson.index');
	$app->get('/{lesson_id}/show', 'LessonController:show')->setName('lesson.show');
	$app->get('/{lesson_id}/delete', 'LessonController:delete')->setName('lesson.delete');

	$app->get('/create', 'LessonController:create')->setName('lesson.create');
	$app->post('/store', 'LessonController:store')->setName('lesson.store');
	// ->add(new App\Middleware\lesson\CreateMiddleware($c));

	$app->get('/edit/{lesson_id}', 'LessonController:edit')->setName('lesson.edit');
	$app->post('/update/{lesson_id}', 'LessonController:update')->setName('lesson.update');

})->add(new App\Middleware\AdminMiddleware($c))->add( new Core\Middleware\AuthMiddleware($c));