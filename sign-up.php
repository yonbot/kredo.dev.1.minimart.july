<?php
  require "connection.php";

  function createUser($first_name, $last_name, $username, $password) {
    $conn = connection();

    // it will return a hash password
    $password = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO users
      (`first_name`, `last_name`, `username`, `password`) 
      VALUES('$first_name', '$last_name', '$username', '$password')";

    if ($conn->query($sql)) {
      header("location: login.php");
      exit;
    } else {
      die("Error in registering new user. " . $conn->error);
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
  
  <title>Signup Page</title>
</head>
<body class="bg-light">
  <div style="height: 100vh;">
    <row class="h-100 m-0">
      <div class="card w-25 mx-auto my-auto p-0">
        <div class="card-header text-success">
          <h1 class="card-title h3 mb-0">Create Account</h1>
        </div>
        <div class="card-body">
          <form action="" method="post">
            <div class="mb-3">
              <label for="first-name" 
                class="form-label small fw-bold">
                First Name
              </label>
              <input type="text" name="first_name" id="first-name"
                class="form-control" maxlength="50"
                required autofocus>
            </div>
            <div class="mb-3">
              <label for="last-name" 
                class="form-label small fw-bold">
                Last Name
              </label>
              <input type="text" name="last_name" id="last-name"
                class="form-control" maxlength="50"
                required>
            </div>
            <div class="mb-3">
              <label for="username" 
                class="form-label small fw-bold">
                Username
              </label>
              <input type="text" name="username" id="username"
                class="form-control" maxlength="15"
                required>
            </div>
            <div class="mb-3">
              <label for="password" 
                class="form-label small fw-bold">
                Password
              </label>
              <input type="password" name="password" id="password"
                class="form-control mb-2"
                required>
            </div>
            <div class="mb-5">
              <label for="confirm-password" 
                class="form-label small fw-bold">
                Confirm Password
              </label>
              <input type="password" name="confirm_password" id="confirm-password"
                class="form-control"
                required>
            </div>
            <button type="submit" name="btn_sign_up"
              class="btn btn-success w-100">Sign Up</button>
          </form>

          <div class="text-center mt-3">
            <p class="small">Already have an account? <a href="login.php">Login</a></p>
          </div>

          <!-- Collect the data from the form -->
          <?php
            if (isset($_POST['btn_sign_up'])) {
              $first_name = $_POST['first_name'];
              $last_name = $_POST['last_name'];
              $username = $_POST['username'];
              $password = $_POST['password'];
              $confirm_password = $_POST['confirm_password'];

              if ($password == $confirm_password) {
                createUser($first_name, $last_name, $username, $password);
              } else {
                echo "<p class='alert alert-danger'>Password and Confirm Password do not match</p>";
              }
            }
          ?>
        </div>
      </div>
    </row>
  </div>  


  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz"
    crossorigin="anonymous"></script>
</body>
</html>