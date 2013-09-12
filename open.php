<?php

require("core/core.php");

$id = $_GET['id'];
$x = Track::object($id);

header("Content-Type: {$x->mime}");
header("Content-Description: File Transfer");
header("Content-lenght: {$x->size}");
readfile($x->path);
