<?php
require_once('/usr/local/simpletest/autorun.php');
print get_include_path()."\n";

require_once(dirname(dirname(__FILE__))."/vendor/Autoloader.php");
$loader = new \Autoloader\loader(dirname(dirname(dirname(__FILE__)))."/src");

?>