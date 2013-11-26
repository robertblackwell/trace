<?php
/*!
** Trace class for debug print outs. Hello
**
** Can be enabled globally so that all calls to Trace:: generates output 
** Can be disabled globally so that no Trace printouts occur
** Can be enabled for a particular class or class/function combination
**
*/
class Trace{

    static $enabled = true;
    static $disabled = false; 
    static $list = array();
      
    /*!
    ** Collects the debug call stack information so we can work out who called a Trace function.
    ** It is essential that this function be called ONLY by one of
    **  -   Trace::on(), Trace::off(), Trace::alert(), Trace::debug(), Trace::error(); 
    **  -   Trace::function_entry(), Trace::function_exit();
    ** @Returns a stdClass with properties from the trace back
    */
    static function debug_info(){
        $di = debug_backtrace();
        $valid_caller_functions = array("on","off", "alert", "debug", "error", "function_entry", "function_exit");
        $caller_class = $di[1]['class'];
        $caller_function = $di[1]['function'];
        if( !(
                ($caller_class == 'Trace') && (in_array($caller_function, $valid_caller_functions))  
                )
            ) throw new \Exception(__METHOD__." called from wrong/invalid place caller is $caller_class::$caller_function"); 
//        var_dump($di[2]);exit();
        $obj = new stdClass();
        $obj->file = $di[1]['file'];
        $obj->line_number = $di[1]['line'];
        $obj->function = $di[2]['function'];
        $obj->class = (array_key_exists('class', $di[2]))? $di[2]['class'] : "*";
        $obj->type = (array_key_exists('type', $di[2]))? $di[2]['type'] : "";
        if( array_key_exists('args', $di[2]) ){
            $obj->args = "";
            foreach($di[2]['args'] as $args){
                if(is_array($args) ) 
                    $a = print_r($args, true);
                else if(is_object($args) ) 
                    $a = "Object of class:[".get_class($args)."]" ;//var_export($args, true);
                else 
                    $a = $args."";
                $obj->args .= $a.", ";
            }    
        }
//        $obj->args = (array_key_exists('args', $di[2]))? implode(',', $di[2]['args']) : "";
        $obj->backtrace = $di;        
        $obj->string = $obj->class.$obj->type.$obj->function;//."[". $file."::".$line_number."]";
        return $obj;
    }
    /*!
    ** Tests whether Trace is enabled for a given class method or non class function.
    **
    ** If $class value is not a key in the $list array Trace is not enabled
    **
    ** Trace is enabled for the $class/$function combination
    ** If $class value is a key in the $list array
    **      and 
    **    (the $function value is in the array self::$list[$class]
    **    or  the value '*' is in the array self::$list[$class])
    **
    **
    ** @param $class
    ** @param $function
    ** @returns boolean
    */
    public static function permitted($class, $function){
        if( self::$enabled ) $res = true;
        if( self::$disabled ) {
            if( 
                    array_key_exists($class, self::$list) 
                    && 
                    (   
                        in_array($function, self::$list[$class]) 
                        || 
                        in_array('*', self::$list[$class]) 
                    )
                )
                $res= true;
            else
                $res = false;
        }
        return $res;
    }
    
    /*!
    ** Turn on all Trace output
    */
    public static function enable(){
        self::$enabled = true; 
        self::$disabled=false;
    }
    /*!
    ** Turn off all Trace output
    */
    public static function disable(){
        self::$disabled = true; 
        self::$enabled = false;
    }
    /*!
    **
    */
    public static function reset(){
        self::$list = array();
    }
    /*!
    ** Enable Trace for the current class::function or function
    **
    ** @param   $class the name of a class for which Trace is to be enabled. Use $class='*' for functions
    **          that are not class methods
    **
    ** @param   $function the name of a method within the $class for which Trace is to be enabled.
    **          If null enabled Trace for all methods 
    */
    public static function on($class=null, $function=null){
        if( is_null($class) && is_null($function) ){
            $o = self::debug_info();
            $class = $o->class;
            $function = $o->function;
            $function = ($function == '__construct')? '*' : $function;
        }else if( !is_null ($class) && is_null($function) ){
            $function = '*';
        }
        if( array_key_exists($class, self::$list) ){
            self::$list[$class][] = $function;
            self::$list[$class] = array_unique(self::$list[$class]);
        }else{
            self::$list[$class] = array($function);
        } 
    }
    /*!
    ** Disables printouts for class::function
    **
    ** @param   $class the name of a class for which Trace is to be disabled. Use $class='*' for functions
    **          that are not class methods
    **
    ** @param   $function the name of a method within the $class for which Trace is to be disabled.
    **          If null enabled Trace for all methods 
    */
    public static function off($class=null, $function=null){
        if( is_null($class) && is_null($function) ){
            $o = self::debug_info();
            $class = $o->class;
            $function = $o->function;
            $function = ($function == '__construct')? '*' : $function;
        }else if( !is_null ($class) && is_null($function) ){
            $function = '*';
        }
        if( array_key_exists($class, self::$list) ){
            self::$list[$class] = array_diff(self::$list[$class], array($function));
            if( count(self::$list[$class]) == 0 ) {
                self::$list = array_diff_key(self::$list, array($class=>""));
            }
        }         
    }
    
    /*!
    ** Dumps the class variables for testing and debugging
    */
    public static function dump(){
        print "enabled : ". (int)self::$enabled ."\n";
        print "disabled : ". (int)self::$disabled ."\n";
        print_r(self::$list);
    }
    
    public static function function_entry($message=""){
        $o = self::debug_info();
        $a_str = $o->args;
        if( self::permitted($o->class, $o->function) )
            print $o->class.$o->type.$o->function."( ".$a_str." ) Entered [".$message."]\n";
    }
    public static function function_exit($message=""){
        $o = self::debug_info();
        if( self::permitted($o->class, $o->function) )
            print $o->string." Exited [".$message."]\n";
    }
    public static function alert($message){
        $o = self::debug_info();
        if( self::permitted($o->class, $o->function) )
            print $o->string." Alert ".$message."\n";
    }
    public static function debug($message){
        $o = self::debug_info();
        if( self::permitted($o->class, $o->function) )
            print $o->string." Debug ".$message."\n";
    }
    public static function error($message){
        $o = self::debug_info();
        if( self::permitted($o->class, $o->function) )
            print $o->string." Error ".$message."\n";
    }
}
?>