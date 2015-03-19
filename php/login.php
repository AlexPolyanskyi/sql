<?php
session_start();
include 'connect.php';

if(($_POST['pass'] != "admin") && ($_POST['log'] != "admin") && ($_SESSION['login'] != "active")){
	if (!isset($_SESSION['login']) && !isset($_SESSION['user'])) {
		unset($_SESSION['login']);
		unset($_SESSION['user']);
	}
	echo"Неверный логин или пароль";
}
else{
	if($_POST['log']) {	
		$_SESSION['user'] = $_POST['log']; 
	}
	
	if (!isset($_SESSION['login'])) {
		$_SESSION['login'] = "active";	
	}
	
	echo"<form action='index.php' method='post'>
			<div style='padding: 10px'> 
				<div align='left' style='padding: 3px'>
				Здаравствуйте ".$_SESSION['user']."! Здесь вы можете внести изменения в расписание.
				</div>
				<div align='left' style='padding: 3px'>
				<input type='submit' value='В главное меню'>
				</div> 
		</form>
		<form action='index.php' method='post'>
				<input type='hidden' name='logout' value='logout' visible='gone'>
				<div align='right'>
				Так же вы можете выйти отсюда <input type='submit' value='Выход'>
				</div>
			</div>
		</form>";
	$query="SELECT `id`, `day` FROM `day`";
	$result=$mysqli->query($query) or die("Gruppy");

	echo'<form action="action.php" method="post"><div style="padding: 10px"><div align="center"> День <select name="day">';
	
	while($r = $result->fetch_assoc()) {
    	echo '<option value="'.$r['id'].'">'.$r['day'].'</option>';
    }
	echo '</select>';
		
	echo ' Неделя <select name="week"><option value="1">Нечетная</option><option value="2">Четная</option> <option>Любая</option></select>';
	
	$query="SELECT `id`, `name` FROM `group`";
	$result=$mysqli->query($query) or die("Gruppy");
		
	echo' Группа <select name="group">';

	while($r = $result->fetch_assoc()) {
    	echo '<option value="'.$r['id'].'">'.$r['name'].'</option>';
    }

	echo'</select>'; 
	echo' Номер пары <select name="para"><option value="0">0</option><option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option><option value="6">6</option><option value="7">7</option></select>';
	
	$query="SELECT `id`, `name` FROM `subject`";
	$result=$mysqli->query($query) or die("Gruppy");
	echo' Предмет <select name="subject">';
	
	while($r = $result->fetch_assoc()) {
    	echo '<option value="'.$r['id'].'">'.$r['name'].'</option>';
    }

	echo'</select>';
		
	$query="SELECT `id`, `name` FROM `parlor`";
	$result=$mysqli->query($query) or die("Gruppy");
	echo' Кабинет <select name="parlor">';
		
	while($r = $result->fetch_assoc()) {
    	echo '<option value="'.$r['id'].'">'.$r['name'].'</option>';
    }
			
	echo'</select>';
	
	$query="SELECT `id`, `name` FROM `prepod`";
	$result=$mysqli->query($query) or die("Gruppy");
	echo' Преподаватель <select name="prepod">';						
	
	while($r = $result->fetch_assoc()) {
    	echo '<option value="'.$r['id'].'">'.$r['name'].'</option>';
    }
	
	echo'</select></div><div align="center" style="padding: 10px"><input type="submit" name="send" value="Добавить"></div></div><input type="hidden" name="act" value="add"></form>';

$query1 = "SELECT `raspisanie`.`ID` as `id`, `day`.`Day` as `day`, `group`.`Name` as `group`, `subject`.`Name` as `subject`, `prepod`.`Name` as `prepod`,
`raspisanie`.`ParlorID` as `kabinet`, `raspisanie`.` Number_Subject_of_Day` as `numDay`, `raspisanie`.`Week` as `Week` 
FROM `raspisanie` 
INNER JOIN `group` ON `raspisanie`.`groupID` = `group`.`ID` 
INNER JOIN `day` ON `raspisanie`.`dayID` = `day`.`ID` INNER JOIN `subject` ON `raspisanie`.`SubjectID` = `subject`.`ID`
INNER JOIN `prepod` ON `raspisanie`.`PrepodID` = `prepod`.`ID` ORDER BY  `raspisanie`.` Number_Subject_of_Day` ASC";
	
echo' <div>
	<table border=2 align=center>
		<tr>
			<td>День недели</td>
			<td>Неделя</td>
			<td>Группа</td>
			<td>Номер пары</td>
			<td>Предмет</td>
			<td>Кабинет</td>
			<td>Преподаватель</td>
		</tr>';
	$result1 = $mysqli->query($query1) or die($mysqli->error);
	while($row = $result1->fetch_assoc()) {
    		echo '<tr>
			<td>'.$row['day'].'</td>
			<td>'.$row['Week'].'</td>
			<td>'.$row['group'].'</td>
			<td>'.$row['numDay'].'</td>
			<td>'.$row['subject'].'</td>
			<td>'.$row['kabinet'].'</td>
			<td>'.$row['prepod'].'</td>
			<td>    
				<form action="action.php" method="post">
					<input type="hidden" name="act" value="del">
					<input type="hidden" name="id" value="'.$row['id'].'">
					<input type="submit" name="send" value="Удалить">
				</form>
			</td>
			<tr>';
	}
echo'</table></div></form>';	
}
?>