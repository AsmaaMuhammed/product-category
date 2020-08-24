<?php include('../../config.php') ?>
<?php include(ROOT_PATH . '/admin/categories/logic.php') ?>
<?php include(INCLUDE_PATH . '/logic/common_functions.php') ?>
<?php
$categories = getAllCategories();
if (isset($_GET['edit_category'])) {
    $id = $_GET['edit_category'];
    global $conn, $name,$parent_id, $isEditting;
    $sql = "SELECT * FROM categories WHERE id=? LIMIT 1";
    $category = getSingleRecord($sql, 'i', [$id]);
    $category_id = $category['id'];
    $categoryName = $category['category'];
    $parent_id = $category['parent_id'];
    $isEditting = true;
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Create new Category </title>
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css" />
  <!-- Custom styles -->
  <link rel="stylesheet" href="../../assets/css/style.css">
</head>
<body>
  <?php include(INCLUDE_PATH . "/layouts/navbar.php") ?>
  <div class="col-md-8 col-md-offset-2">
      <a href="list.php" class="btn btn-primary">
        <span class="glyphicon glyphicon-chevron-left"></span>
        Categories
      </a>
      <hr>
      <form class="form" action="form.php" method="post">
        <?php if (isset($_GET['edit_category'])): ?>
          <h1 class="text-center">Update Category</h1>
        <?php else: ?>
          <h1 class="text-center">Create Category</h1>
        <?php endif; ?>
        <br />
          <?php if (isset($_GET['edit_category'])): ?>
              <input type="hidden" name="category_id" value="<?php echo $_GET['edit_category']; ?>">
          <?php endif; ?>
          <?php if (isset($_GET['parent_id'])): ?>
              <input type="hidden" name="parent_id" value="<?php echo $_GET['parent_id']; ?>">
          <?php endif; ?>
          <div class="form-group <?php echo isset($errors['category']) ? 'has-error': '' ?>">
              <label class="control-label">Category</label>
              <input type="text" required name="category" value="<?php echo $categoryName; ?>" class="form-control">
              <?php if (isset($errors['category'])): ?>
                  <span class="help-block"><?php echo $errors['category'] ?></span>
              <?php endif; ?>
          </div>
          <?php if(!isset($_GET['parent_id'])): ?>
              <div class="form-group <?php echo isset($errors['parent_id']) ? 'has-error' : '' ?>">
                  <label class="control-label">Parent Category</label>
                  <select required class="form-control" name="parent_id">
                      <option value="0" >Select Parent Category</option>
                      <?php foreach ($categories as $cat): ?>
                          <?php if ($cat['id'] == $parent_id): ?>
                              <option value="<?php echo $cat['id'] ?>" selected><?php echo $cat['category_name'] ?></option>
                          <?php else: ?>
                              <option value="<?php echo $cat['id'] ?>"><?php echo $cat['category_name'] ?></option>
                          <?php endif; ?>
                      <?php endforeach; ?>
                  </select>
                  <?php if (isset($errors['parent_id'])): ?>
                      <span class="help-block"><?php echo $errors['parent_id'] ?></span>
                  <?php endif; ?>
              </div>
          <?php endif; ?>
        <div class="form-group">
          <?php if (isset($_GET['edit_category'])): ?>
            <button type="submit" name="update_category" value="<?php echo $category_id; ?>" class="btn btn-primary">Update Category</button>
          <?php else: ?>
            <button type="submit" name="save_category" class="btn btn-success">Save Category</button>
          <?php endif; ?>
        </div>
      </form>
  </div>
  <?php include(INCLUDE_PATH . "/layouts/footer.php") ?>
</body>
</html>