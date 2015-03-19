<?
session_start();
include 'connect.php';

$act = $_POST['act'];

if($act == 'add'){
	$day = (int) $_POST['day'];
	$week = (int) $_POST['week'];
	$para = (int) $_POST['para'];
	$subject = (int)$_POST['subject'];
	$parlor = (int) $_POST['parlor'];
	$prepod = (int) $_POST['prepod'];
	$group = (int) $_POST['group'];

	$mysqli->query("INSERT INTO `raspisanie` (`Week`, `GroupID`, `ParlorID`, `PrepodID`, `SubjectID`, `DayID`, ` Number_Subject_of_Day`) 
		VALUES ('{$week}', '{$group}', '{$parlor}', '{$prepod}', '{$subject}', '{$day}', '{$para}' )") or die("Error");
	header("Location: /login.php");
}
else if($act == "del"){
	$id = (int) $_POST['id'];
	$mysqli->query("DELETE FROM `raspisanie` WHERE id = '{$id}'") or die("Error");
	header("Location: /login.php");
}
print_r($_POST);