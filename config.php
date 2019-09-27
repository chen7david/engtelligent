<?php
session_start();

// Database
$db['driver'] 	= 'mysql';
$db['host'] 	= '192.168.50.251;port=3002';
$db['database'] = 'engtelligent';
$db['username'] = 'admin';
$db['password'] = 'admin';
$db['charset']   = 'utf8';
$db['collation'] = 'utf8_unicode_ci';
$db['prefix'] 	= '';

// Email
$mailer['domain'] 	    = 'http://aox.asuscomm.com'; 
$mailer['smtp_debug']   = false;
$mailer['smtp_auth'] 	= true;
$mailer['smtp_secure']  = 'ssl';
$mailer['host'] 		= 'engtelligent.com';
$mailer['username'] 	= 'security@engtelligent.com';
$mailer['password'] 	= 'password';
$mailer['port'] 		= 465;
$mailer['html'] 		= true;

// Sessions
$cookie['name'] = 'user';
$cookie['duration'] = 604800 * 2;
$cookie['allowed'] = 2;
$cookie['storage'] = 'cookie';


// Default
$default['password'] = '888888';
$default['role'] = 4;
$default['league'] = 2;

// Default Media Objects Paths
$path['image']['product'] = '/uploads/image/product';
$path['image']['avatar'] = '/uploads/profile/image/avatar';

$path['video']['tvshow']['image'] = '/uploads/image/tvshow';
$path['video']['tvshow']['file'] = '/uploads/video/tvshow';
$path['video']['movie']['image'] = '/uploads/image/movie';
$path['video']['movie']['file'] = '/uploads/video/movie';

$path['audio']['album']['image'] = '/uploads/image/album';
$path['audio']['album']['file'] = '/uploads/audio/album';


$path['audio']['lesson']['file'] = '/uploads/lesson/audio/audio';
$path['audio']['lesson']['image'] = '/uploads/lesson/audio/image';
$path['video']['lesson']['file'] = '/uploads/lesson/video';

$path['lesson']['text']['audio']= '/uploads/lesson/text/audio';
$path['lesson']['text']['image'] = '/uploads/lesson/text/image';

$path['image']['lesson'] = 		   '/uploads/lesson/lesson/image';
$path['lesson']['video']['video']= '/uploads/lesson/video/video';
$path['lesson']['video']['image']= '/uploads/lesson/video/image';

$path['lesson']['audio']['audio'] = '/uploads/lesson/audio/audio';
$path['lesson']['audio']['image']=  '/uploads/lesson/audio/image';

$path['tvshow']['video'] = '/uploads/tvshow/video';
$path['tvshow']['image']=  '/uploads/tvshow/image';

// allowed file types


// Auth Types
$auth['username'] = 1;
$auth['phone_number'] = 2;
$auth['email'] = 3;

// Agrigrate Session Data
$config['db'] 	   = $db;
$config['mail']  = $mailer;
$config['cookie'] = $cookie;
$config['default'] = $default;
$config['auth'] = $auth;
$config['path'] = $path;

$_SESSION['config'] = $config;
