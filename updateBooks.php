<!--Here is some styling HTML you don't need to pay attention to-->
<!DOCTYPE HTML>
<html>
<head>
    <title>Update books</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" />  
</head>
<body>
    <div class="container">
        <div class="page-header">
            <h1>Update bookinfo</h1>
        </div>
     
<!--Styling HTML ends and the real work begins below-->	 
<?php
		
$name=isset($_GET['name']) ? $_GET['name'] : die('ERROR: Record ID not found.'); //The parameter value from the click is aquired
 
include 'connection.php'; //Init the connection
 
try { //Aquire the already existing data
    $query = "SELECT * FROM books WHERE title = :name"; //Put query gathering the data here
    $stmt = $con->prepare( $query );

    $stmt->bindParam(':name', $name); //Binding ID for the query
     
    $stmt->execute();
     
    $row = $stmt->fetch(PDO::FETCH_ASSOC); //Fetching the data
     
    $title = $row['title']; //Rename, add or remove columns as you like.
    $isbn = $row['isbn'];
    $author = $row['author'];
    $editionnum = $row['editionnum'];
    $lang = $row['lang'];
    $publisher = $row['publisher'];
    $publicationdate = $row['publicationdate'];
    $prequels = $row['prequels'];
    $genre = $row['genre'];
    $pages = $row['pages'];
    $series = $row['series'];

    $oldtitle = $name;
    //$resourceid = $row['resourceid'];
}
 
catch(PDOException $exception){ //In case of error
    die('ERROR: ' . $exception->getMessage());
}
?>
 
<?php
 
 if($_POST){ //Has the form been submitted?
      
     try{
         $query = "UPDATE books 
                     SET title=:title, isbn=:isbn, author=:author, editionnum=:editionnum, lang=:lang, publisher=:publisher, publicationdate=:publicationdate, prequels=:prequels, genre=:genre, pages=:pages, series=:series 
                     WHERE title = '".$oldtitle."'"; //:title //Put your query for updating data here
         $stmt = $con->prepare($query);
  
         //$resourceid = htmlspecialchars(strip_tags($_POST['resourceid']));
         $title=htmlspecialchars(strip_tags($_POST['title'])); //Rename, add or remove columns as you like
         $isbn=htmlspecialchars(strip_tags($_POST['isbn']));
         $author=htmlspecialchars(strip_tags($_POST['author']));
		 $editionnum = htmlspecialchars(strip_tags($_POST['editionnum']));
		 $lang = htmlspecialchars(strip_tags($_POST['lang']));
         $publisher = htmlspecialchars(strip_tags($_POST['publisher']));
         $publicationdate = htmlspecialchars(strip_tags($_POST['publicationdate']));
         $prequels = htmlspecialchars(strip_tags($_POST['prequels']));
         $genre = htmlspecialchars(strip_tags($_POST['genre']));
         $pages = htmlspecialchars(strip_tags($_POST['pages']));
         $series = htmlspecialchars(strip_tags($_POST['series']));
         

        //$stmt->bindParam(':resourceid', $resourceid);
        $stmt->bindParam(':title', $title); //Binding parameters for query
        $stmt->bindParam(':isbn', $isbn);
        $stmt->bindParam(':editionnum', $editionnum);
        $stmt->bindParam(':author', $author);
		$stmt->bindParam(':editionnum', $editionnum);
        $stmt->bindParam(':lang', $lang);
        $stmt->bindParam(':publisher', $publisher);
        $stmt->bindParam(':publicationdate', $publicationdate);
        $stmt->bindParam(':prequels', $prequels);
        $stmt->bindParam(':genre', $genre);
        $stmt->bindParam(':pages', $pages);
        $stmt->bindParam(':series', $series);
        


          
         // Execute the query
         if($stmt->execute()){//Executes and check if correctly executed
             echo "<div class='alert alert-success'>Record was updated.</div>";
         }else{
             echo "<div class='alert alert-danger'>Unable to update record. Please try again.</div>";
         }
          
     }
      
     catch(PDOException $exception){ //In case of error
         die('ERROR: ' . $exception->getMessage());
     }
 }
 ?>
 
<!-- The HTML-Form. Rename, add or remove columns for your update here -->
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?name={$name}");?>" method="post">
    <table class='table table-hover table-responsive table-bordered'>
        <tr>
            <td>Title</td>
            <td><input type='text' name='title' value="<?php echo htmlspecialchars($title, ENT_QUOTES);  ?>" class='form-control' /></td>
        </tr>
        <tr>
            <td>ISBN</td>
            <td><input type='text' name='isbn' value="<?php echo htmlspecialchars($isbn, ENT_QUOTES);  ?>" class='form-control' /></td>
        </tr>
        <tr>
            <td>Author</td>
            <td><input type='text' name='author' value="<?php echo htmlspecialchars($author, ENT_QUOTES);  ?>" class='form-control' /></td>
        </tr>
		
		<tr>
            <td>Edition</td>
            <td><input type='text' name='editionnum' value="<?php echo htmlspecialchars($editionnum, ENT_QUOTES);  ?>" class='form-control' /></td>
        </tr>
		
		<tr>
            <td>Language</td>
            <td><input type='text' name='lang' value="<?php echo htmlspecialchars($lang, ENT_QUOTES);  ?>" class='form-control' /></td>
        </tr>
        <tr>
            <td>Publisher</td>
            <td><input type='text' name='publisher' value="<?php echo htmlspecialchars($publisher, ENT_QUOTES);  ?>" class='form-control' /></td>
        </tr>
        <tr>
            <td>Publication</td>
            <td><input type='text' name='publicationdate' value="<?php echo htmlspecialchars($publicationdate, ENT_QUOTES);  ?>" class='form-control' /></td>
        </tr>
        <tr>
            <td>Prequels</td>
            <td><input type='text' name='prequels' value="<?php echo htmlspecialchars($prequels, ENT_QUOTES);  ?>" class='form-control' /></td>
        </tr>
        <tr>
            <td>Genre</td>
            <td><input type='text' name='genre' value="<?php echo htmlspecialchars($genre, ENT_QUOTES);  ?>" class='form-control' /></td>
        </tr>
        <tr>
            <td>Pages</td>
            <td><input type='text' name='pages' value="<?php echo htmlspecialchars($pages, ENT_QUOTES);  ?>" class='form-control' /></td>
        </tr>
        <tr>
            <td>Series</td>
            <td><input type='text' name='series' value="<?php echo htmlspecialchars($series, ENT_QUOTES);  ?>" class='form-control' /></td>
        </tr>

        <tr>
            <td></td>
            <td>
                <input type='submit' value='Save Changes' class='btn btn-primary' />
                <a href='books.php' class='btn btn-danger'>Back to read products</a>
            </td>
        </tr>
    </table>
</form>
    </div>
</body>
</html>