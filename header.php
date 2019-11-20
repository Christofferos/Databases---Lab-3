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
				<div class="nav-searchbar">
					<select name="table" id="table_select">
						<option value="students">Students</option>
						<option value="administrators">Administrators</option>
						<option value="books">Books</option>
					</select>
				</div>
			</div>
		</nav>
	</header>