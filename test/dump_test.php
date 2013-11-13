<?php
require_once(dirname(__FILE__)."/header.php");

Trace::disable();

function non_class_function($one, $two){
    Trace::on();
    Trace::function_entry();
    Trace::debug('something happened');
    Trace::function_exit();
}
class TestDump extends UnittestCase{
	function setUp(){
	    
	}
	function Test_3(){
// 	    Trace::dump();
// 	    Trace::disable();
// 	    Trace::dump();
// 	    Trace::enable();
// 	    Trace::dump();
// 	    Trace::disable();
	    Trace::on();
	    Trace::dump();
	    $this->assertTrue(Trace::permitted(__CLASS__, __FUNCTION__));
	    $this->assertFalse(Trace::permitted(__CLASS__, "a method"));
	    //return;
	    Trace::function_entry("the first time");
	    Trace::off();
	    Trace::function_entry("the second time");
	    //Trace::dump();
	    $this->assertFalse(Trace::permitted(__CLASS__, __FUNCTION__));
	}
	function Test_4(){
	    Trace::function_entry("the first time");
	    Trace::on();
	    Trace::function_entry("the second time");
	    Trace::alert("this is an alert");
	    Trace::debug("this is a debug message");
	    Trace::error("this is an error message");
        trace::off();
	    Trace::function_entry("the second time 2");
	    Trace::alert("this is an alert 2");
	    Trace::debug("this is a debug message 2");
	    Trace::error("this is an error message 2");
	}
	function test6(){
	    non_class_function("11","22");
	}
	function test7(){
	    Trace::on(__CLASS__, 'test7');
	    Trace::function_entry();
	}
}
?>