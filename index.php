<?php
  require "connection.php";

  function login($username, $password) {
    $conn = connection();
    $sql = "SELECT * from users WHERE username = '$username'";

    if ($result = $conn->query($sql)) {
      if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();

        // ユーザ入力パスワードとDBパスワードを比較する
        // check if the password is correct
        if (password_verify($password, $user['password'])) {
          session_start();

          $_SESSION['id'] = $user['id'];
          $_SESSION['username'] = $user['username'];
          $_SESSION['full_name'] = $user['first_name'] . " " . $user['last_name'];
          // the scope of the session variable are global in scope
          // to any part of your application
          header("location: products.php");
          exit;
        } else {
          echo "<div class='alert alert-danger'>Incorrect Password</div>";
        }
      } else {
        echo "<div class='alert alert-danger'>Username not found</div>";
      }
    } else {
      echo "Error in retrieving the user " . $conn->error;
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
  
  <title>Login</title>
</head>
<body class="bg-light">
  <div style="height: 100vh;">
    <div class="row h-100 m-0">
      <div class="card w-25 mx-auto my-auto px-0">
        <div class="card-header text-primary text-center">
          <h1 class="card-title text-center mb-0">Minimart Catalog</h1>
        </div>
        <div class="card-body">
          <form action="" method="post">
            <div class="mb-3">
              <label for="username" 
                class="form-label small fw-bold">
                Username
              </label>
              <input type="text" name="username" id="username"
                class="form-control"
                autofocus required>
            </div>
            <div class="mb-5">
              <label for="password" 
                class="form-label small fw-bold">
                Password
              </label>
              <input type="password" name="password" id="password"
                class="form-control"
                required>
            </div>
            <button type="submit" name="btn_log_in"
              class="btn btn-primary w-100">Login</button>
          </form>
          <div class="text-center mt-3">
            <a href="sign-up.php" class="small">Create An Account</a>
          </div>

          <?php
            if (isset($_POST['btn_log_in'])) {
              $username = $_POST['username'];
              $password = $_POST['password'];

              login($username, $password);
            }
          ?>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz"
    crossorigin="anonymous"></script>
</body>
</html>