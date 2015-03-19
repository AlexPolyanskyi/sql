<?php
session_start();
include 'connect.php';

$day = (int) $_POST['day'];
$week = (int) $_POST['week'];
$group = (int) $_POST['group'];

$query1 = "SELECT `day`.`Day` as `day`, `group`.`Name` as `group`, `subject`.`Name` as `subject`, `prepod`.`Name` as `prepod`,
`raspisanie`.`ParlorID` as `kabinet`, `raspisanie`.` Number_Subject_of_Day` as `kabinet1` FROM `raspisanie` INNER JOIN `group` ON `raspisanie`.`groupID` = `group`.`ID` 
INNER JOIN `day` ON `raspisanie`.`dayID` = `day`.`ID` INNER JOIN `subject` ON `raspisanie`.`SubjectID` = `subject`.`ID`
INNER JOIN `prepod` ON `raspisanie`.`PrepodID` = `prepod`.`ID`";

if (!empty($day)) {
	$query1 .= " AND `raspisanie`.`dayID` = {$day}";
}
if (!empty($week)) {
	$query1 .= " AND (`raspisanie`.`Week` = 0 OR `raspisanie`.`Week` = {$week}  )";
}
if (!empty($group)) {
	$query1 .= " AND `raspisanie`.`GroupID` = {$group} ";
}
$query1 .= " ORDER BY  `raspisanie`.` Number_Subject_of_Day` ASC";	

if($_SESSION['login'] == "active" && isset($_POST['logout'])){
	unset($_SESSION['login']);
}

if($_SESSION['login'] != "active"){
	echo '<form action="login.php" method="post"><div align="right" style="padding: 3px"><div style="padding: 3px">	Логин <input type="text" name="log"></div>
			<div style="padding: 3px">Пароль <input type="text" name="pass"></div><input type="submit" value="Войти"></div></form>';
}
else{
	echo'<form action="login.php" method="post"><div align="right" style="padding: 3px"><input type="submit" value="Войти"></div></form>';
}

echo'<form acrion="index.php" method="post" ><div>Неделя<select name="week"><option value="1">Нечетная</option><option value="2">Четная</option><option>Любая</option></select>День<select name="day">';


$query="SELECT `id`, `day` FROM `day`";
$result=$mysqli->query($query) or die("Gruppy");
while($r = $result->fetch_assoc()) {
    echo '<option value="'.$r['id'].'">'.$r['day'].'</option>';
}

echo '</select>';

$query="SELECT `id`, `name` FROM `group`";
$result=$mysqli->query($query) or die("Gruppy");
		
echo'Группа	<select name="group">';
while($r = $result->fetch_assoc()) {
   	echo '<option value="'.$r['id'].'">'.$r['name'].'</option>';
}


echo'</select>';
echo'<input type="submit" value="Обновить"></div>
<div><table border=2><tr><td>Пара</td><td>Предмет</td><td>Кабинет</td><td>Препод</td></tr>';

$result1 = $mysqli->query($query1) or die($mysqli->error);
while($row = $result1->fetch_assoc()) {
    echo '<tr><td>'.$row['kabinet1'].'</td><td>'.$row['subject'].'</td><td>'.$row['kabinet'].'</td><td>'.$row['prepod'].'</td><tr>';
}

echo'</table></div></form>';