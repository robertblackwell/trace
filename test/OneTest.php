<?php
require_once(dirname(__FILE__)."/header.php");

Trace::off();
Trace::on("test_one", "test_1");

class TestOne extends PHPUnit_Framework_TestCase{
	function setUp(){
	}
	public static function st($aparameter){
	    Trace::function_entry();
	    $a="thevariale";
	    Trace::debug("Tried to manipulate the variable a:$a");
	    Trace::function_exit();
	}
	function test_1(){
		
	    Trace::function_entry();
	    Trace::debug("debug from test_1");
	    Trace::function_exit();
	    self::st("thisis the parameter");
	}
	function test_True(){return;
	    Trace::function_entry();
	    Trace::debug("debug from test_2");
		$this->assertTrue(false);
	    Trace::function_exit();
	}
	function test_3(){
	    Trace::function_entry();
	    //Trace::dump();
	    //Trace::disable();
	    //Trace::dump();
	    //Trace::on();
	    //Trace::dump();
	}
}
class TestOneTwo extends PHPUnit_Framework_TestCase{
		function setUp(){
		}
		public static function st($aparameter){
		    Trace::function_entry();
		    $a="thevariale";
		    Trace::debug("Tried to manipulate the variable a:$a");
		    Trace::function_exit();
		}
		function test_1(){
		
		    Trace::function_entry();
		    Trace::debug("debug from test_1");
		    Trace::function_exit();
		    self::st("thisis the parameter");
		}
		function test_True(){return;
		    Trace::function_entry();
		    Trace::debug("debug from test_2");
			$this->assertTrue(false);
		    Trace::function_exit();
		}
		function test_3(){
		    Trace::function_entry();
		    //Trace::dump();
		    //Trace::disable();
		    //Trace::dump();
		    //Trace::on();
		    //Trace::dump();
		}
	
}
?>