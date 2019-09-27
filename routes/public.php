<?php
// Both authenticated and non-authenticated users are able to access these routes

$app->group('', function() use ($app, $c){

	$app->get('/', 'AppController:home')->setName('app.home');
	$app->get('/email/verify/{hash}', 'EmailActivationController:verifyEmail')->setName('email.verify');
	$app->get('/email/resend/vercode/{hash}', 'EmailActivationController:resendVerCode')->setName('email.resendvercode');

	$app->get('/password/recover', 'PasswordRecoverController:getPasswordRecoverForm')->setName('password.getrecover');
	$app->post('/password/recover', 'PasswordRecoverController:sendPasswordRecoverEmail')->setName('password.postrecover');
	$app->get('/password/change/{hash}', 'PasswordRecoverController:getPasswordChangeForm')->setName('password.change');
	$app->post('/password/change', 'PasswordRecoverController:postPasswordChangeForm')->setName('password.postchange')->add( new Core\Middleware\PasswordRecoverMiddleware($c));

});
