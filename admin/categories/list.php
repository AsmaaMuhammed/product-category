<?php include('../../config.php') ?>
<?php include(ROOT_PATH . '/admin/categories/logic.php') ?>
<?php include(INCLUDE_PATH . '/logic/common_functions.php') ?>
<?php

?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title> Categories </title>
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css" />
  <!-- Custome styles -->
  <link rel="stylesheet" href="../../assets/css/style.css">
</head>
<body>
  <?php include(INCLUDE_PATH . "/layouts/navbar.php") ?>
  <div class="col-md-8 col-md-offset-2">
    <a href="form.php?parent_id=0" class="btn btn-success">
      <span class="glyphicon glyphicon-plus"></span>
      Create Parent Category
    </a>

<br/><br/>


  <div class="row">

    <?php $categories = categories(); ?>
    <?php foreach($categories as $category){ ?>
      <ul class="category">
        <li><a href="<?php echo BASE_URL ?>admin/categories/form.php?edit_category=<?php echo $category['id'] ?>"><?php echo $category['category_name'] ?></a></li>
        <?php
        if( ! empty($category['subcategory'])){
          echo viewsubcat($category['subcategory']);
        }
        ?>
      </ul>
    <?php } ?>

  </div>
  <br/><br/>

    <div class="row col-md-12">
      <table class="table table-bordered">
        <thead>
        <tr>
          <th>N</th>
          <th>Name</th>
          <th>Parent</th>
          <th colspan="4" class="text-center">Action</th>
        </tr>
        </thead>
        <tbody>
        <?php $categories = getAllCategories(); ?>
        <?php foreach ($categories as $key => $value): ?>
          <tr>
            <td><?php echo $key + 1; ?></td>
            <td><?php echo $value['category_name'] ?></td>
            <td><?php echo getParentCategoryName($value['parent_id']) ?></td>
            <td class="text-center">
              <a href="<?php echo BASE_URL ?>admin/products/form.php?category_id=<?php echo $value['id'] ?>" class="btn btn-sm btn-success">
                <span class="glyphicon glyphicon-plus">New Product</span>
              </a>
            </td>
            <td class="text-center">
              <a href="<?php echo BASE_URL ?>admin/categories/form.php?parent_id=<?php echo $value['id'] ?>" class="btn btn-sm btn-success">
                <span class="glyphicon glyphicon-plus">New Sub Category</span>
              </a>
            </td>
            <td class="text-center">
              <a href="<?php echo BASE_URL ?>admin/categories/form.php?edit_category=<?php echo $value['id'] ?>" class="btn btn-sm btn-success">
                <span class="glyphicon glyphicon-pencil">Edit</span>
              </a>
            </td>
            <td class="text-center">
              <a href="<?php echo BASE_URL ?>admin/categories/form.php?delete_category=<?php echo $value['id'] ?>" class="btn btn-sm btn-danger">
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
