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
                $query1 = "INSERT INTO borrows(resourceid, userid, dateborrow, dateexpire) VALUES (:resourceid, :userid, CURRENT_DATE, CURRENT_DATE + interval '7' day)";
                
                $stmt1 = $con->prepare($query1);

                $resourceid = htmlspecialchars(strip_tags($_POST['resourceid'])); //Rename, add or remove columns as you like
                $userid = htmlspecialchars(strip_tags($_POST['userid']));

                $stmt1->bindParam(':resourceid', $resourceid); //Binding parameters for query 2
                $stmt1->bindParam(':userid', $userid);


                if ($stmt1->execute()) { //Executes and check if correctly executed
                    echo "<div class='alert alert-success'>Borrow was recorded.</div>";
                } else {
                    echo "<div class='alert alert-danger'>Unable to add borrow.</div>";
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
                $arr = [['ResourceID', 'resourceid'], ['UserID', 'userid']];
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