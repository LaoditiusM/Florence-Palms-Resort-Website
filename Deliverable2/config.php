<?php
$servername = 'localhost';
$un='laoditius';
$pd = 'P@ssword13';
$db = 'iteca';
$conn = new mysqli($servername, $un, $pd, $db);
if($conn->connect_error)
{
die("Connection failed: ".$conn->connect_error);
}
?>