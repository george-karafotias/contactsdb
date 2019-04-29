<?php
session_start();

$_SESSION["user"] = [];
$ROOT = "/contacts";
$servername = "localhost";
$username = "root";
$password = "";

$conn = new mysqli($servername, $username, $password);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$conn->set_charset('utf8');
$conn->select_db('contactsdb');

$sql = "SELECT UserID, UserName, SessionID FROM Users WHERE SessionID='".session_id()."'";
$result = $conn->query($sql);
$loggedIn = false;

if ($result && $result->num_rows > 0) {
	$_SESSION["user"] = $result->fetch_assoc();
	$loggedIn = true;
} else {
	if(basename($_SERVER['PHP_SELF']) != "login.php") {  
		header("Location:".$ROOT."/protected/login.php");
		exit;  
    } 
}

function sanitizeInput($input) {
	$output = '';
	if (!empty($input)) {
		$output = trim(htmlspecialchars($input));
	}
	return $output;
}

function redirectToHomePage($ROOT) {
	header("Location:".$ROOT."/index.php");
}

function redirectToLoginPage($ROOT) {
	header("Location:".$ROOT."/protected/login.php");
}

function addToWhereClause($where, $condition) {
	if(empty($where)) {
		$where.= "(".$condition.")";
	} else {
		$where.= " OR (".$condition.")";
	}
	return $where;
}

function constructLikeClause($keyword, $fields) {
	$counter = 0;
	$likeClause = "";
	foreach($fields as $field) {
		if ($counter == 0) {
			$likeClause.= $field." LIKE '%".$keyword."%'";
		} else {
			$likeClause.= " OR ".$field." LIKE '%".$keyword."%'";
		}
		$counter++;
	}
	return $likeClause;
}

function createContact() {
	$contact = array();
	$contact['FirstName'] = '';
	$contact['LastName'] = '';
	$contact['Title'] = '';
	$contact['Gender'] = 0;
	$contact['Phone'] = '';
	$contact['MobilePhone'] = '';
	$contact['Email'] = '';
	$contact['Address'] = '';
	$contact['PostalCode'] = '';
	$contact['Dob'] = '';
	$contact['Comments'] = '';
}

function getContact($conn, $contactID) {
	$contact = array();
	if ($conn) {
		$sql = "SELECT * FROM Contacts WHERE ContactID=".$contactID.";";
		$result = $conn->query($sql);
		if ($result && $result->num_rows > 0) {
			$contact = $result->fetch_assoc();
		}
	}
	return $contact;
}

function getContacts($conn) {
	$contacts = array();
	if ($conn) {
		$sql = "SELECT * FROM Contacts;";
		$result = $conn->query($sql);
		if ($result && $result->num_rows > 0) {
			while($row = $result->fetch_assoc()) {
				$contacts[] = $row; 
			}
		}
	}
	return $contacts;
}

function searchContacts($conn, $whereClause) {
	$contacts = array();
	if ($conn) {
		$sql = "SELECT * FROM Contacts WHERE ".$whereClause;
		$result = $conn->query($sql);
		if ($result && $result->num_rows > 0) {
			while($row = $result->fetch_assoc()) {
				$contacts[] = $row; 
			}
		}
	}
	return $contacts;
}

function getContactDisplayName($contact) {
	$displayName = '';
	if (!empty($contact) && isset($contact['FirstName']) && isset($contact['LastName']) && isset($contact['Title'])) {
		if (!empty($contact['FirstName']) && !empty($contact['LastName'])) {
			$displayName = $contact['FirstName']." ".$contact['LastName'];
		} else {
			$displayName = $contact['Title'];
		}
	}
	return $displayName;
}
?>