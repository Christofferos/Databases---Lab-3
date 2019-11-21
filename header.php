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
					
				</div>
				<select>
					<option value="users"></option>
					<option value="administrators"></option>
					<option value="students"></option>
					<option value="resources"></option>
					<option value="books"></option>
					<option value="borrows"></option>
					<option value="fines"></option>
				</select>
			</div>
		</nav>
	</header>