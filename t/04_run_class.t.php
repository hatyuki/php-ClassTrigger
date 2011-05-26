#!/usr/bin/env php
<?php
require_once dirname(__FILE__).'/lib/setup.php';
require_once 'Test.php';
require_once 'Other.php';

function finalize ( )
{
    ClassTrigger::clear_trigger( );
}

function run_class ($t)
{
    $obj = new TestClass( );

    $r = $obj->run_hook(2);
    $t->is($r, 2);

    $obj->register_hook( );
    $r = $obj->run_hook(2);
    $t->is($r, 7);

    $obj->clear_hook( );
}

function other_class ($t)
{
    $obj   = new TestClass( );
    $other = new OtherClass( );
    $obj->register_hook( );
    $other->register_hook( );

    $r = $obj->run_hook(3);
    $t->is($r, 13.5);

    $obj->clear_hook( );
    $other->clear_hook( );
}

function ref_other_class ($t)
{
    $obj   = new TestClass( );
    $other = new OtherClass( );

    $obj->other = $other;

    $obj->register_hook( );
    $obj->other->register_hook( );

    $r = $obj->run_hook(4);
    $t->is($r, 22);

    $obj->clear_hook( );
    $other->clear_hook( );
}

done_testing( );
