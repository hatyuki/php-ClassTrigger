#!/usr/bin/env php
<?php
require_once dirname(__FILE__).'/lib/setup.php';

$t->include_ok('ClassTrigger.php');
$t->can_ok('ClassTrigger', array('add_trigger', 'call_trigger', 'get_trigger', 'clear_trigger'));

done_testing( );
