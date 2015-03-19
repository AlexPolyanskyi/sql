<?php
header("Content-Type: text/html; charset=cp1251");
$mysqli = new mysqli('127.0.0.1', 'root', '', 'schedule');
$mysqli->set_charset("cp1251");
$mysqli->query("set character_set_results='cp1251'");
?>