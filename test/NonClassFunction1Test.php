<?php
require_once(dirname(__FILE__)."/header.php");

function non_class_function($one, $two){
    Trace::function_entry();
    Trace::debug("a debug message one:$one two:$two");
    Trace::function_exit();
}
class TestExplicitFunctionX extends  PHPUnit_Framework_TestCase{
	function setUp(){
		Trace::on("*",'non_class_function');
	}
	function test52(){
	    Trace::function_entry();
	    non_class_function('111','222');
	    Trace::function_exit();
	}
}


?>