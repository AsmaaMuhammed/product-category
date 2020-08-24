<?php

function loginById($user_id) {
    global $conn;

    $sql = "SELECT u.id, u.username
            FROM users u  WHERE u.id=? LIMIT 1";
    $user = getSingleRecord($sql, 'i', [$user_id]);
    if (!empty($user)) {
        // put logged in user into session array
        $_SESSION['user'] = $user;
        $_SESSION['success_msg'] = "You are now logged in";
        header('location: ' . BASE_URL . 'admin/categories/list.php');
    }
    exit(0);
}
// Accept a user object, validates user and return an array with the error messages
function validateUser($user, $ignoreFields) {
    global $conn;
    $errors = [];
    // password confirmation
    if (isset($user['passwordConf']) && ($user['password'] !== $user['passwordConf'])) {
        $errors['passwordConf'] = "The two passwords do not match";
    }
    // if passwordOld was sent, then verify old password
    if (isset($user['passwordOld']) && isset($user['user_id'])) {
        $sql = "SELECT * FROM users WHERE id=? LIMIT 1";
        $oldUser = getSingleRecord($sql, 'i', [$user['user_id']]);
        $prevPasswordHash = $oldUser['password'];
        if (!password_verify($user['passwordOld'], $prevPasswordHash)) {
            $errors['passwordOld'] = "The old password does not match";
        }
    }
    // the email should be unique for each user for cases where we are saving admin user or signing up new user
    if (in_array('save_user', $ignoreFields) || in_array('signup_btn', $ignoreFields)) {
        $sql = "SELECT * FROM users WHERE email=? OR username=? LIMIT 1";
        $oldUser = getSingleRecord($sql, 'ss', [$user['email'], $user['username']]);
        if (!empty($oldUser['email']) && $oldUser['email'] === $user['email']) { // if user exists
            $errors['email'] = "Email already exists";
        }
        if (!empty($oldUser['username']) && $oldUser['username'] === $user['username']) { // if user exists
            $errors['username'] = "Username already exists";
        }
    }

    // required validation
    foreach ($user as $key => $value) {
        if (in_array($key, $ignoreFields)) {
            continue;
        }
        if (empty($user[$key])) {
            $errors[$key] = "This field is required";
        }
    }
    return $errors;
}
if (isset($_SESSION['user'])) {


    function getParentCategoryName($id)
    {
        $sql = "SELECT c.id, c.category as category_name
            FROM categories c  WHERE c.id=? LIMIT 1";
        $parent = getSingleRecord($sql, 'i', [$id]);
        if (!empty($parent)) {
            return $parent['category_name'];
        } else
            return '';
    }
    function getAllCategories()
    {
        global $conn;
        $sql = 'SELECT * FROM categories ORDER by id';
        $rows = getMultipleRecords($sql);

        $categories = array();

        foreach ($rows as $row) {
            $categories[] = array(
                'id' => $row['id'],
                'parent_id' => $row['parent_id'],
                'category_name' => $row['category']
            );
        }

        return $categories;
    }

    function categories()
    {
        global $conn;
        $sql = 'SELECT * FROM categories WHERE parent_id=0';
        $rows = getMultipleRecords($sql);

        $categories = array();

        foreach ($rows as $row) {
            $categories[] = array(
                'id' => $row['id'],
                'parent_id' => $row['parent_id'],
                'category_name' => $row['category'],
                'subcategory' => sub_categories($row['id']),
            );
        }

        return $categories;
    }

    function sub_categories($id)
    {
        global $conn;
        $sql = "SELECT * FROM categories  WHERE parent_id=$id";
        $rows = getMultipleRecords($sql);
        $categories = array();

        foreach ($rows as $row) {
            $categories[] = array(
                'id' => $row['id'],
                'parent_id' => $row['parent_id'],
                'category_name' => $row['category'],
                'subcategory' => sub_categories($row['id']),
            );
        }
        return $categories;
    }

    function viewsubcat($categories)
    {
        $html = '<ul class="sub-category">';
        foreach ($categories as $category) {
            $href = BASE_URL.'/admin/categories/form.php?edit_category='.$category['id'] ;
            $html .= '<li><a href="'.$href.'">' . $category['category_name'] . '</a></li>';

            if (!empty($category['subcategory'])) {
                $html .= viewsubcat($category['subcategory']);
            }
        }
        $html .= '</ul>';

        return $html;
    }
}
