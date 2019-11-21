<!--Here is some styling HTML you don't need to pay attention to-->
<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" />
</head>
<body>

<!--Styling HTML ends and the real work begins below-->
<?php

include 'connection.php'; //Init a connection

if($_POST){
 
    try{
        $query = "INSERT INTO country(name,code,capital,province,area,population) VALUES (:name,:code,:capital,:province,:area,:population)"; // Put query inserting data to table here

        $stmt = $con->prepare($query); // prepare query for execution
 
        $name=htmlspecialchars(strip_tags($_POST['name'])); //Rename, add or remove columns as you like
        $code=htmlspecialchars(strip_tags($_POST['code']));
        $capital=htmlspecialchars(strip_tags($_POST['capital']));
		$province=htmlspecialchars(strip_tags($_POST['province']));
		$area=htmlspecialchars(strip_tags($_POST['area']));
		$population=htmlspecialchars(strip_tags($_POST['population']));
 
        $stmt->bindParam(':name', $name); //Binding parameters for the query
        $stmt->bindParam(':code', $code);
        $stmt->bindParam(':capital', $capital);
		$stmt->bindParam(':province', $province);
        $stmt->bindParam(':area', $area);
        $stmt->bindParam(':population', $population);
		
		

        if($stmt->execute()){ //Executes and check if correctly executed
            echo "<div class='alert alert-success'>Record was saved.</div>";
        }else{
            echo "<div class='alert alert-danger'>Unable to save record.</div>";
        }
    }
    catch(PDOException $exception){ //In case of error
        die('ERROR: ' . $exception->getMessage());
    }
}
?>
 
<!-- The HTML-Form. Rename, add or remove columns for your insert here -->
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
    <table class='table table-hover table-responsive table-bordered'>
        <tr>
            <td>Name</td>
            <td><input type='text' name='name' class='form-control' /></td>
        </tr>
        <tr>
            <td>Code</td>
            <td><input type='text' name='code' class='form-control'/></td>
        </tr>
        <tr>
            <td>Capital</td>
            <td><input type='text' name='capital' class='form-control' /></td>
        </tr>
		<tr>
            <td>Province</td>
            <td><input type='text' name='province' class='form-control' /></td>
        </tr>
		<tr>
            <td>Area</td>
            <td><input type='text' name='area' class='form-control' /></td>
        </tr>
		<tr>
            <td>Population</td>
            <td><input type='text' name='population' class='form-control' /></td>
        </tr>
		
        <tr>
            <td></td>
            <td>
                <input type='submit' value='Save' class='btn btn-primary' />
                <a href='books.php' class='btn btn-danger'>Go back</a>
            </td>
        </tr>
    </table>
</form>
</body>
</html>