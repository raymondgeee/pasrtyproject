<?php
session_start();
$DBServer = 'localhost';
// $DBUser   = 'pastrypr';
$DBUser   = 'root';
$DBPass   = '';
// $DBName   = 'pastrypr_orderingdatabase';
$DBName   = 'orderingdatabase';
$db = new mysqli($DBServer, $DBUser, $DBPass, $DBName);
$db->set_charset("utf8");
// check connection
if ($db->connect_error)
{
  trigger_error('Database connection failed: '  . $db->connect_error, E_USER_ERROR);
}
?>