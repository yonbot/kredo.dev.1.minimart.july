<?php
  session_start();
  require "connection.php";

  if (!isset($_SESSION['id'])) {
    header("location: index.php");
    exit;
  }

  $user = getUser();

  function getUser() {
    $conn = connection();

    $id = $_SESSION['id']; // coming from the login.php
    $sql = "SELECT * FROM users WHERE id = $id";

    if ($result = $conn->query($sql)) {
      return $result->fetch_assoc();
    } else {
      die("Error in retrieving the user details. " . $conn->error);
    }
  }

  function updatePhoto($id, $photo_name, $photo_tmp) {
    $conn = connection();
    $sql = "UPDATE users SET photo = '$photo_name'
      WHERE id = $id";

    if ($conn->query($sql)) {
      // Set the destination where the image will be save
      $destination = "assets/images/$photo_name";
      move_uploaded_file($photo_tmp, $destination);
      header("refresh: 0");
    } else {
      die("Error in uploading photo. " . $conn->error);
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
  
  <!-- Style Css -->
  <link rel="stylesheet" href="assets/css/style.css" class="stylesheet">
  <title>Profile</title>
</head>
<body>
  <?php
    include "main-nav.php"; // navigation menu
  ?>

  <main class="container">
    <div class="row justify-content-center">
      <div class="col-6">
        <?php
          if ($user['photo']) {
        ?>
            <img src="assets/images/<?=$user['photo']?>" 
              alt="<?=$user['photo']?>" class="d-block mx-auto img-thumbnail profile-photo">
        <?php
          } else {
        ?>
            <i class="fa-solid fa-user d-block text-center profile-icon"></i>
        <?php
          }
        ?>

        <div class="mt-2 mb-3 text-center">
          <p class="h4 mb-0"><?=$user['username']?></p>
          <p><?=$user['first_name'] . " " . $user['last_name']?> </p>
        </div>

        <form action="" method="post" enctype="multipart/form-data">
          <div class="input-group mb-2">
            <input type="file" name="photo" id="photo" class="form-control">
            <button type="submit" name="btn_upload_photo"
              class="btn btn-outline-secondary">Upload</button>
          </div>
        </form>

        <?php
          if (isset($_POST['btn_upload_photo'])) {
            $id = $_SESSION['id'];
            $photo_name = $_FILES['photo']['name'];
            $photo_tmp = $_FILES['photo']['tmp_name'];
            // move the image/file temporarry

            updatePhoto($id, $photo_name, $photo_tmp); // call this funtion
          }
        ?>


      </div>
    </div>
  </main>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz"
    crossorigin="anonymous"></script>
</body>
</html>