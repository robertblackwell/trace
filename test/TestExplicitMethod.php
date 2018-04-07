<?php
require_once(dirname(__FILE__)."/header.php");

Trace::disable();

class TestExplicitMethod extends  PHPUnit_Framework_TestCase{
	function setUp(){
	    Trace::on(__CLASS__,'Test1');
	}
	function testOne(){
	    Trace::function_entry("the first one");
	    Trace::debug('a debug message');
	    Trace::function_exit("the second one");
	}
	function testTwo(){
	    Trace::function_entry("the first one");
	    Trace::debug('a debug message');
	    Trace::function_exit("the second one");
	}
}

?>