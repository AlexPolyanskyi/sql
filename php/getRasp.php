<?php
include 'connect.php';

$day = (int) $_POST['day'];
$week = (int) $_POST['week'];
$group = (int) $_POST['group'];
$r = array();
$query1 = "SELECT `day`.`Day` as `day`, `group`.`Name` as `group`, `subject`.`Name` as `subject`, `prepod`.`Name` as `prepod`,
`raspisanie`.`ParlorID` as `kabinet`, `raspisanie`.` Number_Subject_of_Day` as `number` FROM `raspisanie` INNER JOIN `group` ON `raspisanie`.`groupID` = `group`.`ID` 
INNER JOIN `day` ON `raspisanie`.`dayID` = `day`.`ID` INNER JOIN `subject` ON `raspisanie`.`SubjectID` = `subject`.`ID`
INNER JOIN `prepod` ON `raspisanie`.`PrepodID` = `prepod`.`ID`";

$result1 = $mysqli->query($query1) or die($mysqli->error);
while($row = $result1->fetch_assoc()) {
$r[] = $row;
}
echo json_encode($r);

?>