<?php
	session_start();
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="description" content="This is an example of a meta description">
		<meta name=viewport content="width=device-width, initial-scale=1">
		
		<title></title>
		<link rel="stylesheet" type="text/css" href="css/style.css">
	</head>

	<header>
		<nav>
			<div class="header-wrapper">
				<ul>
					<li><a class="button-test" href="#"><b>STUDENTS</b></a></li>
					<li><a class="button-test" href="#"><b>ADMINISTRATORS</b></a></li>
				</ul>
				<div class="nav-login">
					<?php
						if (isset($_SESSION['u_id'])) {

							echo '<form><p style="margin: 7.5px 20px 10px 10px "><b>' . $_SESSION["u_uid"] . '    ' . '</b></p></form>';
						

							echo '<form action="dbh/logout.inc.php" method="POST">
								<button type="submit" name="submit">Logout</button>
							</form>';

						} else {
							echo '
							<form action="dbh/login.inc.php" method="POST">
							<input type="text" name="uid" placeholder="Username">
							<input type="password" name="pwd" placeholder="Password">
							<button class="button-test" type="submit" name="submit">Login/Signup</button>
							</form>';
						}
					?>
				</div>
			</div>
		</nav>
	</header>