<?php
  session_start();
  require "connection.php";

  if (!isset($_SESSION['id'])) {
    header("location: index.php");
    exit;
  }

  $_SESSION['section_id'] = "all";
  if (isset($_POST['btn_filter'])) {
    $_SESSION['section_id'] = $_POST['section_id'];
  }

  function getAllProducts($section_id) {
    $conn = connection();

    $where = "";
    if (is_numeric($section_id)) {
      $where = "WHERE products.section_id = $section_id";
    }

    $sql = "SELECT products.id AS id
        , products.name AS `name`
        , products.description AS `description`
        , products.price AS price
        , sections.name AS `section` 
      FROM products 
      INNER JOIN sections ON products.section_id = sections.id 
      $where
      ORDER BY products.id";

    if ($result = $conn->query($sql)) {
      return $result;
    } else {
      die("Error in retrieving the products. " . $conn->error);
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
  
  <title>Products Page</title>
</head>
<body>
  <?php
    include "main-nav.php";
  ?>
  <div class="container">
    <div class="row mb-4">
      <div class="col">
        <h2 class="fw-light">Products</h2>
      </div>
      <div class="col">
        <form action="" method="post">
          <div class="input-group">
            <select name="section_id" id="section-id" 
              class="form-select w-50" required>
              <option value="all">All</option>
              <?php
                // 各レコードにアクセス
                $all_sections = getAllSections();
                while ($section = $all_sections->fetch_assoc()) {
                  if ($section['id'] == $_SESSION['section_id']) {
                    echo "<option value='" . $section['id'] . "' selected>" . $section['name'] . "</option>";
                  } else {
                    echo "<option value='" . $section['id'] . "'>" . $section['name'] . "</option>";
                  }
                }
              ?>
            </select>
            <input type="submit" name="btn_filter" class="btn btn-success" value="Filter">
          </div>
        </form>
      </div>
      <div class="col text-end">
        <a href="add-product.php" class="btn btn-success"><i class="fa-solid fa-circle-plus"></i> New Products</a>
      </div>
    </div>

    <table class="table table-hover align-middle border">
      <thead class="small table-success">
        <tr>
          <th>ID</th>
          <th style="width: 250px">NAME</th>
          <th>DESCRIPTION</th>
          <th>PRICE</th>
          <th>SECTION</th>
          <th style="width: 95px">Action Buttons</th>
        </tr>
      </thead>
      <tbody>
        <?php
          $all_products = getAllProducts($_SESSION['section_id']);
          while ($product = $all_products->fetch_assoc()) {
        ?>
          <tr>
            <td><?=$product['id']?></td>
            <td><?=$product['name']?></td>
            <td><?=$product['description']?></td>
            <td><?=$product['price']?></td>
            <td><?=$product['section']?></td>
            <td>
              <a href="edit-product.php?id=<?=$product['id']?>" 
                class="btn btn-outline-secondary btn-sm"><i class="fa-solid fa-pencil"></i></a>
              <a href="delete-product.php?id=<?=$product['id']?>" 
                class="btn btn-outline-danger btn-sm"><i class="fa-solid fa-trash"></i></a>
            </td>
          </tr>
        <?php
          }
        ?>
      </tbody>
    </table>
  </div>

  <script>
    let select = document.querySelector('[name="section_id"]');

    select.onchange = event => { 
      console.log(select.selectedIndex);
    }
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz"
    crossorigin="anonymous"></script>
</body>
</html>