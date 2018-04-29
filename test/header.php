<?php
include_once dirname(dirname(__FILE__)).'/vendor/autoload.php';
//require_once( dirname(dirname(__FILE__)).'/vendor/simpletest/simpletest/autorun.php');

/**
* Makes a file name equal to the file path of the calling file but
* with the extension changed to ".tlog";
*/
function mk_trace_file($path)
{
	$f = new \SplFileInfo($path);
	$p = $f->getPath();
	$n = $f->getBasename();
	$r = $p ."/". $n . ".tlog";
	return $r;
}

?>