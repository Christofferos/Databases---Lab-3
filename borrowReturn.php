<?php
$id=isset($_GET['id']) ? $_GET['id'] : die('ERROR: ID not found'); //Aquire the ID

include 'connection.php'; //Init the connection

try { 
    $query1 = "UPDATE borrows SET datereturn = CURRENT_DATE WHERE borrowid = :id"; // Sets the return date of borrow
    $query2 = "UPDATE borrows SET daysoverdue = (CURRENT_DATE::date - (select dateborrow from borrows where borrowid = :id)::date) WHERE borrowid = :id;"; // Sets the return date of borrow

    $stmt1 = $con->prepare($query1);
    $stmt2 = $con->prepare($query2);

    $stmt1->bindParam(':id', $id); //Binding the ID for the query
    $stmt2->bindParam(':id', $id); //Binding the id for query 2

    if($stmt1->execute()){
        if($stmt2->execute()){
        	header('Location: borrows.php'); //Redirecting back to the main page
	    }else{
	        die('Could not issue return'); //Something went wrong
	    }
    }else{
        die('Could not issue return'); //Something went wrong
    }
}

catch(PDOException $exception){
    die('ERROR: ' . $exception->getMessage());
}
?>
