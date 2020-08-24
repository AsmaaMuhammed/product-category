<?php
if (isset($_SESSION['user'])) {


// ACTION: Save category
    if (isset($_POST['save_category'])) {
        saveCategory();
    }
// ACTION: update category
    if (isset($_POST['update_category'])) {
        $category_id = $_POST['update_category'];
        updateCategory($category_id);
    }
// ACTION: Delete category
    if (isset($_GET['delete_category'])) {
        $category_id = $_GET['delete_category'];
        deleteCategory($category_id);
    }

// Save category to database
    function saveCategory()
    {
        global $conn;
        // receive form values
        $name = $_POST['category'];
        $parent_id = $_POST['parent_id'];

        $sql = "INSERT INTO categories SET category=?, parent_id=?";
        $result = modifyRecord($sql, 'si', [$name, $parent_id]);

        if ($result) {
            $_SESSION['success_msg'] = "category created successfully";
            header("location: " . BASE_URL . "admin/categories/list.php");
            exit(0);
        } else {
            $_SESSION['error_msg'] = "Something went wrong. Could not save category in Database";
        }

    }

    function updateCategory($id)
    {
        global $conn;
        $name = $_POST['category'];
        $parent_id = $_POST['parent_id'];

        $sql = "UPDATE categories SET category=?, parent_id=? WHERE id=?";
        $result = modifyRecord($sql, 'sii', [$name, $parent_id, $id]);

        if ($result) {
            $_SESSION['success_msg'] = "category updated successfully";
            header("location: " . BASE_URL . "admin/categories/list.php");
            exit(0);
        } else {
            $_SESSION['error_msg'] = "Something went wrong. Could not save category in Database";
        }
    }


    function deleteCategory($id)
    {

        global $conn;
        $sql = "DELETE FROM categories WHERE id=?";
        $result = modifyRecord($sql, 'i', [$id]);

        $sql2 = "UPDATE categories SET parent_id=0 WHERE parent_id =?";
        $result2 = modifyMultipleRecord($sql2, 'ii', [$id]);

        if ($result) {
            $_SESSION['success_msg'] = "category deleted successfully";
            header("location: " . BASE_URL . "admin/categories/list.php");
            exit(0);
        } else {
            $_SESSION['error_msg'] = "Something went wrong. Could not save category in Database";
        }

    }
}





