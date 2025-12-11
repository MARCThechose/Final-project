<?php
include('connection.php');

if(isset($_POST['updateData']))
{
    $id = $_POST['updateId'];
    $username = $_POST['updateUsername'];
    $password = $_POST['updatePassword'];
    $role = $_POST['updateRole'];

    // Check if password is empty
    if(empty($password)) {
        // Update user without changing the password
        $stmt = $conn->prepare("UPDATE users SET username=?, role=? WHERE id=?");
        $stmt->bind_param("ssi", $username, $role, $id);
    } else {
        // Update user with a new password
        $stmt = $conn->prepare("UPDATE users SET username=?, password=?, role=? WHERE id=?");
        $stmt->bind_param("sssi", $username, $password, $role, $id);
    }

    try {
        if($stmt->execute())
        {
            $_SESSION['message'] = "User updated successfully";
            $_SESSION['message_type'] = "success";
            header('Location: user_management.php');
            exit();
        }
    } catch (mysqli_sql_exception $e) {
        if ($e->getCode() == 1062) { // 1062 is the error code for a duplicate entry
            $_SESSION['message'] = "Username already exists.";
            $_SESSION['message_type'] = "danger";
        } else {
            $_SESSION['message'] = "Failed to update user.";
            $_SESSION['message_type'] = "danger";
        }
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit();
    }
}
?>