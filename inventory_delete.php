<?php
include('connection.php');

if(isset($_POST['deleteData']))
{
    $id = $_POST['deleteId'];

    // Use prepared statements to prevent SQL injection
    $stmt = $conn->prepare("DELETE FROM inventory WHERE id = ?");
    $stmt->bind_param("i", $id);

    try {
        if($stmt->execute())
        {
            $_SESSION['message'] = "Item deleted successfully.";
            $_SESSION['message_type'] = "success";
            header('Location: inventory.php');
            exit();
        }
    } catch (mysqli_sql_exception $e) {
        $_SESSION['message'] = "Failed to delete item. Error: " . $e->getMessage();
        $_SESSION['message_type'] = "danger";
        header('Location: inventory.php');
        exit();
    }
    $stmt->close();
}
?>