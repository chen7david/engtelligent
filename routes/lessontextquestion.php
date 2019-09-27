<?php

$app->group('/auth/lessontextquestion', function() use ($app, $c){

	$app->get('/{lessontextquestion_id}/show', 'LessonTextQuestionController:show')->setName('lessontextquestion.show');

	$app->get('/{lessontext_id}/create', 'LessonTextQuestionController:create')->setName('lessontextquestion.create');
	$app->post('/store', 'LessonTextQuestionController:store')->setName('lessontextquestion.store');
	// ->add(new App\Middleware\lesson\CreateMiddleware($c));

	$app->get('/{lessontextquestion_id}/edit', 'LessonTextQuestionController:edit')->setName('lessontextquestion.edit');
	$app->post('/{lessontextquestion_id}/update', 'LessonTextQuestionController:update')->setName('lessontextquestion.update');
	$app->get('/{lessontextquestion_id}/delete', 'LessonTextQuestionController:delete')->setName('lessontextquestion.delete');

})->add(new App\Middleware\AdminMiddleware($c))->add( new Core\Middleware\AuthMiddleware($c));