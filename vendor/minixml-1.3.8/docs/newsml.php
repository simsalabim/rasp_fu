<?php

/* This little test demonstrates the use of fromFile() 
** mainly so you can play with the MINIXML_USEFROMFILECACHING
** option.  For the moment, file caching is hardly usefull
** but this may change if we implement an XSLT interface.
*/


// xdebug_start_profiling();
header('Content-type: text/plain');

require_once('minixml.inc.php');

$xmlDoc = new MiniXMLDoc();
 
$xmlDoc->fromFile('./newsmltest.xml');

// xdebug_dump_function_profile(XDEBUG_PROFILER_FS_NC);
// xdebug_dump_function_profile();
// xdebug_dump_function_trace();
// xdebug_dump_function_trace();
print $xmlDoc->toString();

?>
