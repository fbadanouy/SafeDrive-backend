<?php

date_default_timezone_set("America/Montevideo");

if (file_exists('protected/vendor/autoload.php'))
    require("protected/vendor/autoload.php");

$config = require("protected/config/config.php");

$_webApp = new oxusmedia\webApp\webApp($config);

$_webApp->run();
