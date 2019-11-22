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

                $fullname = $row['fullname'];
                $department = $row['department'];
                $email = $row['email'];
                $homeaddress = $row['homeaddress'];
                $postalnumber = $row['postalnumber'];
                $phonenumber = $row['phonenumber'];
                $birthdate = $row['birthdate'];

                $admin = true;
            } else {   //USER IS STUDENT
                $fullname = $row['fullname'];
                $programme = $row['programme'];
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
                    WHERE userid =:userid";
                } else {
                    $query = "UPDATE students 
                    SET fullname=:fullname, programme=:programme, email=:email, homeaddress=:homeaddress, postalnumber=:postalnumber, phonenumber=:phonenumber, birthdate=:birthdate 
                    WHERE userid =:userid";
                }
                $stmt = $con->prepare($query);


                $stmt->bindParam(':userid', $userid);
                $stmt->bindParam(':fullname', $fullname); //Binding parameters for query
                if ($admin == true) {
                    $stmt->bindParam(':department', $department);
                } else {
                    $stmt->bindParam(':programme', $programme);
                }
                $stmt->bindParam(':email', $email);
                $stmt->bindParam(':homeaddress', $homeaddress);
                $stmt->bindParam(':postalnumber', $postalnumber);
                $stmt->bindParam(':phonenumber', $phonenumber);
                $stmt->bindParam(':birthdate', $birthdate);

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
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?userid={$userid}"); ?>" method="post">
            <table class='table table-hover table-responsive table-bordered'>
                <?php
                if ($admin == true) {
                    $arr = [['Full name', 'fullname', $fullname], ['Department', 'department', $department], ['Email', 'email', $email], ['Home address', 'homeaddress', $homeaddress], ['Postal number', 'postalnumber', $postalnumber], ['Phone number', 'phonenumber', $phonenumber], ['Birth date', 'birthdate', $birthdate]];
                } else {
                    $arr = [['Full name', 'fullname', $fullname], ['Programme', 'programme', $programme], ['Email', 'email', $email], ['Home address', 'homeaddress', $homeaddress], ['Postal number', 'postalnumber', $postalnumber], ['Phone number', 'phonenumber', $phonenumber], ['Birth date', 'birthdate', $birthdate]];
                }
                foreach ($arr as $a) {
                    echo '<tr>
                <td>' . $a[0] . '</td>
                <td><input type="text" name=' . $a[1] . ' value="' . $a[2] . '" class="form-control"</td>
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