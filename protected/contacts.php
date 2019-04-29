<?php
header("Cache-Control: no-store, no-cache, must-revalidate");
require_once('connect.php');

$searchFieldText = '';
$whereClause = '';

if (!empty($_GET)) {
	if (isset($_GET['searchField'])) {
		$searchFieldText = trim($_GET['searchField']);
		if (!empty($searchFieldText)) {
			$fields = array("FirstName", "LastName", "Title", "Phone", "MobilePhone", "Email", "Address", "PostalCode", "Dob", "Comments");
			$likeClause = constructLikeClause($searchFieldText, $fields);
			$whereClause = addToWhereClause($whereClause, $likeClause);
		}
		
		if (!empty($whereClause)) {
			$contacts = searchContacts($conn, $whereClause);
		} else {
			$contacts = getContacts($conn);
		}
	}
} else {
	$contacts = getContacts($conn);
}
?>
<!DOCTYPE html>
<html>
	<head>
	<?php include('../bootstrap.php'); ?>
		<title>Contacts</title>
	</head>
	<body>
	<?php include('../header.php'); ?>
	<h2 class="title">Contacts</h2>
	
	<form class="contactsForm" method="get" action="contacts.php">
		<div class="container-fluid">
			<div class="row">
				<div class="col-xs-6" style="padding-left:0"><input type="text" class="form-control" id="searchField" name="searchField" autocomplete="off" autofocus placeholder="Enter keywords for seaching..." value="<?php echo $searchFieldText; ?>"/></div>
				<div class="col-xs-6" style="padding-right:0">
					<button type="submit" class="btn btn-primary">Search</button>
					<a href="contacts.php" class="btn btn-info">Clear</a>
				</div>
			</div>
		</div>
	</form>
	
	<?php if (!empty($contacts)) { ?>
	<div class="table-responsive">
		<div><h3>Results(<?php echo count($contacts); ?>)</h3></div>
		<table id="dataTable" class="table table-striped dataTable">
			<thead>
				<tr>
					<th style="width:90%">Contact</th>
					<th style="width:5%">Edit</th>
					<th style="width:5%">Delete</th>
				</tr>
			</thead>
			<tbody>
			<?php foreach ($contacts as $contact) { ?>
				<tr>
					<td><?php echo getContactDisplayName($contact); ?></td>
					<td><a href="editContact.php?id=<?php echo $contact['ContactID']; ?>&returnUrl=<?php echo urlencode(basename($_SERVER['REQUEST_URI'])); ?>"><button class="rowActionButton">Edit</button></td>
					<td><a href="deleteContact.php?id=<?php echo $contact['ContactID']; ?>&returnUrl=<?php echo urlencode(basename($_SERVER['REQUEST_URI'])); ?>"><button class="rowActionButton">Delete</button></td>
				</tr>
			<?php } ?>
			</tbody>
		</table>
	</div>
	<?php } else { ?>
	<div class="noResultsMsg">No results</div>
	<?php } ?>
	</body>
</html>