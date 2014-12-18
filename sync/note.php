<?php


define("BAIKAL_CONTEXT", TRUE);
define("PROJECT_CONTEXT_BASEURI", "/");

if(file_exists(getcwd() . "/Core")) {
	# Flat FTP mode
	define("PROJECT_PATH_ROOT", getcwd() . "/");	#./
} else {
	# Dedicated server mode
	define("PROJECT_PATH_ROOT", dirname(getcwd()) . "/");	#../
}

if(!file_exists(PROJECT_PATH_ROOT . 'vendor/')) {
	die('<h1>Incomplete installation</h1><p>Ba&iuml;kal dependencies have not been installed. Please, execute "<strong>composer install</strong>" in the folder where you installed Ba&iuml;kal.');
}

require PROJECT_PATH_ROOT . 'vendor/autoload.php';

# Bootstraping Flake
\Flake\Framework::bootstrap();

# Bootstrapping Baïkal
\Baikal\Framework::bootstrap();

$noteBackend = new \Sabre\DAV\CustomExt\NoteExt\PDO($GLOBALS["DB"]->getPDO());

$rootNode = new \Sabre\DAV\CustomExt\NoteExt\Note($noteBackend);  

$server = new \Sabre\DAV\Server($rootNode);

$server->setBaseUri('/sync/note/');

$server->addPlugin(new \Sabre\DAV\CustomExt\NoteExt\Plugin());

$server->exec();

?>
