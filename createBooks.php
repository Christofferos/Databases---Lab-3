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
        $query = "INSERT INTO books(title,isbn,author,editionnum,lang,publisher,publicationdate,prequels,genre,pages,series) VALUES (:title,:isbn,:author,:editionnum,:lang,:publisher,:publicationdate,:prequels,:genre,:pages,:series)"; // Put query inserting data to table here

        $stmt = $con->prepare($query); // prepare query for execution
 
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
        <?php 
            $arr = [['Title', 'title'], ['ISBN', 'isbn'], ['Author', 'author'], ['Edition', 'editionnum'], ['Language', 'lang'], ['Publisher', 'publisher'], ['Published', 'publicationdate'], ['Prequels', 'prequels'], ['Genre', 'genre'], ['Pages', 'pages'], ['Series', 'series'] ];
            foreach($arr as $a) {
                echo '
                <tr> 
                    <td>'.$a[0].'</td>
                    <td><input type="text" name='.$a[1].' class="form-control" /></td>
                </tr>';
            }
        ?>
		
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