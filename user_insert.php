<?php
include('connection.php');

if(isset($_POST['insertData']))
{
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    $stmt = $conn->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $password, $role);
    
    try {
        if($stmt->execute())
        {
            $_SESSION['message'] = "User added successfully";
            $_SESSION['message_type'] = "success";
            header('Location: index.php');
            exit();
        }
    } catch (mysqli_sql_exception $e) {
        if ($e->getCode() == 1062) { // 1062 is the error code for a duplicate entry
            $_SESSION['message'] = "Username already exists.";
            $_SESSION['message_type'] = "danger";
        } else {
            $_SESSION['message'] = "Failed to add user.";
            $_SESSION['message_type'] = "danger";
        }
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit();
    }
}
?>