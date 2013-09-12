<?php

require("core/core.php");

$id = $_GET['id'];
$x = Track::object($id);

header("Content-Type: {$x->mime}");
header("Content-Description: File Transfer");
header("Content-lenght: {$x->size}");
if ( !empty($_GET['download']) ) {
	header("Content-Disposition: attachment; filename=\"{$x->title}.{$x->dataformat}\"");
}
readfile($x->path);
