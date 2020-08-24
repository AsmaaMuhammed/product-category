<?php

if (isset($_SESSION['user'])) {

    function getAllProducts()
    {
        global $conn;
        $sql = 'SELECT * FROM products ORDER by id';
        $rows = getMultipleRecords($sql);

        $categories = array();

        foreach ($rows as $row) {
            $categories[] = array(
                'id' => $row['id'],
                'category_id' => $row['category_id'],
                'product_name' => $row['name'],
                'profile_picture' => $row['profile_picture']
            );
        }

        return $categories;
    }

// ACTION: Save product
    if (isset($_POST['save_product'])) {
        global $conn;
        // receive form values
        $name = $_POST['name'];
        $category_id = $_POST['category_id'];
        $profile_picture = uploadProfilePicture();

        $sql = "INSERT INTO products SET name=?, profile_picture=?, category_id=?";
        $result = modifyRecord($sql, 'ssi', [$name, $profile_picture, $category_id]);

        if ($result) {
            $_SESSION['success_msg'] = "product created successfully";
            header("location: " . BASE_URL . "admin/products/list.php");
            exit(0);
        } else {
            $_SESSION['error_msg'] = "Something went wrong. Could not save product in Database";
        }
    }
    // ACTION: update product
    if (isset($_POST['update_product'])) {
        $id = $_POST['update_product'];
        global $conn;
        $name = $_POST['category'];
        $parent_id = $_POST['parent_id'];
        $profile_picture = uploadProfilePicture();
        $sql = "UPDATE products SET name=?, profile_picture=?, parent_id=? WHERE id=?";
        $result = modifyRecord($sql, 'ssii', [$name, $profile_picture, $parent_id, $id]);

        if ($result) {
            $_SESSION['success_msg'] = "product updated successfully";
            header("location: " . BASE_URL . "admin/products/list.php");
            exit(0);
        } else {
            $_SESSION['error_msg'] = "Something went wrong. Could not save product in Database";
        }
    }
// ACTION: Delete product
    if (isset($_GET['delete_product'])) {
        $id = $_GET['delete_product'];
        global $conn;
        $sql = "DELETE FROM products WHERE id=?";
        $result = modifyRecord($sql, 'i', [$id]);

        if ($result) {
            $_SESSION['success_msg'] = "product deleted successfully";
            header("location: " . BASE_URL . "admin/products/list.php");
            exit(0);
        } else {
            $_SESSION['error_msg'] = "Something went wrong. Could not save product in Database";
        }
    }
}

?>



