<?php
include_once("connect.php");

$contact = createContact();
$errors = "";
$insertedContactID = "";

if (isset($_GET['insertedContactID']) && !empty($_GET['insertedContactID'])) {
	$insertedContactID = $_GET['insertedContactID']; 
}

if (!empty($_POST)) {
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
		$stringSeparator = "','";
		$sql = "INSERT INTO Contacts(FirstName, LastName, Title, Gender, Phone, MobilePhone, Email, Address, PostalCode, Dob, Comments) VALUES('".$contact['FirstName'].$stringSeparator.$contact['LastName'].$stringSeparator.$contact['Title']."',".$contact['Gender'].",'".$contact['Phone'].$stringSeparator.$contact['MobilePhone'].$stringSeparator.$contact['Email'].$stringSeparator.$contact['Address'].$stringSeparator.$contact['PostalCode'].$stringSeparator.$contact['Dob'].$stringSeparator.$contact['Comments']."');";
		
		if ($conn->query($sql) === TRUE) {
			$last_id = $conn->insert_id;
			header('Location:'.$_SERVER['REQUEST_URI']."?insertedContactID=".$last_id);
		} else {
			$errors = "Failed to save the contact with error:".$conn->error;
		}
	}
}
?>
<!DOCTYPE html>
<html>
	<head>
	<title>Add New Contact</title>
	<?php include('../bootstrap.php'); ?>
	</head>
	<body>
	<?php include('../header.php'); ?>
	<h2>Add New Contact</h2>
	
	<?php if (!empty($insertedContactID)) { ?>
	<div class="successfulMsg">Contact added. You can add a new contact.</div>
	<?php } ?>
		
	<?php if (!empty($errors)) { ?>
	<div class="errorMsg"><?php echo $errors; ?></div>
	<?php } ?>
	
	<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" class="frm">
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
		
		<button type="submit" class="btn btn-primary">Save</button>
	</form>
	</body>
</html>
