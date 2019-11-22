<!--Here is some styling HTML you don't need to pay attention to-->
<!DOCTYPE HTML>
<html>

<head>
    <title>LMS Books</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" />
</head>

<body>
    <div class="container">
        <?php
        include 'header.php';
        ?>
        <div class="page-header">
            <h1>Book information</h1>
        </div>
        <!--Styling HTML ends and the real work begins below-->


        <?php

        $name = isset($_GET['name']) ? $_GET['name'] : die('ERROR: Record ID not found.'); //The parameter value from the click is aquired

        include 'connection.php';

        try {
            $query = "SELECT * FROM books WHERE title = :name"; // Put query fetching data from table here
            $stmt = $con->prepare($query);

            $stmt->bindParam(':name', $name); //Bind the ID for the query

            $stmt->execute(); //Execute query

            $row = $stmt->fetch(PDO::FETCH_ASSOC); //Fetchs data

            $title = $row['title']; //Store data. Rename, add or remove columns as you like.
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
        } catch (PDOException $exception) { //In case of error
            die('ERROR: ' . $exception->getMessage());
        }
        ?>
        <!-- Here is how we display our data. Rename, add or remove columns as you like-->
        <table class='table table-hover table-responsive table-bordered'>
            <tr>
                <td>Title</td>
                <td><?php echo htmlspecialchars($title, ENT_QUOTES);  ?></td>
            </tr>

            <tr>
                <td>ISBN</td>
                <td><?php echo htmlspecialchars($isbn, ENT_QUOTES);  ?></td>
            </tr>
            <tr>
                <td>Author</td>
                <td><?php echo htmlspecialchars($author, ENT_QUOTES);  ?></td>
            </tr>
            <tr>
                <td>Edition</td>
                <td><?php echo htmlspecialchars($editionnum, ENT_QUOTES);  ?></td>
            </tr>

            <tr>
                <td>Language</td>
                <td><?php echo htmlspecialchars($lang, ENT_QUOTES);  ?></td>
            </tr>

            <tr>
                <td>Publisher</td>
                <td><?php echo htmlspecialchars($publisher, ENT_QUOTES);  ?></td>
            </tr>

            <tr>
                <td>Publication</td>
                <td><?php echo htmlspecialchars($publicationdate, ENT_QUOTES);  ?></td>
            </tr>
            <tr>
                <td>Prequels</td>
                <td><?php echo htmlspecialchars($prequels, ENT_QUOTES);  ?></td>
            </tr>
            <tr>
                <td>Genre</td>
                <td><?php echo htmlspecialchars($genre, ENT_QUOTES);  ?></td>
            </tr>
            <tr>
                <td>Pages</td>
                <td><?php echo htmlspecialchars($pages, ENT_QUOTES);  ?></td>
            </tr>
            <tr>
                <td>Series</td>
                <td><?php echo htmlspecialchars($series, ENT_QUOTES);  ?></td>
            </tr>

        </table>
    </div>
</body>

</html>