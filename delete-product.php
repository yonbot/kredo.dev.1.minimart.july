<?php
  session_start();
  require "connection.php";

  $id = $_GET['id'];
  $product = getProduct($id); // $product is an associative array


  function getProduct($id) {
    $conn = connection(); // connection object
    $sql = "SELECT * FROM products WHERE id = $id";

    if ($result = $conn->query($sql)) {
      return $result->fetch_assoc();
    } else {
      die("Error in retrieving the product details " . $conn->error);
    }
  }

  function deleteProduct($id) {
    $conn = connection(); // connection object
    $sql = "DELETE FROM products WHERE id = $id";

    if ($conn->query($sql)) {
      header("location: products.php");
      exit;
    } else {
      die("Error in deleting the product. " . $conn->error);
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
  
  <title>Delete Product</title>
</head>
<body>
  <?php
    include "main-nav.php";
  ?>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-6">
        <div class="text-center mb-4">
          <i class="fa-solid fa-triangle-exclamation text-warning display-4"></i>
          <h2 class="fw-light text-center mb-3">Delete Product</h2>
          <p class="fw-bold mb-0">Are you sure you want to delete "<?=$product['name']?>"</p>
        </div>
        <div class="row">
          <div class="col">
            <a href="products.php" class="btn btn-secondary w-100">Cancel</a>
          </div>
          <div class="col">
            <form action="" method="post">
              <button type="submit" name="btn_delete"
                class="btn btn-outline-secondary w-100">
                Delete
              </button>
            </form>

            <?php
              if (isset($_POST['btn_delete'])) {
                $id = $_GET['id'];
                deleteProduct($id);
              }
            ?>

          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz"
    crossorigin="anonymous"></script>
</body>
</html>