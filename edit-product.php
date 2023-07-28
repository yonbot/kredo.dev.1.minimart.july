<?php
  session_start();
  require "connection.php";

  if (!isset($_SESSION['id'])) {
    header("location: index.php");
    exit;
  }

  $id = $_GET['id'];
  $product = getProduct($id); // $product is an associative array


  function getProduct($id) {
    $conn = connection(); // connection object
    $sql = "SELECT * FROM products WHERE id = $id";

    if ($result = $conn->query($sql)) {
      // while ($product = $result->fetch_assoc()) {
      //   return $product;
      // }
      return $result->fetch_assoc();
      // This will return 1 row of record
    } else {
      die("Error in retrieving the product details " . $conn->error);
    }
  }

  function getAllSections() {
    $conn = connection(); // connection object
    $sql = "SELECT * FROM sections";

    if ($result = $conn->query($sql)) {
      return $result;
    } else {
      die("Error in retrieving sections " . $conn->error);
    }
  }

  function updateProducts($id, $name, $description, $price, $section_id) {
    $conn = connection();
    $sql = "UPDATE products 
      SET `name` = '$name', `description`='$description',
          `price` = $price, `section_id` = $section_id
      WHERE id = $id";

    if ($conn->query($sql)) {
      header("location: products.php");
      exit;
    } else {
      die("Error in updating the product details. " . $conn->error);
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
  
  <title>Edit Product</title>
</head>
<body>
  <?php
    include "main-nav.php";
  ?>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-6">
        <h3 class="fw-light mb-3">Edit Product</h3>

        <form action="" method="post">
          <div class="mb-3">
            <label for="name" class="form-label small fw-bold">Name</label>
            <input type="text" name="name" id="name" 
              class="form-control" max="50" 
              value="<?=$product['name']?>"
              required>
          </div>
          <div class="mb-3">
            <label for="description" class="form-label small fw-bold">Description</label>
            <textarea name="description" id="description" 
              class="form-control" rows="5" 
              required><?=$product['description']?></textarea>
          </div>
          <div class="mb-3">
            <label for="price" class="form-label small fw-bold">Price</label>
            <div class="input-group">
              <div class="input-group-text">$</div>
              <input type="number" name="price" id="price"
                class="form-control" step="any" 
                value="<?=$product['price']?>"
                required>
            </div>
          </div>
          <div class="mb-4">
            <label for="section-id" class="form-label small fw-bold">Section</label>
            <select name="section_id" id="section-id" 
              class="form-select" required>
              <option value="" hidden>Select Option</option>
              <?php
                // 各レコードにアクセス
                $all_sections = getAllSections();
                while ($section = $all_sections->fetch_assoc()) {
                  if ($section['id'] == $product['section_id']) {
                    echo "<option value='" . $section['id'] . "' selected>" . $section['name'] . "</option>";
                  } else {
                    echo "<option value='" . $section['id'] . "'>" . $section['name'] . "</option>";
                  }
                }
              ?>
            </select>
          </div>
          <a href="products.php" class="btn btn-outline-secondary">Cancel</a>
          <button type="submit" name="btn_update" 
            class="btn btn-secondary fw-bold">
            <i class="fa-solid fa-check"></i> Save Changes
          </button>
        </form>

        <!-- Collect the data from the form -->
        <?php
          if (isset($_POST['btn_update'])) {
            $id = $_GET['id'];
            $name = $_POST['name'];
            $description = $_POST['description'];
            $price = $_POST['price'];
            $section_id = $_POST['section_id'];

            // $_SESSION['name'] = $name;
            // $_SESSION['description'] = $description;
            // $_SESSION['price'] = $price;
            // $_SESSION['section_id'] = $section_id;

            // recieved the datas here...
            updateProducts($id, $name, $description, $price, $section_id);
          }
        ?>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz"
    crossorigin="anonymous"></script>
</body>
</html>
