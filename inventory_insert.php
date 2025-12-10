<?php
include('connection.php');

if(isset($_POST['insertData']))
{
    $name = $_POST['name'];
    $quantity = $_POST['quantity'];
    $description = $_POST['description'];
    $origin = $_POST['origin'];
    $date_of_arrival = $_POST['date_of_arrival'];

    // Use prepared statements to prevent SQL injection
    $stmt = $conn->prepare("INSERT INTO inventory (name, quantity, description, origin, date_of_arrival) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sisss", $name, $quantity, $description, $origin, $date_of_arrival);

    try {
        if($stmt->execute())
        {
            $_SESSION['message'] = "Item added successfully.";
            $_SESSION['message_type'] = "success";
            header('Location: inventory.php');
            exit();
        }
    } catch (mysqli_sql_exception $e) {
        $_SESSION['message'] = "Failed to add item. Error: " . $e->getMessage();
        $_SESSION['message_type'] = "danger";
        header('Location: inventory.php');
        exit();
    }
    $stmt->close();
}
?>