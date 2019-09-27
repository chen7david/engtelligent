<?php

$app->group('/auth/lessonquestion', function() use ($app, $c){

	$app->get('/{lessonquestion_id}/show', 'LessonQuestionController:show')->setName('lessonquestion.show');

	$app->get('/{lesson_id}/create', 'LessonQuestionController:create')->setName('lessonquestion.create');
	$app->post('/store', 'LessonQuestionController:store')->setName('lessonquestion.store');
	// ->add(new App\Middleware\lesson\CreateMiddleware($c));

	$app->get('/{lessonquestion_id}/edit', 'LessonQuestionController:edit')->setName('lessonquestion.edit');
	$app->post('/{lessonquestion_id}/update', 'LessonQuestionController:update')->setName('lessonquestion.update');
	$app->get('/{lessonquestion_id}/delete', 'LessonQuestionController:delete')->setName('lessonquestion.delete');

})->add(new App\Middleware\AdminMiddleware($c))->add( new Core\Middleware\AuthMiddleware($c));