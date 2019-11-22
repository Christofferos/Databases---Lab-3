<!--Here is some styling HTML you don't need to pay attention to-->
<!DOCTYPE HTML>
<html>

<head>
    <title>Update books</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" />
</head>

<body>
    <div class="container">
        <?php
        include 'header.php';
        ?>
        <div class="page-header">
            <h1>Update userinfo</h1>
        </div>

        <!--Styling HTML ends and the real work begins below-->
        <?php

        $userid = isset($_GET['userid']) ? $_GET['userid'] : die('ERROR: Record ID not found.'); //The parameter value from the click is aquired

        include 'connection.php'; //Init the connection

        try { //Aquire the already existing data
            $query1 = "SELECT * FROM students WHERE userid = :userid";
            $query2 = "SELECT * FROM administrators WHERE userid = :userid";
            $stmt = $con->prepare($query1);
            $stmt->bindParam(':userid', $userid); //Binding ID for the query
            $stmt->execute();

            $row = $stmt->fetch(PDO::FETCH_ASSOC); //Fetching the data
            if ($row['userid'] == "") {    //No data found, try searching in admins instead
                //USER IS ADMIN
                $stmt = $con->prepare($query2);
                $stmt->bindParam(':userid', $userid); //Bind the ID for the query
                $stmt->execute(); //Execute query
                $row = $stmt->fetch(PDO::FETCH_ASSOC); //Fetchs data

                $userid = $row['userid'];
                $fullname = $row['fullname'];
                $programmeDept = $row['department'];
                $email = $row['email'];
                $homeaddress = $row['homeaddress'];
                $postalnumber = $row['postalnumber'];
                $phonenumber = $row['phonenumber'];
                $birthdate = $row['birthdate'];

                $admin = true;
            } else {   //USER IS STUDENT
                $userid = $row['userid'];
                $fullname = $row['fullname'];
                $programmeDept = $row['programme'];
                $email = $row['email'];
                $homeaddress = $row['homeaddress'];
                $postalnumber = $row['postalnumber'];
                $phonenumber = $row['phonenumber'];
                $birthdate = $row['birthdate'];

                $admin = false;
            }
            //$resourceid = $row['resourceid'];
        } catch (PDOException $exception) { //In case of error
            die('ERROR: ' . $exception->getMessage());
        }
        ?>

        <?php

        if ($_POST) { //Has the form been submitted?
            try {
                if ($admin == true) {
                    $query = "UPDATE administrators 
                    SET fullname=:fullname, department=:department, email=:email, homeaddress=:homeaddress, postalnumber=:postalnumber, phonenumber=:phonenumber, birthdate=:birthdate 
                    WHERE userid = '" . $userid . "'";
                } else {
                    $query = "UPDATE students 
                    SET fullname=:fullname, department=:department, email=:email, homeaddress=:homeaddress, postalnumber=:postalnumber, phonenumber=:phonenumber, birthdate=:birthdate 
                    WHERE userid = '" . $userid . "'";
                }
                $stmt = $con->prepare($query);

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
                if ($stmt->execute()) { //Executes and check if correctly executed
                    echo "<div class='alert alert-success'>Record was updated.</div>";
                } else {
                    echo "<div class='alert alert-danger'>Unable to update record. Please try again.</div>";
                }
            } catch (PDOException $exception) { //In case of error
                die('ERROR: ' . $exception->getMessage());
            }
        }
        ?>

        <!-- The HTML-Form. Rename, add or remove columns for your update here -->
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?name={$name}"); ?>" method="post">
            <table class='table table-hover table-responsive table-bordered'>
            <?php
            if ($admin == true) {
                $arr = [['UserID', $userid], ['Full name', $fullname], ['Department', $programmeDept], ['Email', $email], ['Home address', $homeaddress], ['Postal number', $postalnumber], ['Phone number', $phonenumber], ['Birth date', $birthdate]];
            } else {
                $arr = [['UserID', $userid], ['Full name', $fullname], ['Programme', $programmeDept], ['Email', $email], ['Home address', $homeaddress], ['Postal number', $postalnumber], ['Phone number', $phonenumber], ['Birth date', $birthdate]];
            }
            foreach ($arr as $a) {
                echo '<tr>
                <td>' . $a[0] . '</td>
                <td>' . $a[1] . '</td>
            </tr>';
            }
            ?>

                <tr>
                    <td></td>
                    <td>
                        <input type='submit' value='Save Changes' class='btn btn-primary' />
                    </td>
                </tr>
            </table>
        </form>
    </div>
</body>

</html>