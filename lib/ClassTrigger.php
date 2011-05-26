<?php

class ClassTrigger
{
    const VERSION = 0.001;

    static protected $triggers = array( );

    static protected function get_package ( )
    {
        $backtrace = debug_backtrace( );
        return isset($backtrace[2]['class']) ? $backtrace[2]['class'] : 'GLOBALS';
    }

    static function add_trigger ($trigger_point, $callback=null, $abortable=false)
    {
        if ( is_array($trigger_point) ) {
            $callback      = $trigger_point['callback'];
            $abortable     = $trigger_point['abortable'];
            $trigger_point = $trigger_point['name'];
        }

        if ( !is_callable($callback) ) {
            trigger_error('argument `callback` is not callable function', E_USER_ERROR);
        }

        $pkg = self::get_package( );

        self::$triggers[$pkg][$trigger_point][ ] = array(
            'callback'  => $callback,
            'abortable' => $abortable,
        );
    }

    static function call_trigger ($trigger_point)
    {
        $pkg  = self::get_package( );
        $args = func_get_args( );
        array_shift($args);

        if ( !isset(self::$triggers[$pkg][$trigger_point]) ) {
            return array( );
        }

        $retval = array( );
        foreach (self::$triggers[$pkg][$trigger_point] as $trigger) {
            $callback  = $trigger['callback'];
            $abortable = $trigger['abortable'];

            $ret = call_user_func_array($callback, $args);
            $retval[ ] = $ret;

            if ( empty($ret) && $abortable ) {
                return $retval;
            }
        }

        return $retval;
    }

    static function get_trigger ($trigger_point=null)
    {
        $pkg  = self::get_package( );

        if ( isset($trigger_point) ) {
            return isset(self::$triggers[$pkg][$trigger_point])
                ? self::$triggers[$pkg][$trigger_point]
                : array( );
        }
        else {
            return self::$triggers[$pkg];
        }
    }

    static function clear_trigger ($trigger_point=null)
    {
        $pkg  = self::get_package( );

        if ( isset($trigger_point) ) {
            if ( isset(self::$triggers[$pkg][$trigger_point]) ) {
                self::$triggers[$pkg][$trigger_point] = array( );
            }
        }
        else {
            self::$triggers[$pkg] = array( );
        }
    }
}
