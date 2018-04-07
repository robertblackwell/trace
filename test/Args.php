<?php
require_once(dirname(__FILE__)."/header.php");

Trace::disable();

class ArgsTests extends PHPUnit_Framework_TestCase{
	function setUp(){
	    Trace::enable();
	}
	function pass_int($i){
	    Trace::function_entry();
	}
	function pass_string($s){
	    Trace::function_entry();
	}
	function pass_array($a){
	    Trace::function_entry();
	}
	function pass_object($o){
	    Trace::function_entry();
	}
	function pass_many($i, $s, $a, $o){
	    Trace::function_entry();
	}
	
	function testTest1(){
        $this->pass_int(33);
        $this->pass_string("thisisastring");
        $this->pass_array(array(33,"a string", "key"=>"value"));
        $o = new stdClass(); $o->val= "apropoerty";
        $this->pass_object(new stdClass());
        $this->pass_object($this);	    
        $this->pass_many(33, "thisisastring",array(33,"a string", "key"=>"value"), $this);	    
	}
}

?>