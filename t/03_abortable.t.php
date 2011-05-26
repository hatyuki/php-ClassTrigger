#!/usr/bin/env php
<?php
require_once dirname(__FILE__).'/lib/setup.php';
require_once 'ClassTrigger.php';

function finalize ( )
{
    ClassTrigger::clear_trigger( );
}

function abortable ($t)
{
    ClassTrigger::add_trigger('trigger', '_exec', false);
    ClassTrigger::add_trigger('trigger', '_abort', true);
    ClassTrigger::add_trigger('trigger', '_not_exec', false);

    $triggers = ClassTrigger::get_trigger('trigger');
    $t->is(count($triggers), 3);

    $retval = ClassTrigger::call_trigger('trigger', 2);
    $t->is(count($retval), 2);
    $t->is($retval[0], 4);
    $t->is($retval[1], false);
}

function not_abort ($t)
{
    ClassTrigger::add_trigger('trigger', '_exec');
    ClassTrigger::add_trigger('trigger', '_abort');
    ClassTrigger::add_trigger('trigger', '_not_exec');

    $triggers = ClassTrigger::get_trigger('trigger');
    $t->is(count($triggers), 3);

    $retval = ClassTrigger::call_trigger('trigger', 2);
    $t->is(count($retval), 3);
    $t->is($retval[0], 4);
    $t->is($retval[1], false);
    $t->is($retval[2], 2);
}

function _exec ($i)
{
    return $i * 2;
}

function _abort ($i)
{
    return false;
}

function _not_exec ($i)
{
    return $i;
}

done_testing( );
