<!DOCTYPE html>
<html>
<div class="page-header">
    <nav class="navbar navbar-expand-sm bg-dark navbar-dark">
        <ul class="navbar-nav">
            <?php
            $arr = [['books.php', 'Books'], ['createBooks.php', 'Add Book'], ['users.php', 'Users'], ['createStudent.php', 'Add Student'], ['createAdmin.php', 'Add Administrator'], ['borrows.php', 'Borrows']];
            foreach ($arr as $a) {
                echo '
                <li class="nav-item">
                <a class="nav-link" href=' . $a[0] . '>' . $a[1] . '</a>
            </li>';
            }
            ?>
        </ul>
    </nav>
</div>

</html>