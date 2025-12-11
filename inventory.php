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
  <title>Inventory Management</title>
  <link rel="icon" href="icon/ipxel.svg" type="image/svg+xml">
</head>

<body>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="#">Inventory System</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item">
          <a class="nav-link" href="main_menu.php"><i class="fas fa-arrow-left"></i> Back to Main Menu</a>
        </li>
      </ul>
      <form action="inventory.php" method="GET" class="form-inline my-2 my-lg-0">
        <input type="text" name="search" class="form-control mr-sm-2" placeholder="Search by name or origin" value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
        <button type="submit" class="btn btn-outline-success my-2 my-sm-0">
          <i class="fas fa-search"></i> Search
        </button>
        <?php if (isset($_GET['search']) && !empty($_GET['search'])): ?>
          <a href="inventory.php" class="btn btn-outline-secondary my-2 my-sm-0 ml-2">
            <i class="fas fa-times"></i> Clear
          </a>
        <?php endif; ?>
      </form>
      <ul class="navbar-nav ml-auto">
        <li class="nav-item">
          <a class="nav-link" href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
        </li>
      </ul>
    </div>
  </nav>

  <div class="container mt-5">
    <?php
      if (isset($_SESSION['message']) && isset($_SESSION['message_type'])) {
        echo '<div class="alert alert-' . $_SESSION['message_type'] . ' alert-dismissible fade show" role="alert">
                ' . $_SESSION['message'] . '
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>';
        unset($_SESSION['message']);
        unset($_SESSION['message_type']);
      }
    ?>

    <div class="card">
      <div class="card-header text-center">
        <h2>Inventory Management</h2>
      </div>
      <div class="card-body">
        <button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#addModal">
          <i class="fas fa-plus"></i> Add New Item
        </button>

        <table class="table table-striped table-bordered">
          <thead class="bg-dark text-white">
            <tr>
              <th>#</th>
              <th>Name</th>
              <th>Quantity</th>
              <th>Origin</th>
              <th>Date of Arrival</th>
              <th>Last Updated</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $results_per_page = 10;
            $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
            $page = max(1, $page);
            $start_limit = ($page - 1) * $results_per_page;

            $search_sql = '';
            if(isset($_GET['search']) && !empty($_GET['search'])){
              $search = mysqli_real_escape_string($conn, $_GET['search']);
              $search_sql = " WHERE name LIKE '%$search%' OR origin LIKE '%$search%'";
            }

            $count_sql = "SELECT COUNT(id) AS total FROM inventory" . $search_sql;
            $count_result = mysqli_query($conn, $count_sql);
            $total_row = mysqli_fetch_assoc($count_result);
            $total_results = $total_row['total'];
            $total_pages = ceil($total_results / $results_per_page);
            
            $sql = "SELECT id, name, quantity, origin, date_of_arrival, last_updated FROM inventory" . $search_sql . " LIMIT $start_limit, $results_per_page";

            $result = mysqli_query($conn, $sql);
            $i = $start_limit + 1;

            if(mysqli_num_rows($result) > 0)
            {
              while($row = mysqli_fetch_assoc($result)){
                ?>
                <tr>
                  <td><?php echo $i; ?></td>
                  <td><?php echo $row['name']; ?></td>
                  <td><?php echo $row['quantity']; ?></td>
                  <td><?php echo $row['origin']; ?></td>
                  <td><?php echo $row['date_of_arrival']; ?></td>
                  <td><?php echo $row['last_updated']; ?></td>
                  <td>
                    <button type="button" class="btn btn-info btn-sm viewBtn" data-id="<?php echo $row['id']; ?>"> <i class="fas fa-eye"></i></button>
                    <button type="button" class="btn btn-warning btn-sm updateBtn" data-id="<?php echo $row['id']; ?>"> <i class="fas fa-edit"></i></button>
                    <button type="button" class="btn btn-danger btn-sm deleteBtn" data-id="<?php echo $row['id']; ?>"> <i class="fas fa-trash-alt"></i></button>
                  </td>
                </tr>
                <?php
                $i++;
              }
            }else{
              echo "<tr><td colspan='7' class='text-center'>No inventory items found.</td></tr>";
            }
            ?>
          </tbody>
        </table>

        <!-- Pagination -->
        <nav aria-label="Page navigation">
          <ul class="pagination justify-content-center">
            <?php if ($page > 1): ?>
              <li class="page-item"><a class="page-link" href="?page=<?php echo $page - 1; ?><?php echo isset($_GET['search']) ? '&search=' . htmlspecialchars($_GET['search']) : ''; ?>">Previous</a></li>
            <?php endif; ?>
            <?php for ($p = 1; $p <= $total_pages; $p++): ?>
              <li class="page-item <?php echo ($p == $page) ? 'active' : ''; ?>"><a class="page-link" href="?page=<?php echo $p; ?><?php echo isset($_GET['search']) ? '&search=' . htmlspecialchars($_GET['search']) : ''; ?>"><?php echo $p; ?></a></li>
            <?php endfor; ?>
            <?php if ($page < $total_pages): ?>
              <li class="page-item"><a class="page-link" href="?page=<?php echo $page + 1; ?><?php echo isset($_GET['search']) ? '&search=' . htmlspecialchars($_GET['search']) : ''; ?>">Next</a></li>
            <?php endif; ?>
          </ul>
        </nav>
      </div>
    </div>
  </div>

  <!-- MODALS -->

  <!-- ADD ITEM MODAL -->
  <div class="modal fade" id="addModal">
    <div class="modal-dialog modal-md">
      <div class="modal-content">
        <div class="modal-header bg-primary text-white">
          <h5 class="modal-title">Add New Inventory Item</h5>
          <button class="close" data-dismiss="modal">
            <span>&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="inventory_insert.php" method="POST">
            <div class="form-group">
              <label for="name">Name</label>
              <input type="text" name="name" class="form-control" placeholder="Enter item name" required>
            </div>
            <div class="form-group">
              <label for="quantity">Quantity</label>
              <input type="number" name="quantity" class="form-control" placeholder="Enter quantity" required>
            </div>
            <div class="form-group">
              <label for="description">Description</label>
              <textarea name="description" class="form-control" placeholder="Enter description"></textarea>
            </div>
            <div class="form-group">
              <label for="origin">Origin</label>
              <input type="text" name="origin" class="form-control" placeholder="Enter origin">
            </div>
            <div class="form-group">
              <label for="date_of_arrival">Date of Arrival</label>
              <input type="date" name="date_of_arrival" class="form-control" required>
            </div>
            <div class="modal-footer">
              <button type="submit" class="btn btn-primary" name="insertData">Save</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- VIEW ITEM MODAL -->
  <div class="modal fade" id="viewModal">
    <div class="modal-dialog modal-md">
      <div class="modal-content">
        <div class="modal-header bg-info text-white">
          <h5 class="modal-title">View Item Information</h5>
          <button class="close" data-dismiss="modal">
            <span>&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-sm-5 col-xs-6 tital">
              <strong>Name:</strong>
            </div>
            <div class="col-sm-7 col-xs-6 ">
              <div id="viewName"></div>
            </div>
            <div class="col-sm-5 col-xs-6 tital">
              <strong>Quantity:</strong>
            </div>
            <div class="col-sm-7 col-xs-6 ">
              <div id="viewQuantity"></div>
            </div>
            <div class="col-sm-5 col-xs-6 tital">
              <strong>Description:</strong>
            </div>
            <div class="col-sm-7 col-xs-6 ">
              <div id="viewDescription"></div>
            </div>
            <div class="col-sm-5 col-xs-6 tital">
              <strong>Origin:</strong>
            </div>
            <div class="col-sm-7 col-xs-6 ">
              <div id="viewOrigin"></div>
            </div>
            <div class="col-sm-5 col-xs-6 tital">
              <strong>Date of Arrival:</strong>
            </div>
            <div class="col-sm-7 col-xs-6 ">
              <div id="viewDateOfArrival"></div>
            </div>
            <div class="col-sm-5 col-xs-6 tital">
              <strong>Last Updated:</strong>
            </div>
            <div class="col-sm-7 col-xs-6 ">
              <div id="viewLastUpdated"></div>
            </div>
          </div>
          <br>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- UPDATE ITEM MODAL -->
  <div class="modal fade" id="updateModal">
    <div class="modal-dialog modal-md">
      <div class="modal-content">
        <div class="modal-header bg-warning text-white">
          <h5 class="modal-title">Edit Inventory Item</h5>
          <button class="close" data-dismiss="modal">
            <span>&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="inventory_update.php" method="POST">
            <input type="hidden" name="updateId" id="updateId">
            <div class="form-group">
              <label for="updateName">Name</label>
              <input type="text" name="updateName" id="updateName" class="form-control" placeholder="Enter item name" required>
            </div>
            <div class="form-group">
              <label for="updateQuantity">Quantity</label>
              <input type="number" name="updateQuantity" id="updateQuantity" class="form-control" placeholder="Enter quantity" required>
            </div>
            <div class="form-group">
              <label for="updateDescription">Description</label>
              <textarea name="updateDescription" id="updateDescription" class="form-control" placeholder="Enter description"></textarea>
            </div>
            <div class="form-group">
              <label for="updateOrigin">Origin</label>
              <input type="text" name="updateOrigin" id="updateOrigin" class="form-control" placeholder="Enter origin">
            </div>
            <div class="form-group">
              <label for="updateDateOfArrival">Date of Arrival</label>
              <input type="date" name="updateDateOfArrival" id="updateDateOfArrival" class="form-control" required>
            </div>
            <div class="modal-footer">
              <button type="submit" class="btn btn-primary" name="updateData">Save Changes</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- DELETE ITEM MODAL -->
  <div class="modal fade" id="deleteModal">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header bg-danger text-white">
          <h5 class="modal-title">Delete Inventory Item</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="inventory_delete.php" method="POST">
          <div class="modal-body">
            <input type="hidden" name="deleteId" id="deleteId">
            <h4>Are you sure you want to delete this item?</h4>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
            <button type="submit" class="btn btn-primary" name="deleteData">Yes</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <script src="http://code.jquery.com/jquery-3.3.1.min.js"
    integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"
    integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49"
    crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"
    integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T"
    crossorigin="anonymous"></script>
  <script src="js/inventory.js"></script>
</body>

</html>
