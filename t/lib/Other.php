<?php
require_once 'ClassTrigger.php';

class OtherClass
{
    function register_hook ( )
    {
        ClassTrigger::add_trigger('trigger', array($this, 'multiply'));
        ClassTrigger::add_trigger('trigger', array($this, 'dimidiate'));
    }

    function run_hook ($i)
    {
        $retval = ClassTrigger::call_trigger('trigger', $i);
        $sum    = $i;

        foreach ($retval as $r) {
            $sum += $r;
        }

        return $sum;
    }

    function clear_hook ( )
    {
        ClassTrigger::clear_trigger('trigger');
    }

    function multiply ($i)
    {
        return $i * $i;
    }

    function dimidiate ($i)
    {
        return $i / 2;
    }
}
