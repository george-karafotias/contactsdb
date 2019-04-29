<?php
include_once("connect.php");

$sql = "UPDATE Users SET SessionID=NULL WHERE UserID=".$_SESSION['user']['UserID'].";";
$result = $conn->query($sql);
if ($result) {
	unset($_SESSION['user']);
	session_destroy();
	redirectToLoginPage($ROOT);
} else {
	redirectToHomePage($ROOT);
}
?>