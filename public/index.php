<?php
// Setting up Application
// phpinfo(); 
require __DIR__."/../vendor/autoload.php";
require __DIR__."/../config.php";

require __DIR__."/../system/app.php";
require __DIR__."/../core/bindings.php";
require __DIR__."/../core/routes.php";

$app->run();


