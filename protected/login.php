<?php
include_once("connect.php");

if (!empty($_SESSION['user'])) {
	redirectToHomePage($ROOT);
	exit;
}

$errors = "";

if (!empty($_POST)) {
	$username = sanitizeInput($_POST['uname']);
	$password = sanitizeInput($_POST['psw']);
	if (empty($username) || empty($password)) {
		$errors = "Please fill in both the username and password.";
	} else {
		$sql1 = "SELECT * FROM Users WHERE UserName='".$username."' AND Password='".md5($password)."';";
		$result1 = $conn->query($sql1);
		
		if ($result1) {
			if ($result1->num_rows > 0) {
				$user = $result1->fetch_assoc();
				$sql2 = "UPDATE Users SET SessionID='".session_id()."' WHERE UserID=".$user['UserID'].";";
				$result2 = $conn->query($sql2);
				if ($result2) {
					redirectToHomePage($ROOT);
					exit;
				} else {
					$errors = "An unexpected error occured. Plese try again.";
				}
			} else {
				$errors = "Wrong username or password.";
			}
		} else {
			$errors = "The following error occured:".$conn->error;
		}
	}
}
?>
<!DOCTYPE html>
<html>
	<head>
	<title>Login Page</title>
	<?php include('../bootstrap.php'); ?>
	<style>
		body {font-family: Arial, Helvetica, sans-serif;}
		form {border: 3px solid #f1f1f1;}
		input[type=text], input[type=password] {
		  width: 100%;
		  padding: 12px 20px;
		  margin: 8px 0;
		  display: inline-block;
		  border: 1px solid #ccc;
		  box-sizing: border-box;
		}
		button {
		  background-color: #4CAF50;
		  color: white;
		  padding: 14px 20px;
		  margin: 8px 0;
		  border: none;
		  cursor: pointer;
		  width: 100%;
		}
		button:hover {
		  opacity: 0.8;
		}
		.imgcontainer {
		  text-align: center;
		  margin: 24px 0 12px 0;
		}
		.container {
		  padding: 16px;
		}
		span.psw {
		  float: right;
		  padding-top: 16px;
		}
	</style>
	</head>
	<body>
		<nav class="navbar navbar-inverse">
			<div class="container-fluid">
				<div class="navbar-header" style="min-height:100px">
					<div class="navbar-brand"><img src="<?php echo $ROOT; ?>/imgs/logo.png" /></div>
				</div>
			</div>
		</nav>
		<h2>Please login to continue</h2>
		
		<?php if (!empty($errors)) { ?><p class="errorMsg"><?php echo $errors; ?></p><?php } ?>
		
		<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
			<input type="text" name="prevent_autofill" id="prevent_autofill" value="" style="display:none;" />
			<input type="password" name="password_fake" id="password_fake" value="" style="display:none;" />
			
			<div class="container">		
				<label for="uname"><b>Username</b></label>
				<input type="text" placeholder="Enter Username" name="uname" required autocomplete="off" autofocus>
				<label for="psw"><b>Password</b></label>
				<input type="password" placeholder="Enter Password" name="psw" required autocomplete="new-password">
				<button type="submit">Login</button>
			</div>
		</form>
	</body>
</html>