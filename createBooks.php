<!--Here is some styling HTML you don't need to pay attention to-->
<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" />
</head>

<body>
    <div class="container">
        <?php
        include 'header.php';
        ?>

        <!--Styling HTML ends and the real work begins below-->
        <?php

        include 'connection.php'; //Init a connection

        if ($_POST) {

            try {
                $query1 = "INSERT INTO resources(title) VALUES (:title)";
                $query2 = "INSERT INTO books(resourceid, title,isbn,author,editionnum,lang,publisher,publicationdate,prequels,genre,pages,series) VALUES ((SELECT MAX(resourceID) FROM resources), :title,:isbn,:author,:editionnum,:lang,:publisher,:publicationdate,:prequels,:genre,:pages,:series)";
                $stmt1 = $con->prepare($query1);
                $stmt2 = $con->prepare($query2); // prepare queries for execution

                $title = htmlspecialchars(strip_tags($_POST['title'])); //Rename, add or remove columns as you like
                $isbn = htmlspecialchars(strip_tags($_POST['isbn']));
                $author = htmlspecialchars(strip_tags($_POST['author']));
                $editionnum = htmlspecialchars(strip_tags($_POST['editionnum']));
                $lang = htmlspecialchars(strip_tags($_POST['lang']));
                $publisher = htmlspecialchars(strip_tags($_POST['publisher']));
                $publicationdate = htmlspecialchars(strip_tags($_POST['publicationdate']));
                $prequels = htmlspecialchars(strip_tags($_POST['prequels']));
                $genre = htmlspecialchars(strip_tags($_POST['genre']));
                $pages = htmlspecialchars(strip_tags($_POST['pages']));
                $series = htmlspecialchars(strip_tags($_POST['series']));

                $stmt1->bindParam(':title', $title); //Binding parameters for query 1
                $stmt2->bindParam(':title', $title); //Binding parameters for query 2
                $stmt2->bindParam(':isbn', $isbn);
                $stmt2->bindParam(':editionnum', $editionnum);
                $stmt2->bindParam(':author', $author);
                $stmt2->bindParam(':lang', $lang);
                $stmt2->bindParam(':publisher', $publisher);
                $stmt2->bindParam(':publicationdate', $publicationdate);
                $stmt2->bindParam(':prequels', $prequels);
                $stmt2->bindParam(':genre', $genre);
                $stmt2->bindParam(':pages', $pages);
                $stmt2->bindParam(':series', $series);


                if ($stmt1->execute() && $stmt2->execute()) { //Executes and check if correctly executed
                    echo "<div class='alert alert-success'>Resource was saved.</div>";
                } else {
                    echo "<div class='alert alert-danger'>Unable to save resource.</div>";
                }
            } catch (PDOException $exception) { //In case of error
                die('ERROR: ' . $exception->getMessage());
            }
        }
        ?>

        <!-- The HTML-Form. Rename, add or remove columns for your insert here -->
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <table class='table table-hover table-responsive table-bordered'>
                <?php
                $arr = [['Title', 'title'], ['ISBN', 'isbn'], ['Author', 'author'], ['Edition', 'editionnum'], ['Language', 'lang'], ['Publisher', 'publisher'], ['Publication Date', 'publicationdate'], ['Prequels', 'prequels'], ['Genre', 'genre'], ['Pages', 'pages'], ['Series', 'series']];
                foreach ($arr as $a) {
                    echo '
                <tr> 
                    <td>' . $a[0] . '</td>
                    <td><input type="text" name=' . $a[1] . ' class="form-control" /></td>
                </tr>';
                }
                ?>

                <tr>
                    <td></td>
                    <td>
                        <input type='submit' value='Save' class='btn btn-primary' />
                    </td>
                </tr>
            </table>
        </form>
    </div>
</body>

</html>