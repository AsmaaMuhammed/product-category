<?php include('../../config.php') ?>
<?php include(ROOT_PATH . '/admin/products/logic.php') ?>
<?php include(INCLUDE_PATH . '/logic/common_functions.php') ?>
<?php

?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title> Products </title>
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css" />
  <!-- Custome styles -->
  <link rel="stylesheet" href="../../assets/css/style.css">
</head>
<body>
  <?php include(INCLUDE_PATH . "/layouts/navbar.php") ?>
  <div class="col-md-8 col-md-offset-2">
    <a href="form.php" class="btn btn-success">
      <span class="glyphicon glyphicon-plus"></span>
      Create new Product
    </a>
    <br/><br/>
    <div class="row col-md-12">
      <table class="table table-bordered">
        <thead>
        <tr>
          <th>N</th>
          <th>Photo</th>
          <th>Name</th>
          <th>category</th>
          <th colspan="4" class="text-center">Action</th>
        </tr>
        </thead>
        <tbody>
        <?php $products = getAllProducts(); ?>
        <?php foreach ($products as $key => $value): ?>
          <tr>
            <td><?php echo $key + 1; ?></td>
            <td>
              <?php if (!empty($value['profile_picture'])): ?>
                <img src="<?php echo BASE_URL . '/assets/images/' . $value['profile_picture'] ?>" id="profile_img" style="height: 100px; border-radius: 50%" alt="">
              <?php else: ?>
                <img src="http://via.placeholder.com/150x150" id="profile_img" style="height: 100px; border-radius: 50%" alt="">
              <?php endif; ?>
            </td>
            <td><?php echo $value['product_name'] ?></td>
            <td><?php echo getParentCategoryName($value['category_id']) ?></td>

            <td class="text-center">
              <a href="<?php echo BASE_URL ?>admin/products/form.php?edit_product=<?php echo $value['id'] ?>" class="btn btn-sm btn-success">
                <span class="glyphicon glyphicon-pencil">Edit</span>
              </a>
            </td>
            <td class="text-center">
              <a href="<?php echo BASE_URL ?>admin/products/form.php?delete_product=<?php echo $value['id'] ?>" class="btn btn-sm btn-danger">
                <span class="glyphicon glyphicon-trash">Delete</span>
              </a>
            </td>
          </tr>
        <?php endforeach; ?>
        </tbody>
      </table>
    </div>

  </div>
  <?php include(INCLUDE_PATH . "/layouts/footer.php") ?>
</body>
</html>
