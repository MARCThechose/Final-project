<?php
include('connection.php');

if(isset($_POST['updateData']))
{
    $id = $_POST['updateId'];
    $name = $_POST['updateName'];
    $quantity = $_POST['updateQuantity'];
    $description = $_POST['updateDescription'];
    $origin = $_POST['updateOrigin'];
    $date_of_arrival = $_POST['updateDateOfArrival'];

    // Use prepared statements to prevent SQL injection
    $stmt = $conn->prepare("UPDATE inventory SET name = ?, quantity = ?, description = ?, origin = ?, date_of_arrival = ? WHERE id = ?");
    $stmt->bind_param("sisssi", $name, $quantity, $description, $origin, $date_of_arrival, $id);

    try {
        if($stmt->execute())
        {
            $_SESSION['message'] = "Item updated successfully.";
            $_SESSION['message_type'] = "success";
            header('Location: inventory.php');
            exit();
        }
    } catch (mysqli_sql_exception $e) {
        $_SESSION['message'] = "Failed to update item. Error: " . $e->getMessage();
        $_SESSION['message_type'] = "danger";
        header('Location: inventory.php');
        exit();
    }
    $stmt->close();
}
?>