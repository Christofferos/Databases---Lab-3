<?php
$name=isset($_GET['name']) ? $_GET['name'] : die('ERROR: ID not found'); //Aquire the ID

include 'connection.php'; //Init the connection

try { 
    // $query1 = "DELETE FROM resources WHERE title = :name"; // Insert your DELETE query here
    // $query2 = "DELETE FROM books WHERE title = :name"; // Insert your DELETE query here
    $stmt1 = $con->prepare($query1);
    $stmt1->bindParam(':name', $name); //Binding the ID for the query
    $stmt2 = $con->prepare($query2);
    $stmt2->bindParam(':name', $name); //Binding the ID for the query

    if($stmt2->execute()){
        if($stmt1->execute()){
        	header('Location: books.php'); //Redirecting back to the main page
	    }else{
	        die('Could not remove resource'); //Something went wrong
	    }
    }else{
        die('Could not remove book'); //Something went wrong
    }
}

catch(PDOException $exception){
    die('ERROR: ' . $exception->getMessage());
}
?>