<?php

// This is the database connection configuration.
return array(
	'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
	// uncomment the following lines to use a MySQL database
	
	'connectionString' => 'mysql:host=localhost;dbname=alfa_scorpi_db',
	'emulatePrepare' => true,
	'username' => 'root',
	'password' => '',
	'charset' => 'utf8',
	/* 
	'connectionString' => 'mysql:host=10.18.9.174;dbname=alfa_scorpi_db',
	'emulatePrepare' => true,
	'username' => 'perseus',
	'password' => 'meissa688',
	'charset' => 'utf8',
	 */
);