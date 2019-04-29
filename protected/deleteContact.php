<?php
require_once('connect.php');

if (!isset($_GET['id'])) {
	redirectToHomePage($ROOT);
	exit;
}
$contactID = $_GET['id'];

$returnUrl = '';
if (isset($_GET['returlUrl'])) {
	$returnUrl = $_GET['returnUrl'];
}

$errors = '';
if (!empty($_POST)) {
	$returnUrl = $_POST['returnUrl'];
	
	$sql = "DELETE FROM Contacts WHERE ContactID=".$contactID.";";
	if ($conn->query($sql) === TRUE) {
		if (!empty($returnUrl))
			header("Location:".$returnUrl);
		else
			header("Location:contacts.php");
	} else {
		$errors = "Deletion failed with the following error:".$conn->error;
	}
	exit;
}

$contact = getContact($conn, $contactID);
if (empty($contact)) {
	redirectToHomePage($ROOT);
	exit;
}
?>
<!DOCTYPE html>
<html>
	<head>
	<?php include('../bootstrap.php'); ?>
	</head>
	<body>
	<?php include('../header.php'); ?>
	<h2 class="title">Delete contact <?php echo getcontactDisplayName($contact); ?></h2>
	
	<?php if (!empty($errors)) { ?>
	<div class="errorEntry"><?php echo $errors; ?></div>
	<?php } ?>
	
	<form method="post" action="deletecontact.php?id=<?php echo $contactID; ?>">
		<p>You are about to delete contact <b><?php echo getcontactDisplayName($contact); ?></b>. If you are sure about the deletion, press the button Confirm. If you want to cancel deletion, press the button Cancel.</p>
		
		<input type="hidden" name="returnUrl" value="<?php echo $returnUrl; ?>" />
		
		<button type="button" class="btn btn-primary submitBtn" onclick="goBack()">Cancel</button>
		<button id="submitBtn" type="submit" class="btn btn-danger submitBtn">Confirm</button>
	</form>
	
	<script>
	function goBack() {
		window.history.back();
	}
	</script>
	</body>
</html>