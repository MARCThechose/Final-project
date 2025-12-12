<?php
  include('connection.php');

  if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
  }
  $user_role = $_SESSION['role'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css"
    integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css"
    integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
  <link rel="stylesheet" href="css/style.css">
  <title>Main Menu</title>
</head>

<body>
  <div class="main-menu-container">
    <div class="card main-menu-card">
      <div class="card-body">
        <h3 class="text-center">Main Menu</h3>
        <hr>
        <div class="list-group">
          <a href="index.php" class="list-group-item list-group-item-action">
            <i class="fas fa-users"></i> User Management
          </a>
          <a href="inventory.php" class="list-group-item list-group-item-action">
            <i class="fas fa-boxes"></i> Inventory Management
          </a>
          <a href="logout.php" class="list-group-item list-group-item-action text-danger">
            <i class="fas fa-sign-out-alt"></i> Logout
          </a>
        </div>
      </div>
    </div>
  </div>
</body>

</html>