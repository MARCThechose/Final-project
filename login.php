<?php
  if(isset($_SESSION['user_id'])){
    header('Location: main_menu.php');
    exit();
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css"
    integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
  <div class="container vh-100 d-flex justify-content-center align-items-center">
    <div class="col-md-5">
      <div class="card">
        <div class="card-header text-center">
          <h3><i class="fas fa-sign-in-alt"></i> Login</h3>
        </div>
        <div class="card-body">
          <?php if(isset($_GET['error'])): ?>
              <div class="alert alert-danger"><?php echo htmlspecialchars($_GET['error']); ?></div>
          <?php endif; ?>
          <form action="login_process.php" method="POST">
            <div class="form-group">
              <label for="username"><i class="fas fa-user"></i> Username</label>
              <input type="text" name="username" id="username" class="form-control" required>
            </div>
            <div class="form-group">
              <label for="password"><i class="fas fa-lock"></i> Password</label>
              <input type="password" name="password" id="password" class="form-control" required>
            </div>
            <div class="form-group">
              <button type="submit" class="btn btn-primary btn-block">Login</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</body>
</html>