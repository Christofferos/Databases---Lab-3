<!--Here is some styling HTML you don't need to pay attention to-->
<!DOCTYPE html>
<html>

<head>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" />
  <style>
    .container {
      margin: auto;
      align-content: center;
    }

    .table-fix {
      box-shadow: 0px 0px 5px 1px;
      display: table;
    }
  </style>
</head>

<body>
  <div class="container">
    <?php
    include 'header.php';
    ?>



    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
      <table class='table table-hover table-responsive table-bordered'>
        <tr>
          <td>Search</td>
          <td><input type='text' name='keyword' class='form-control' /></td>
          <td>Language</td>
          <td>
            <select type='text' name='language' class='form-control'>
              <option value="any" selected="selected">-</option>
              <option value="English" <?php if (isset($_POST['language']) && $_POST['language'] == "English") echo 'selected="selected"'; ?>>English</option>
              <option value="Swedish" <?php if (isset($_POST['language']) && $_POST['language'] == "Swedish") echo 'selected="selected"'; ?>>Swedish</option>
            </select>
          </td>
          <td>Genre</td>
          <td>
            <select type='text' name='genre' class='form-control'>
              <option value="any" selected="selected">-</option>
              <option value="Popular Science" <?php if (isset($_POST['genre']) && $_POST['genre'] == "Popular Science") echo 'selected="selected"'; ?>>Popular Science</option>
              <option value="Philosophy" <?php if (isset($_POST['genre']) && $_POST['genre'] == "Philosophy") echo 'selected="selected"'; ?>>Philosophy</option>
              <option value="CourseLit" <?php if (isset($_POST['genre']) && $_POST['genre'] == "CourseLit") echo 'selected="selected"'; ?>>CourseLit</option>
              <option value="Fiction" <?php if (isset($_POST['genre']) && $_POST['genre'] == "Fiction") echo 'selected="selected"'; ?>>Fiction</option>
              <option value="Fantasy" <?php if (isset($_POST['genre']) && $_POST['genre'] == "Fantasy") echo 'selected="selected"'; ?>>Fantasy</option>
              <option value="Dystopian" <?php if (isset($_POST['genre']) && $_POST['genre'] == "Dystopian") echo 'selected="selected"'; ?>>Dystopian</option>
              <option value="Action" <?php if (isset($_POST['genre']) && $_POST['genre'] == "Action") echo 'selected="selected"'; ?>>Action</option>
            </select>
          </td>
          <td>
          <select type='text' name='availableBooks' class='form-control'>
              <option value="All" selected="selected">All Books</option>
              <option value="Available Books" <?php if (isset($_POST['availableBooks']) && $_POST['availableBooks'] == "Available Books") echo 'selected="selected"'; ?>>Available Books</option>
          </select>
          </td>
          
        </tr>
      </table>
    </form>

    <!--Styling HTML ends and the real work begins below-->

    <?php


    include 'connection.php'; //Init a connection


    $genre = '';
    $language = '';
    $available = '';
    if(isset($_POST['genre']) && isset($_POST['language']) && isset($_POST['availableBooks'])) {
      if ($_POST['genre'] !== 'any') {
        $genre = "AND genre = '" . $_POST['genre'] . "'";
      }
      if ($_POST['language'] !== 'any') {
        $language = "AND lang = '" . $_POST['language'] . "'";
      }
      if ($_POST['availableBooks'] !== 'All Books') {
        $available = "EXCEPT SELECT title, books.resourceid FROM books INNER JOIN borrows ON books.resourceid = borrows.resourceID WHERE datereturn IS NULL";
      }
    }

    $query = "SELECT title, resourceid FROM books WHERE LOWER(title) LIKE LOWER(:keyword) " . $genre . $language . $available ." ORDER BY title"; // or LOWER(Code) LIKE LOWER(:keyword) 
    
    //$query = "SELECT * FROM country WHERE LOWER(name) LIKE LOWER(:keyword) or LOWER(Code) LIKE LOWER(:keyword) ORDER BY name"; // Put query fetching data from table here

    $stmt = $con->prepare($query);
    $keyword = isset($_POST['keyword']) ? $_POST['keyword'] : ''; //Is there any data sent from the form?

    $keyword = "%" . $keyword . "%";
    $stmt->bindParam(':keyword', $keyword);

    $stmt->execute();

    $num = $stmt->rowCount(); //Aquire number of rows

    if ($num > 0) { //Is there any data/rows?
      echo "<table class='table table-responsive table-fix table-bordered'><thead class='thead-light'>";
      echo "<tr>";
      echo "<th>Title</th>"; // Rename, add or remove columns as you like.
      echo "<th>Resource ID</th>";
      echo "<th>Options</th>";
      echo "</tr>";
      while ($rad = $stmt->fetch(PDO::FETCH_ASSOC)) { //Fetches data
        extract($rad);
        echo "<tr>";

        // Here is the data added to the table
        echo "<td>{$title}</td>"; //Rename, add or remove columns as you like
        echo "<td>{$resourceid}</td>";
        echo "<td>";

        //Here are the buttons for update, delete and read.
        echo "<a href='readBooks.php?name={$title}'class='btn btn-info m-r-1em'>Info</a>"; // Replace with ID-variable, to make the buttons work
        echo "<a href='updateBooks.php?name={$title}' class='btn btn-primary m-r-1em'>Update</a>"; // Replace with ID-variable, to make the buttons work
        echo "</td>";
        echo "</tr>";
      }
      echo "</table>";
    } else {
      echo "<h1> Search gave no result </h1>";
    }
    ?>
  </div>
</body>

</html>