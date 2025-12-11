<?php
  include('connection.php');

  if (isset($_SESSION['user_id'])) {
    header('Location: main_menu.php');
    exit();
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css"
    integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
  <link rel="stylesheet" href="css/style.css">
  <title>Welcome</title>
</head>
<body>
  <div class="container mt-5">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="card text-center">
          <div class="card-header">
            <h1>Welcome to the Inventory Management System</h1>
          </div>
          <div class="card-body">
            <p>Please log in to continue.</p>
            <a href="login.php" class="btn btn-primary">Login</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>
</html>