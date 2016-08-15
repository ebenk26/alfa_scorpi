<?php

return array(
    'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
    'name'=>'Cron',
    'preload'=>array('log'),
    'import'=>array(
    'application.components.*',
    'application.models.*',
    ),
    // application components
    'components'=>array(
    'db'=>array(
    'connectionString' => 'mysql:host=10.18.9.174;dbname=alfa_scorpi_db',
	'emulatePrepare' => true,
	'username' => 'perseus',
	'password' => 'meissa688',
	'charset' => 'utf8',
    'enableProfiling' => true,
    ),
    'log'=>array(
    'class'=>'CLogRouter',
    'routes'=>array(
    array(
    'class'=>'CFileLogRoute',
    'logFile'=>'cron.log',
    'levels'=>'error, warning',
    ),
    array(
    'class'=>'CFileLogRoute',
    'logFile'=>'cron_trace.log',
    'levels'=>'trace',
    ),
    ),
    ),
    'functions'=>array(
    'class'=>'application.extensions.functions.Functions',
    ),
    ),
    );