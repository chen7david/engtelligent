<?php

$app->group('/auth/lessontext', function() use ($app, $c){

	$app->get('/{lessontext_id}/show', 'LessonTextController:show')->setName('lessontext.show');

	$app->get('/{lesson_id}/create', 'LessonTextController:create')->setName('lessontext.create');
	$app->post('/store', 'LessonTextController:store')->setName('lessontext.store');
	// ->add(new App\Middleware\lesson\CreateMiddleware($c));

	$app->get('/{lessontext_id}/edit', 'LessonTextController:edit')->setName('lessontext.edit');
	$app->post('/{lessontext_id}/update', 'LessonTextController:update')->setName('lessontext.update');
	$app->get('/{lessontext_id}/delete', 'LessonTextController:delete')->setName('lessontext.delete');

})->add(new App\Middleware\AdminMiddleware($c))->add( new Core\Middleware\AuthMiddleware($c));