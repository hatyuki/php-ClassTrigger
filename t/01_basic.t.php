#!/usr/bin/env php
<?php
require_once dirname(__FILE__).'/lib/setup.php';
require_once 'ClassTrigger.php';

function finalize ( )
{
    ClassTrigger::clear_trigger( );
}

function add_function ($t)
{
    ClassTrigger::add_trigger('multiply', '_multiply');

    $triggers = ClassTrigger::get_trigger('multiply');
    $t->is(count($triggers), 1);
    $t->ok( is_callable($triggers[0]['callback']) );

    $retval = ClassTrigger::call_trigger('multiply', 2);
    $t->is(count($retval), 1);
    $t->is($retval[0], 4);

    $retval = ClassTrigger::call_trigger('multiply', 3);
    $t->is(count($retval), 1);
    $t->is($retval[0], 9);

    ClassTrigger::clear_trigger('multiply');
    $triggers = ClassTrigger::get_trigger('multiply');
    $t->is(count($triggers), 0);
}

function _multiply ($i)
{
    return $i * $i;
}

function add_closure ($t)
{
    if (version_compare(PHP_VERSION, '5.3.0') < 0) {
        $t->skip('test requires PHP 5.0.0 or later');
        return;
    }

    ClassTrigger::add_trigger('dimidiate', function ($i) { return $i / 2; });

    $triggers = ClassTrigger::get_trigger('dimidiate');
    $t->is(count($triggers), 1);
    $t->ok( is_callable($triggers[0]['callback']) );

    $retval = ClassTrigger::call_trigger('dimidiate', 2);
    $t->is(count($retval), 1);
    $t->is($retval[0], 1);

    $retval = ClassTrigger::call_trigger('dimidiate', 3);
    $t->is(count($retval), 1);
    $t->is($retval[0], 1.5);

    ClassTrigger::clear_trigger('dimidiate');
    $triggers = ClassTrigger::get_trigger('dimidiate');
    $t->is(count($triggers), 0);
}

done_testing( );
