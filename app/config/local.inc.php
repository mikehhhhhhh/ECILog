<?php


/** Paths **/
$_rootPath = '/home/mike/www/ECILog/';
$_localConfig = array();
$_localConfig['paths']		=	array(
											'root'				=>	$_rootPath,
											'app'				=>	$_rootPath .'app/',
											'html'				=>	$_rootPath .'www/',
											'templates'			=>	$_rootPath .'app/templates/'
									);


/* Location of router config ini */
$_localConfig['router_ini']	=			$_localConfig['paths']['app'] .'config/routes.ini';

/** Database Connection **/

$_localConfig['db'] 		=	array(
											'host'				=>	'localhost',
											'user'				=>	'root',
											'pass'				=>	'root',
											'database'			=>	'ecilog'
									);

/** Memcache Connection **/

$_localConfig['memcache']	=	array(
											'host'				=>	'localhost',
											'port'				=>	'11211'
									);

