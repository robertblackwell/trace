<?php
require_once(dirname(__FILE__)."/header.php");

class TestClassExplicit extends  PHPUnit_Framework_TestCase{
	function setUp(){
	    Trace::on(__CLASS__);
	}
	function testOneOne(){
	    Trace::function_entry("the first one");
	    Trace::debug('a debug message');
	    Trace::function_exit("the second one");
	}
	function test12(){
	    Trace::function_entry("the first one");
	    Trace::debug('a debug message');
	    Trace::function_exit("the second one");
	}
}

?>