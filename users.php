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

<!--Styling HTML ends and the real work begins below-->

<?php


include 'connection.php'; //Init a connection

$query = "SELECT * FROM users WHERE LOWER(fullname) LIKE LOWER(:keyword) ORDER BY fullname"; // or LOWER(Code) LIKE LOWER(:keyword) 
//$query = "SELECT * FROM country WHERE LOWER(name) LIKE LOWER(:keyword) or LOWER(Code) LIKE LOWER(:keyword) ORDER BY name"; // Put query fetching data from table here

$stmt = $con->prepare($query);
$keyword= isset($_POST['keyword']) ? $_POST['keyword'] : ''; //Is there any data sent from the form?

$keyword = "%".$keyword."%";
$stmt->bindParam(':keyword', $keyword);

$stmt->execute();

$num = $stmt->rowCount(); //Aquire number of rows

if($num>0){ //Is there any data/rows?
    echo "<table class='table table-responsive table-fix table-bordered'><thead class='thead-light'>";
    echo "<tr>";
    echo "<th>Name</th>"; // Rename, add or remove columns as you like.
    echo "<th>User ID</th>";
		echo "<th>Options</th>";
    echo "</tr>";
while ($rad = $stmt->fetch(PDO::FETCH_ASSOC)){ //Fetches data
    extract($rad);
    echo "<tr>";
		
		// Here is the data added to the table
    echo "<td>{$fullname}</td>"; //Rename, add or remove columns as you like
    echo "<td>{$userid}</td>";
		echo "<td>";

		//Here are the buttons for update, delete and read.
		echo "<a href='infoUser.php?name={$userid}'class='btn btn-info m-r-1em'>Info</a>";
		echo "<a href='updateUser.php?name={$userid}' class='btn btn-primary m-r-1em'>Update</a>";
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