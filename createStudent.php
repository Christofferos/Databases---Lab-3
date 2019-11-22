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

        include 'connection.php'; //Init a connection

        if ($_POST) {

            try {
                $query1 = "INSERT INTO users(fullname) VALUES (:fullname)";
                $query2 = "INSERT INTO students(userid, fullname, email, programme, homeaddress, postalnumber, phonenumber, birthdate) VALUES ((SELECT MAX(userID) FROM users), :fullname, :email, :programme, :homeaddress, :postalnumber, :phonenumber, :birthdate)";
                $stmt1 = $con->prepare($query1);
                $stmt2 = $con->prepare($query2);

                $fullname = htmlspecialchars(strip_tags($_POST['fullname'])); //Rename, add or remove columns as you like
                $email = htmlspecialchars(strip_tags($_POST['email']));
                $programme = htmlspecialchars(strip_tags($_POST['programme']));
                $homeaddress = htmlspecialchars(strip_tags($_POST['homeaddress']));
                $postalnumber = htmlspecialchars(strip_tags($_POST['postalnumber']));
                $phonenumber = htmlspecialchars(strip_tags($_POST['phonenumber']));
                $birthdate = htmlspecialchars(strip_tags($_POST['birthdate']));

                $stmt1->bindParam(':fullname', $fullname); //Binding parameters for query 1
                $stmt2->bindParam(':fullname', $fullname); //Binding parameters for query 2
                $stmt2->bindParam(':email', $email);
                $stmt2->bindParam(':programme', $programme);
                $stmt2->bindParam(':homeaddress', $homeaddress);
                $stmt2->bindParam(':postalnumber', $postalnumber);
                $stmt2->bindParam(':phonenumber', $phonenumber);
                $stmt2->bindParam(':birthdate', $birthdate);


                if ($stmt1->execute() && $stmt2->execute()) { //Executes and check if correctly executed
                    echo "<div class='alert alert-success'>User was saved.</div>";
                } else {
                    echo "<div class='alert alert-danger'>Unable to save user.</div>";
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
                $arr = [['Full name', 'fullname'], ['Email', 'email'], ['Programme', 'programme'], ['Address', 'homeaddress'], ['Postal number', 'postalnumber'], ['Phone number', 'phonenumber'], ['Birthdate', 'birthdate']];
                foreach ($arr as $a) {
                    echo '
                <tr> 
                    <td>' . $a[0] . '</td>
                    <td><input type="text" name=' . $a[1] . ' class="form-control" required /></td>
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