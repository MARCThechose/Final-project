<?php
include('connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    try {
        // Use prepared statements to prevent SQL injection
        $stmt = $conn->prepare("SELECT id, username, password, role FROM users WHERE username = ?");
        if ($stmt === false) {
            header("Location: login.php?error=Database error.");
            exit();
        }
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            $user = $result->fetch_assoc();
            if ($password === $user['password']) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['role'] = $user['role'];
                header("Location: main_menu.php");
                exit();
            } else {
                header("Location: login.php?error=Invalid username or password.");
                exit();
            }
        } else {
            header("Location: login.php?error=Invalid username or password.");
            exit();
        }
        $stmt->close();
    } catch (mysqli_sql_exception $e) {
        header("Location: login.php?error=An error occurred. Error: " . $e->getMessage());
        exit();
    }
} else {
    header("Location: login.php");
    exit();
}
?>