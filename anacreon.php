<?php

ini_set("mongo.utf8", 0);
require("getid3/getid3.php");
$pollo = new getID3;
require("core/core.php");

$extensions = [
	'mp3', 'flac', 'ogg'
];

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
	global $db, $count, $pollo, $extensions;
	$count++;

	$extension = pathinfo($file, PATHINFO_EXTENSION);
	if (
		is_dir($file) ||
		!in_array($extension, $extensions)
	) 	{ return; } 

	$iei    = $pollo->analyze($file);
	
	getid3_lib::CopyTagsToComments($iei);

	$meta = @$iei['comments_html'];
	if ( empty($meta['title']) ) {
		return;
	}

	$size = (int) filesize($file);
	$mime = index_mime_type($file);
	$x 		= new Track;
	
	/* Fix on the year */
	if ( @strpos(@$meta['year'][0], "Z") !== false ) {
		@$meta['year'][0] = @substr(@$meta['year'][0], 0, 4);
	}

	foreach ($meta as $key => $value) {
		if ( in_array($key, ['comment', 'comments']) ) { continue; }
		try {
			$x->{$key} = @$value[0];
		} catch (MongoException $e) { }
	}

	try {
		$x->path  		= $file;
		$x->playtime 	= (int) $iei['playtime_seconds'];
	} catch (MongoException $e) {}

	foreach ($iei["audio"] as $key => $value) {
		try
		{
			$x->{$key} = $value;
		} catch (MongoException $e) { }
	}
	$x->size=$size;
	$x->mime=$mime;
	
	echo "[INDEX-ADD] " . sprintf("% 10d", $count) . ", : {$file}\n";
}

function index_mime_type ( $file ) {
	global $finfo;
	if ( is_dir($file) ) {
		return NULL;
	}
	return finfo_file($finfo, $file);
}