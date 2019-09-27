<?php

$app->group('/auth/lessonword', function() use ($app, $c){

	$app->get('/{lessonword_id}/show', 'LessonWordController:show')->setName('lessonword.show');

	$app->get('/{lesson_id}/create', 'LessonWordController:create')->setName('lessonword.create');
	$app->post('/store', 'LessonWordController:store')->setName('lessonword.store');
	// ->add(new App\Middleware\lesson\CreateMiddleware($c));

	$app->get('/{lessonword_id}/edit', 'LessonWordController:edit')->setName('lessonword.edit');
	$app->post('/{lessonword_id}/update', 'LessonWordController:update')->setName('lessonword.update');
	$app->get('/{lessonword_id}/delte', 'LessonWordController:delete')->setName('lessonword.delete');

})->add(new App\Middleware\AdminMiddleware($c))->add( new Core\Middleware\AuthMiddleware($c));