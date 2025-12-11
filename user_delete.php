<?php
include('connection.php');

if(isset($_POST['deleteData']))
{
    $id_to_delete = $_POST['deleteId'];
    $logged_in_user_id = $_SESSION['user_id'];
    $logged_in_user_role = $_SESSION['role'];

    try {
        // Fetch the role of the user being deleted
        $stmt_check_user = $conn->prepare("SELECT id, role FROM users WHERE id = ?");
        $stmt_check_user->bind_param("i", $id_to_delete);
        $stmt_check_user->execute();
        $result_check_user = $stmt_check_user->get_result();
        $user_to_delete = $result_check_user->fetch_assoc();
        $stmt_check_user->close();

        if ($user_to_delete) {
            // Safeguard: Prevent deleting self
            if ($id_to_delete == $logged_in_user_id) {
                $_SESSION['message'] = "You cannot delete your own account!";
                $_SESSION['message_type'] = "danger";
                header('Location: user_management.php');
                exit();
            }

            // If safeguards pass, proceed with deletion
            $stmt_delete = $conn->prepare("DELETE FROM users WHERE id = ?");
            $stmt_delete->bind_param("i", $id_to_delete);
            
            $stmt_delete->execute();
            $_SESSION['message'] = "User deleted successfully";
            $_SESSION['message_type'] = "success";
            header('Location: user_management.php');
            exit();
            $stmt_delete->close();
        } else {
            $_SESSION['message'] = "User not found!";
            $_SESSION['message_type'] = "danger";
            header('Location: user_management.php');
            exit();
        }
    } catch (mysqli_sql_exception $e) {
        echo '<script> alert("An error occurred. Error: ' . $e->getMessage() . '"); </script>';
        echo '<script> window.history.back(); </script>';
    }
}
?>