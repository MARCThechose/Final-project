<?php
header('Content-Type: application/json');
include('connection.php');

$response = ['description' => ''];

if(isset($_POST['id']))
{
    $id = $_POST['id'];
    
    // Use prepared statements to prevent SQL injection
    $stmt = $conn->prepare("SELECT description FROM inventory WHERE id = ?");
    $stmt->bind_param("i", $id);
    
    try {
        if($stmt->execute())
        {
            $result = $stmt->get_result();
            if($row = $result->fetch_assoc())
            {
                $response['description'] = $row['description'];
            }
        }
    } catch (mysqli_sql_exception $e) {
        $response['error'] = 'Failed to get item details. Error: ' . $e->getMessage();
    }
    $stmt->close();
}

echo json_encode($response);
?>
