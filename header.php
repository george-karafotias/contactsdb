<nav class="navbar navbar-inverse">
	<div class="container-fluid">
		<div class="navbar-header" style="min-height:100px">
			<a class="navbar-brand" href="<?php echo $ROOT; ?>/index.php"><img src="<?php echo $ROOT; ?>/imgs/logo.png"/></a>
		</div>
		<ul class="nav navbar-nav">
			<li class="active"><a href="<?php echo $ROOT; ?>/index.php">Home</a></li>
			<li class="dropdown">
				<a class="dropdown-toggle" data-toggle="dropdown" href="#">Insert<span class="caret"></span></a>
				<ul class="dropdown-menu">
					<li><a href="<?php echo $ROOT; ?>/protected/addContact.php">Contact</a></li>
				</ul>
			</li>
			<li class="dropdown">
				<a class="dropdown-toggle" data-toggle="dropdown" href="#">View<span class="caret"></span></a>
				<ul class="dropdown-menu">
					<li><a href="<?php echo $ROOT; ?>/protected/contacts.php">Contacts</a></li>
				</ul>
			</li>
			<li><a href="<?php echo $ROOT; ?>/protected/logout.php">Logout</a></li>
		</ul>
	</div>
</nav>