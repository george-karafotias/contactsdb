<?php
include_once("connect.php");

$contactID = "";
if (isset($_GET['id'])) {
	$contactID = $_GET['id'];
}
if (empty($contactID)) {
	redirectToHomePage($ROOT);
	exit;
}

$returnUrl = "";
if (isset($_GET['returnUrl'])) {
	$returnUrl = $_GET['returnUrl'];
}

$contact = getContact($conn, $contactID);
if (empty($contact)) {
	redirectToHomePage($ROOT);
	exit;
}

$errors = "";

if (!empty($_POST)) {
	$returnUrl = $_POST['returnUrl'];
	
	$contact['FirstName'] = sanitizeInput($_POST['firstName']);
	$contact['LastName'] = sanitizeInput($_POST['lastName']);
	$contact['Title'] = sanitizeInput($_POST['title']);
	if ($_POST['gender'] == 'N') 
		$contact['Gender'] = 0;
	else if ($_POST['gender'] == 'M')
		$contact['Gender'] = 1;
	else 
		$contact['Gender'] = 2;
	$contact['Phone'] = sanitizeInput($_POST['phone']);
	$contact['MobilePhone'] = sanitizeInput($_POST['mobilePhone']);
	$contact['Email'] = sanitizeInput($_POST['email']);
	$contact['Address'] = sanitizeInput($_POST['address']);
	$contact['PostalCode'] = sanitizeInput($_POST['postalCode']);
	$contact['Dob'] = sanitizeInput($_POST['dob']);
	$contact['Comments'] = sanitizeInput($_POST['comments']);
	
	$validPost = false;
	if (empty($contact['Title'])) {
		if (empty($contact['FirstName']) || empty($contact['FirstName'])) {
			$errors = "Please fill in first name and last name.";
		} else {
			$validPost = true;
		}
	} else {
		$validPost = true;
	}
	
	if ($validPost) {
		$sql = "UPDATE Contacts SET FirstName='".$contact['FirstName']."',LastName='".$contact['LastName']."',Title='".$contact['Title']."',Gender=".$contact['Gender'].",Phone='".$contact['Phone']."',MobilePhone='".$contact['MobilePhone']."',Email='".$contact['Email']."',Address='".$contact['Address']."',PostalCode='".$contact['PostalCode']."',Dob='".$contact['Dob']."',Comments='".$contact['Comments']."' WHERE ContactID=".$contactID.";";
		
		if ($conn->query($sql) === TRUE) {
			if (!empty($returnUrl)) {
				header('Location:'.$returnUrl);
			} else {
				header('Location:contacts.php');
			}
		} else {
			$errors = "Failed to save the contact with error:".$conn->error;
		}
	}
}
?>
<!DOCTYPE html>
<html>
	<head>
	<title><?php echo getContactDisplayName($contact); ?></title>
	<?php include('../bootstrap.php'); ?>
	</head>
	<body>
	<?php include('../header.php'); ?>
	<h2><?php echo getContactDisplayName($contact); ?></h2>
		
	<?php if (!empty($errors)) { ?>
	<div class="errorMsg"><?php echo $errors; ?></div>
	<?php } ?>
	
	<form action="editContact.php?id=<?php echo $contactID; ?>" method="post" class="frm">
		<div class="form-group">
			<label for="firstName">First Name: <span class="required">*</span></label><input type="text" class="form-control" id="firstName" name="firstName" autocomplete="off" autofocus value="<?php echo $contact['FirstName']; ?>">
		</div>
		<div class="form-group">
			<label for="lastName">Last Name: <span class="required">*</span></label><input type="text" class="form-control" id="lastName" name="lastName" autocomplete="off" autofocus value="<?php echo $contact['LastName']; ?>">
		</div>
		<div class="form-group">
			<label for="title">Title: <span class="required">*</span></label><input type="text" class="form-control" id="title" name="title" autocomplete="off" autofocus value="<?php echo $contact['Title']; ?>">
		</div>
		<div class="form-group">
			<label for="gender">Gender:</label>
			<select class="form-control" id="gender" name="gender">
				<option value="N" <?php if ($contact['Gender'] == 0) echo 'selected="selected"' ?>>Select</option>
				<option value="M" <?php if ($contact['Gender'] == 1) echo 'selected="selected"' ?>>Man</option>
				<option value="F" <?php if ($contact['Gender'] == 2) echo 'selected="selected"' ?>>Woman</option>
			</select>
		</div>
		<div class="form-group">
			<label for="phone">Phone:</label><input type="text" class="form-control" id="phone" name="phone" autocomplete="off" autofocus value="<?php echo $contact['Phone']; ?>">
		</div>
		<div class="form-group">
			<label for="mobilePhone">Mobile Phone:</label><input type="text" class="form-control" id="mobilePhone" name="mobilePhone" autocomplete="off" autofocus value="<?php echo $contact['MobilePhone']; ?>">
		</div>
		<div class="form-group">
			<label for="email">Email:</label><input type="email" class="form-control" id="email" name="email" autocomplete="off" autofocus value="<?php echo $contact['Email']; ?>">
		</div>
		<div class="form-group">
			<label for="address">Address:</label><input type="text" class="form-control" id="address" name="address" autocomplete="off" autofocus value="<?php echo $contact['Address']; ?>">
		</div>
		<div class="form-group">
			<label for="postalCode">Postal Code:</label><input type="text" class="form-control" id="postalCode" name="postalCode" autocomplete="off" autofocus value="<?php echo $contact['PostalCode']; ?>">
		</div>
		<div class="form-group">
			<label for="dob">Date of birth:</label><input type="date" class="form-control" id="dob" name="dob" autocomplete="off" autofocus value="<?php echo $contact['Dob']; ?>">
		</div>
		<div class="form-group">
			<label for="comments">Σχόλια:</label><textarea class="form-control" rows="5" id="comments" name="comments" autocomplete="off"><?php echo $contact['Comments']; ?></textarea>
		</div>
		
		<input type="hidden" name="returnUrl" value="<?php echo $returnUrl; ?>" />
		
		<button type="submit" class="btn btn-primary">Save</button>
	</form>
	</body>
</html>
