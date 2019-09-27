<?php

$app->group('/auth/lessonobjective', function() use ($app, $c){

	$app->get('/{lessonobjective_id}/show', 'LessonObjectiveController:show')->setName('lessonobjective.show');

	$app->get('/{lesson_id}/create', 'LessonObjectiveController:create')->setName('lessonobjective.create');
	$app->post('/store', 'LessonObjectiveController:store')->setName('lessonobjective.store');
	// ->add(new App\Middleware\lesson\CreateMiddleware($c));

	$app->get('/{lessonobjective_id}/edit', 'LessonObjectiveController:edit')->setName('lessonobjective.edit');
	$app->post('/{lessonobjective_id}/update', 'LessonObjectiveController:update')->setName('lessonobjective.update');
	$app->get('/{lessonobjective_id}/delete', 'LessonObjectiveController:delete')->setName('lessonobjective.delete');

})->add(new App\Middleware\AdminMiddleware($c))->add( new Core\Middleware\AuthMiddleware($c));