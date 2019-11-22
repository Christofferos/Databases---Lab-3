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
            <h1>User information</h1>
        </div>
        <!--Styling HTML ends and the real work begins below-->


        <?php

        $userid = isset($_GET['userid']) ? strval($_GET['userid']) : die('ERROR: Record ID not found.'); //The parameter value from the click is aquired

        include 'connection.php';

        try {
            $query1 = "SELECT * FROM students WHERE userid = :userid"; // query fetching data from table
            $query2 = "SELECT * FROM administrators WHERE userid = :userid";
            $stmt = $con->prepare($query1);

            $stmt->bindParam(':userid', $userid); //Bind the ID for the query

            $stmt->execute(); //Execute query
            $row = $stmt->fetch(PDO::FETCH_ASSOC); //Fetchs data
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
        } catch (PDOException $exception) { //In case of error
            die('ERROR: ' . $exception->getMessage());
        }
        ?>

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
        </table>
    </div>
</body>

</html>