<?php

/*
 * anacreon
 * A simple indexer in php
 * ©2013 Alfio Emanuele Fresta
 */


/*
 * CONFIGURATION

define('DB_STRING', 	"mysql:host=localhost;dbname=anacreon");
//define('DB_STRING',	"sqlite::memory:");
define('DB_USER',	"anacreon");
define('DB_PASSWORD',	"anacreon");

try {
        $db = new PDO(DB_STRING, DB_USER, DB_PASSWORD);
} catch ( Exception $e ) {
        echo "Database connection failed. Check configuration.\n";
	echo "Error message: {$e->getMessage()}\n";
        exit;
}
*/
$finfo = finfo_open(FILEINFO_MIME);
$count = 0;

switch ( $argv[1] ) {
	case 'index':
		index($argv[2]);
		break;
	case 'search':
		search($argv[2]);
		break;
	case 'drop':
		drop();
		break;
	default:
		help();
}

function help() {
	echo <<<HELP
Usage:
	DROP	: php ./anacreon.php drop
	INDEXING: php ./anacreon.php index <directory>
	SEARCH  : php ./anacreon.php search <string>

HELP;
	exit;
}

function drop() {
	global $db;
	//$r = (int) $db->exec("DROP TABLE anacreon_index");
	$db->track->drop();
	echo "[DROP] Done! \n";
}

function index ( $directory ) {
	global $db;
	index_setup();
	$start = time();
	echo "[START] Starting at " . date("d-m-Y H:i:s") . "\n";
	index_recursive($directory);
	$end = time(); $start = $end - $start;
	echo "[EXIT] {$start} seconds to index {$directory}\n";
}

function index_recursive ( $dir  ) {
	$h = @opendir($dir);
        if ( !$h ) { return true; }
  	      while ( $file = readdir($h) ) {
                   if ( $file[0] == "." ) { continue; }
                   index_add( $dir, $dir . DIRECTORY_SEPARATOR . $file );
                   if ( is_dir ( $dir . DIRECTORY_SEPARATOR . $file ) ) {
        	           index_recursive ($dir . DIRECTORY_SEPARATOR . $file);
                   }
              }
        closedir($h);
        return true;
}

function index_add ( $path, $file ) {
	global $db, $count;
	$count++;
	$size = (int) filesize($file);
	$mime = index_mime_type($file);
	if(is_dir($file))
	{
		return;
	}
	else
	{
		$iei    = id3_get_tag($file);
		$x 		= new track;
		foreach ($iei as $key => $value) {
			$x->{$key} = $value;
		}
		$x->file=$file;
		$x->size=$size;
		$x->mime=$mime;
	}

	/*$q = $db->prepare("
		INSERT INTO anacreon_index
			(node, path, size, mime)
		VALUES
			(:node, :path, :size, :mime)");
	$q->bindValue(":node", 	$file);
	$q->bindValue(":path",	$path);
	$q->bindValue(":size",	$size, PDO::PARAM_INT);
	$q->bindValue(":mime",	$mime);
	$r = (int) $q->execute();
	*/
	echo "[INDEX-ADD] " . sprintf("% 10d", $count) . ", status {$r}: {$file}\n";
}

function index_setup () {
	/*global $db;
	$q = $db->exec("
		CREATE TABLE anacreon_index (
			node	varchar(255)	PRIMARY KEY,
			path	varchar(255),
			size	int,
			mime	varchar(32)
		)
	");
	if ( $q ) {
		$db->exec("CREATE INDEX path_index ON anacreon_index ( path )");
		$db->exec("CREATE INDEX size_index ON anacreon_index ( size )");
		$db->exec("CREATE INDEX mime_index ON anacreon_index ( mime )");
	}
	*/
	echo "[CREATE-TABLE] Status {$q}\n";
}

function index_mime_type ( $file ) {
	global $finfo;
	if ( is_dir($file) ) {
		return NULL;
	}
	return finfo_file($finfo, $file);
}