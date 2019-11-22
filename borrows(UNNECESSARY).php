<!--Here is some styling HTML you don't need to pay attention to-->
<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" />
<style>
.container {margin: auto; align-content: center;}
.table-fix {box-shadow: 0px 0px 5px 1px; display: table; }
</style>
</head>
<body>
<div class="container">
  <?php
  include 'header.php';
  ?>



<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
    <table class='table table-hover table-responsive table-bordered'>
        <tr>
            <td>Search</td>
            <td><input type='text' name='keyword' class='form-control' /></td>
        </tr>
    </table>
</form>

<?php

include 'connection.php'; //Init a connection

$query = "SELECT * FROM borrows WHERE (resourceid AS INTEGER) LIKE (:keyword AS INTEGER) ORDER BY dateborrow";
$stmt = $con->prepare($query);
$keyword= isset($_POST['keyword']) ? $_POST['keyword'] : ''; //Is there any data sent from the form?

$keyword = "%".$keyword."%";
$stmt->bindParam(':keyword', $keyword);

$stmt->execute();

$num = $stmt->rowCount(); //Aquire number of rows

if($num>0){ //Is there any data/rows?
    echo "<table class='table table-responsive table-fix table-bordered'><thead class='thead-light'>";
    echo "<tr>";
    echo "<th>Borrowing Date</th>"; // Rename, add or remove columns as you like.
    echo "<th>Expire Date</th>";
		echo "<th>Return Date</th>";
		echo "<th>ResourceID</th>";
		echo "<th>UserID</th>";
    echo "</tr>";
while ($rad = $stmt->fetch(PDO::FETCH_ASSOC)){ //Fetches data
    extract($rad);
    echo "<tr>";
		
		// Here is the data added to the table
    echo "<td>{$dateborrow}</td>"; //Rename, add or remove columns as you like
    echo "<td>{$dateexpire}</td>";
    echo "<td>{$datereturn}</td>";
    echo "<td>{$resourceid}</td>";
    echo "<td>{$userid}</td>";
		echo "<td>";

		//Here are the buttons for update, delete and read.
		/* echo "<a href='readBooks.php?name={$title}'class='btn btn-info m-r-1em'>Info</a>"; // Replace with ID-variable, to make the buttons work
		echo "<a href='updateBooks.php?name={$title}' class='btn btn-primary m-r-1em'>Update</a>";// Replace with ID-variable, to make the buttons work
		echo "<a href='deleteBooks.php?id={$resourceid}' class='btn btn-danger'>Delete</a>";// Replace with ID-variable, to make the buttons work */
		echo "</td>";
    echo "</tr>";
}
echo "</table>";    
}
else{
	echo "<h1> Search gave no result </h1>";
}
?>
</div>
</body>
</html>