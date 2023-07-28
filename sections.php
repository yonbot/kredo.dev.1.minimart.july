<?php
  session_start();
  require "connection.php";

  function createSection($name) {
    // Connection
    $conn = connection(); // this is the function we have in connection.php
    
    // SQL Query string
    $sql = "insert into sections(`name`) values('$name')";

    // Execute the query string
    if ($conn->query($sql)) {
      // If success
      header("refresh: 0");
      // refresh the current page in 0 seconds
    } else {
      // if there is an error / Fail
      die("Error adding new section " . $conn->error);
    }
  }

  function getAllSections() {
    $conn = connection(); // connection object
    $sql = "select * from sections";

    if ($result = $conn->query($sql)) {
      return $result;
    } else {
      die("Error in retrieving sections " . $conn->error);
    }
  }

  function deleteSection($section_id) {
    $conn = connection(); // connection object
    $sql = "DELETE FROM sections WHERE id = $section_id";

    if ($conn->query($sql)) {
      header("refresh: 0");
    } else {
      die("Error in deleting section " . $conn->error);
    }
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- Bootstrap CDN -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
  
  <!-- Font Awesome CDN -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

  <title>Sections</title>
</head>
<body>
  <?php
    include "main-nav.php";
  ?>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-6">
        <h2 class="fw-light mb-3">
          Sections
        </h2>
        <div class="mb-3">
          <form action="" method="post">
            <div class="row gx-2">
              <div class="col">
                <input type="text" name="name" id="name"
                  class="form-control" 
                  placeholder="Add a new section here..."
                  max="50" required autofocus>
              </div>
              <div class="col-auto">
                <button type="submit" name="btn_add" 
                  class="btn btn-info w-100 fw-bold">
                  <i class="fa-solid fa-plus"></i> Add
                </button>
              </div>
            </div>
          </form>

          <?php
            if (isset($_POST['btn_add'])) {
              $name = $_POST['name'];
              print_r($name);
              createSection($name);
            }
          ?>
        </div>

        <!-- Table -->
        <table class="table table-hover table-sm align-middle text-center">
          <thead class="table-info">
            <tr>
              <th>ID</th>
              <th>NAME</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            <?php
              $all_sections = getAllSections();
              while ($section = $all_sections->fetch_assoc()) {
            ?>
            <tr>
              <td><?= $section['id'] ?></td>
              <td><?= $section['name'] ?></td>
              <td>
                <form action="" method="post">
                  <button type="submit" name="btn_delete"
                    value="<?= $section['id'] ?>"
                    class="btn btn-outline-danger border-0"
                    title="Delete">
                    <i class="fa-solid fa-trash-can"></i>
                  </button>
                </form>

                <?php
                  if (isset($_POST['btn_delete'])) {
                    $section_id = $_POST['btn_delete'];
                    deleteSection($section_id); // call this
                  }
                ?>
              </td>
            </tr>
            <?php
              }
            ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz"
    crossorigin="anonymous"></script>
</body>
</html>