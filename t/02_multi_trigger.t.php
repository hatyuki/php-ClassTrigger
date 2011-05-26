#!/usr/bin/env php
<?php
require_once dirname(__FILE__).'/lib/setup.php';
require_once 'ClassTrigger.php';

function finalize ( )
{
    ClassTrigger::clear_trigger( );
}

function add_multi_trigger ($t)
{
    ClassTrigger::add_trigger('multi_trigger', '_multiply');
    ClassTrigger::add_trigger('multi_trigger', '_dimidiate');

    $triggers = ClassTrigger::get_trigger('multi_trigger');
    $t->is(count($triggers), 2);
    $t->ok( is_callable($triggers[0]['callback']) );
    $t->ok( is_callable($triggers[1]['callback']) );

    $retval = ClassTrigger::call_trigger('multi_trigger', 2);
    $t->is(count($retval), 2);
    $t->is($retval[0], 4);
    $t->is($retval[1], 1);

    ClassTrigger::clear_trigger('multi_trigger');
    $triggers = ClassTrigger::get_trigger('multi_trigger');
    $t->is(count($triggers), 0);
}

function _multiply ($i)
{
    return $i * $i;
}

function _dimidiate ($i)
{
    return $i / 2;
}

done_testing( );
