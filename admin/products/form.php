<?php include('../../config.php') ?>
<?php include(ROOT_PATH . '/admin/products/logic.php') ?>
<?php include(INCLUDE_PATH . '/logic/common_functions.php') ?>



<?php
$categories = getAllCategories();
if (isset($_GET['edit_product'])) {
    $id = $_GET['edit_product'];
    global $conn, $name,$parent_id, $isEditting;
    $sql = "SELECT * FROM products WHERE id=? LIMIT 1";
    $product = getSingleRecord($sql, 'i', [$id]);
    $product_id = $product['id'];
    $name = $product['name'];
    $category_id = $product['category_id'];
    $profile_picture = $product['profile_picture'];
    $isEditting = true;

}
// upload's user profile profile picture and returns the name of the file
function uploadProfilePicture()
{
    // if file was sent from signup form ...
    if (!empty($_FILES) && !empty($_FILES['profile_picture']['name'])) {
        // Get image name
        $profile_picture = date("Y.m.d") . $_FILES['profile_picture']['name'];
        // define Where image will be stored
        $target = ROOT_PATH . "/assets/images/" . $profile_picture;
        // upload image to folder
        if (move_uploaded_file($_FILES['profile_picture']['tmp_name'], $target)) {
            return $profile_picture;
            exit();
        }else{
            echo "Failed to upload image";
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Create new Product </title>
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
        Products
      </a>
      <hr>
      <form class="form" action="form.php" method="post">
          <?php if (isset($_GET['edit_product'])): ?>
              <h1 class="text-center">Update Product</h1>
          <?php else: ?>
              <h1 class="text-center">Create Product</h1>
          <?php endif; ?>
          <br />
          <?php if (isset($_GET['edit_product'])): ?>
              <input type="hidden" name="product_id" value="<?php echo $_GET['edit_product']; ?>">
          <?php endif; ?>
          <?php if (isset($_GET['category_id'])): ?>
              <input type="hidden" name="category_id" value="<?php echo $_GET['category_id']; ?>">
          <?php endif; ?>
          <div class="form-group <?php echo isset($errors['name']) ? 'has-error': '' ?>">
              <label class="control-label">Product</label>
              <input type="text" required name="name" value="<?php echo $name; ?>" class="form-control">
              <?php if (isset($errors['name'])): ?>
                  <span class="help-block"><?php echo $errors['name'] ?></span>
              <?php endif; ?>
          </div>
          <?php if(!isset($_GET['category_id'])): ?>
              <div class="form-group <?php echo isset($errors['category_id']) ? 'has-error' : '' ?>">
                  <label class="control-label">Category Product</label>
                  <select required class="form-control" name="category_id">
                      <option value="" >Select Category</option>
                      <?php foreach ($categories as $cat): ?>
                          <?php if ($cat['id'] == $category_id): ?>
                              <option value="<?php echo $cat['id'] ?>" selected><?php echo $cat['category_name'] ?></option>
                          <?php else: ?>
                              <option value="<?php echo $cat['id'] ?>"><?php echo $cat['category_name'] ?></option>
                          <?php endif; ?>
                      <?php endforeach; ?>
                  </select>
                  <?php if (isset($errors['category_id'])): ?>
                      <span class="help-block"><?php echo $errors['category_id'] ?></span>
                  <?php endif; ?>
              </div>
          <?php endif; ?>
          <div class="form-group" style="text-align: center;">
              <?php if (!empty($profile_picture)): ?>
                  <img src="<?php echo BASE_URL . '/assets/images/' . $profile_picture; ?>" id="profile_img" style="height: 100px; border-radius: 50%" alt="">
              <?php else: ?>
                  <img src="http://via.placeholder.com/150x150" id="profile_img" style="height: 100px; border-radius: 50%" alt="">
              <?php endif; ?>
              <input type="file" required name="profile_picture" id="profile_input" value="<?php echo $profile_picture; ?>">
          </div>
          <div class="form-group">
              <?php if (isset($_GET['edit_product'])): ?>
                  <button type="submit" name="update_product" value="<?php echo $category_id; ?>" class="btn btn-primary">Update Product</button>
              <?php else: ?>
                  <button type="submit" name="save_product" class="btn btn-success">Save Product</button>
              <?php endif; ?>
          </div>
      </form>
  </div>
  <?php include(INCLUDE_PATH . "/layouts/footer.php") ?>
</body>
</html>