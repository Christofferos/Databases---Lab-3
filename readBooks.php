<!--Here is some styling HTML you don't need to pay attention to-->
<!DOCTYPE HTML>
<html>
<head>
    <title>LMS Books</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" />
</head>
<body>
    <div class="container">
        <div class="page-header">
            <h1>Book information</h1>
        </div>
<!--Styling HTML ends and the real work begins below-->

         
<?php

$name=isset($_GET['name']) ? $_GET['name'] : die('ERROR: Record ID not found.'); //The parameter value from the click is aquired
 
include 'connection.php';
 
try {
    $query = "SELECT * FROM Country WHERE name = :name"; // Put query fetching data from table here
    $stmt = $con->prepare( $query );
 
    $stmt->bindParam(':name', $name); //Bind the ID for the query

    $stmt->execute(); //Execute query
 
    $row = $stmt->fetch(PDO::FETCH_ASSOC); //Fetchs data
 
    $name = $row['name']; //Store data. Rename, add or remove columns as you like.
    $code = $row['code'];
	$capital = $row['capital'];
	$province = $row['province'];
	$area = $row['area'];
	$population = $row['population'];
}
 

catch(PDOException $exception){ //In case of error
    die('ERROR: ' . $exception->getMessage());
}
?>
 <!-- Here is how we display our data. Rename, add or remove columns as you like-->
<table class='table table-hover table-responsive table-bordered'>
    <tr>
        <td>Name</td>
        <td><?php echo htmlspecialchars($name, ENT_QUOTES);  ?></td>
    </tr>
	
	<tr>
        <td>Code</td>
        <td><?php echo htmlspecialchars($code, ENT_QUOTES);  ?></td>
    </tr>
	
	<tr>
        <td>Capital</td>
        <td><?php echo htmlspecialchars($capital, ENT_QUOTES);  ?></td>
    </tr>
	
	<tr>
        <td>Province</td>
        <td><?php echo htmlspecialchars($province, ENT_QUOTES);  ?></td>
    </tr>
	
	<tr>
        <td>Area</td>
        <td><?php echo htmlspecialchars($area, ENT_QUOTES);  ?></td>
    </tr>
	
    <tr>
        <td>Population</td>
        <td><?php echo htmlspecialchars($population, ENT_QUOTES);  ?></td>
    </tr>
	
	
	
	
    <tr>
        <td></td>
        <td>
            <a href='books.php' class='btn btn-danger'>Back to read products</a>
        </td>
    </tr>
</table> 
    </div> 
</body>
</html>