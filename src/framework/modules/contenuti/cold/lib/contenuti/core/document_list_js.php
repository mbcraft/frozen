<?php // this must be the very first line in your PHP file!
/* This software is released under the BSD license. Full text at project root -> license.txt */

require_once("../../../framework/init.php");
require_once("framework/core/lib/controller/AbstractController.class.php");

DB::openDefaultConnection();
// You can't simply echo everything right away because we need to set some headers first!
$output = ''; // Here we buffer the JavaScript code we want to send to the browser.
$delimiter = "\n"; // for eye candy... code gets new lines

$output .= 'var tinyMCEFileList = new Array(';

$all_documenti = call("documenti","index",array("__filter_folder__EQUAL" => $_GET["folder"]));

$server_path = "http://".Host::current();

// Since TinyMCE3.x you need absolute image paths in the list...
if (count($all_documenti)>0)
{
    foreach ($all_documenti as $doc)
    {
        $output .= $delimiter
        . '["'
        . utf8_encode($doc["nome"])
        . '", "'
        . utf8_encode($server_path.$doc["save_folder"].$doc["hash_name"])
        . '"],';
    }

    $output = substr($output, 0, -1); // remove last comma from array item list (breaks some browsers)
}
$output .= $delimiter;

DB::closeConnection();

// Finish code: end of array definition. Now we have the JavaScript code ready!
$output .= ');';

// Make output a real JavaScript file!
header('Content-type: text/javascript'); // browser will now recognize the file as a valid JS file

// prevent browser from caching
header('pragma: no-cache');
header('expires: 0'); // i.e. contents have already expired

// Now we can send data to the browser because all headers have been set!
echo $output;

?>