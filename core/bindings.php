<?php

$c['UserController'] = function($c) { return new App\Controller\User\UserController($c); };
$c['UserUpdateController'] = function($c) { return new App\Controller\User\UserUpdateController($c); };
$c['UserAppendController'] = function($c) { return new App\Controller\User\UserAppendController($c); };
$c['UserDetachController'] = function($c) { return new App\Controller\User\UserDetachController($c); };


$c['AuthorizationController'] = function($c) { return new App\Controller\Authorize\AuthorizationController($c); };

$c['GroupController'] = function($c) { return new App\Controller\Group\GroupController($c); };
$c['SessionController'] = function($c) { return new App\Controller\Group\SessionController($c); };

$c['UserContactObjectController'] = function($c) { return new App\Controller\User\UserContactObjectController($c); };


$c['PointController'] = function($c) { return new App\Controller\Reward\PointController($c); };

$c['ProfileController'] = function($c) { return new App\Controller\Profile\ProfileController($c); };

$c['ProductController'] = function($c) { return new App\Controller\Store\ProductController($c); };
$c['BatchController'] = function($c) { return new App\Controller\Store\BatchController($c); };
$c['StoreController'] = function($c) { return new App\Controller\Store\StoreController($c); };
$c['OrderController'] = function($c) { return new App\Controller\Store\OrderController($c); };

$c['LessonController'] = function($c) { return new App\Controller\Learn\LessonController($c); };
$c['LessonVideoController'] = function($c) { return new App\Controller\Learn\LessonVideoController($c); };
$c['LessonAudioController'] = function($c) { return new App\Controller\Learn\LessonAudioController($c); };
$c['LessonTextController'] = function($c) { return new App\Controller\Learn\LessonTextController($c); };
$c['LessonWordController'] = function($c) { return new App\Controller\Learn\LessonWordController($c); };
$c['LessonQuestionController'] = function($c) { return new App\Controller\Learn\LessonQuestionController($c); };
$c['LessonObjectiveController'] = function($c) { return new App\Controller\Learn\LessonObjectiveController($c); };
$c['LessonTextQuestionController'] = function($c) { return new App\Controller\Learn\LessonTextQuestionController($c); };


$c['TvShowController'] = function($c) { return new App\Controller\Media\TvShowController($c); };
$c['SeasonController'] = function($c) { return new App\Controller\Media\SeasonController($c); };
$c['EpisodeController'] = function($c) { return new App\Controller\Media\EpisodeController($c); };
$c['ViewController'] = function($c) { return new App\Controller\Media\ViewController($c); };

