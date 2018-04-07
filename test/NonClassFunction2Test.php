<?php
require_once(dirname(__FILE__)."/header.php");

function non_class_function2($one, $two){
    Trace::function_entry();
    Trace::debug("a debug message one:$one two:$two");
    Trace::function_exit();
}
class TestImpliedConstructor extends  PHPUnit_Framework_TestCase{
    function __construct(){
        //Trace::reset();
        Trace::off('*', 'non_class_function2');
        Trace::on(__CLASS__,__FUNCTION__);
        parent::__construct();
    }
	function setUp(){
	}
	/**
	*@test
	*/
	function something62(){
	    Trace::function_entry();
	    non_class_function2('111','222');
	    Trace::function_exit();
	}
}

?>