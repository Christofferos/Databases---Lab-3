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
            
            <td>Identification</td>
            <td>
              <select type='text' name='id' class='form-control'> 
                <option value="Fullname">Full Name</option>
                <option value="UserID" <?php if(isset($_POST['id']) && $_POST['id'] == "UserID") echo 'selected="selected"';?>>UserID</option>
              </select>
            </td>
            <td>Role</td>
            <td>
              <select type='text' name='role' class='form-control'> 
                <option value="any">-</option>
                <option value="department" <?php if(isset($_POST['role']) && $_POST['role'] == "department") echo 'selected="selected"';?>>Administrator</option>
                <option value="programme" <?php if(isset($_POST['role']) && $_POST['role'] == "programme") echo 'selected="selected"';?>>Student</option>
              </select>
            </td>
        </tr>
    </table>
</form>

<?php


include 'connection.php'; //Init a connection

$userid = false;
$table;
if(isset($_POST['role'])) {
  if($_POST['role'] === 'department') {
    $table = 'administrators';
  } else {
    $table = 'students';
  } 
}

if(isset($_POST['id']) || isset($_POST['role'])) {
  if($_POST['id'] !== 'Fullname' && $_POST['keyword'] == '') {
    $query = "SELECT * FROM users ORDER BY fullname ASC;";
    $userid = true;
  }
  else if ($_POST['id'] !== 'Fullname' && $_POST['role'] !== 'any') {
    $query = "SELECT * FROM ".$table." WHERE userid = ".$_POST['keyword']." AND ".$_POST['role']." IS NOT NULL ORDER BY fullname ASC;";
    $userid = true;
  }
  else if ($_POST['id'] !== 'Fullname' && $_POST['role'] === 'any') {
    $query = "SELECT * FROM users WHERE userid = ".$_POST['keyword']." ORDER BY fullname ASC;";
    $userid = true;
  }
  else if ($_POST['id'] === 'Fullname' && $_POST['role'] !== 'any') {
    $query = "SELECT * FROM ".$table." WHERE ".$_POST['role']." IS NOT NULL AND LOWER(fullname) LIKE LOWER(:keyword) ORDER BY fullname ASC;";
  }
  else {
    $query = "SELECT * FROM users WHERE LOWER(fullname) LIKE LOWER(:keyword) ORDER BY fullname ASC;";
  }
}
else {
  $query = "SELECT * FROM users WHERE LOWER(fullname) LIKE LOWER(:keyword) ORDER BY fullname ASC;"; // or LOWER(Code) LIKE LOWER(:keyword) 
} 
//$query = "SELECT * FROM country WHERE LOWER(name) LIKE LOWER(:keyword) or LOWER(Code) LIKE LOWER(:keyword) ORDER BY name"; // Put query fetching data from table here

$stmt = $con->prepare($query);

if(!$userid) {
  $keyword= isset($_POST['keyword']) ? $_POST['keyword'] : ''; //Is there any data sent from the form?

  $keyword = "%".$keyword."%";
  $stmt->bindParam(':keyword', $keyword);
}

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

		//Here are the buttons for update, and check info.
		echo "<a href='infoUser.php?userid={$userid}'class='btn btn-info m-r-1em'>Info</a>";
		echo "<a href='updateUser.php?userid={$userid}' class='btn btn-primary m-r-1em'>Update</a>";
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