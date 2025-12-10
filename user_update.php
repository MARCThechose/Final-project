<?php
include('connection.php');
    try {
        if($stmt->execute())
        {
            $_SESSION['message'] = "User updated successfully";
            $_SESSION['message_type'] = "success";
            header('Location: index.php');
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
?>