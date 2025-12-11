<?php
/*
This file contains the user management interface.
*/
?>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <a href="main_menu.php" class="btn btn-primary mb-3">
                <i class="fas fa-arrow-left"></i> Back to Main Menu
            </a>
            <a href="logout.php" class="btn btn-danger mb-3">
                <i class="fas fa-sign-out-alt"></i> Logout
            </a>
        </div>
    </div>
    <div class="row">
      <div class="col-md-12 card">
        <div>
          <div class="head-title">
            <h4 class="text-center">User Management</h4>
            <hr>
          </div>
          <div class="col-md-3 float-left add-new-button">
            <a href="#" class="btn btn-primary btn-block" data-toggle="modal" data-target="#addModal">
              <i class="fas fa-plus"></i> Add
            </a>
          </div>

          <br><br><br>
          <table class="table table-striped">
            <thead class="bg-secondary text-white">
              <tr>
                <th>#</th>
                <th>Username</th>
                <th>Role</th>
                <th>View</th>
                <th>Update</th>
                <th>Delete</th>
              </tr>
            </thead>
            <tbody>
              <?php

              $sql = "SELECT id, username, role FROM users";
              $result = mysqli_query($conn, $sql);
              $i = 1;

              if($result)
              {
                while($row = mysqli_fetch_assoc($result)){
                  ?>
                  <tr>
                    <td><?php echo $i; ?></td>
                    <td><?php echo $row['username']; ?></td>
                    <td><?php echo $row['role']; ?></td>
                    <td>
                      <button type="button" class="btn btn-info viewBtn" data-id="<?php echo $row['id']; ?>"> <i class="fas fa-eye"></i> View </button>
                    </td>
                    <td>
                      <button type="button" class="btn btn-warning updateBtn" data-id="<?php echo $row['id']; ?>"> <i class="fas fa-edit"></i> Update </button>
                    </td>
                    <td>
                      <button type="button" class="btn btn-danger deleteBtn" data-id="<?php echo $row['id']; ?>"> <i class="fas fa-trash-alt"></i> Delete </button>
                    </td>
                </tr>
                <?php
                $i++;
                }
              }else{
                echo "<script> alert('No users Found');</script>";
              }
              ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  <!-- MODALS -->

  <!-- ADD USER MODAL -->
  <div class="modal fade" id="addModal">
    <div class="modal-dialog modal-md">
      <div class="modal-content">
        <div class="modal-header bg-primary text-white">
          <h5 class="modal-title">Add New User</h5>
          <button class="close" data-dismiss="modal">
            <span>&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="user_insert.php" method="POST">
            <div class="form-group">
              <label for="username">Username</label>
              <input type="text" name="username" class="form-control" placeholder="Enter username" required>
            </div>
            <div class="form-group">
              <label for="password">Password</label>
              <input type="password" name="password" class="form-control" placeholder="Enter password" required>
            </div>
            <div class="form-group">
              <label for="role">Role</label>
              <select name="role" class="form-control">
                <option value="user">User</option>
                <option value="admin">Admin</option>
              </select>
            </div>
            <div class="modal-footer">
              <button type="submit" class="btn btn-primary" name="insertData">Save</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- VIEW MODAL -->
  <div class="modal fade" id="viewModal">
    <div class="modal-dialog modal-md">
      <div class="modal-content">
        <div class="modal-header bg-info text-white">
          <h5 class="modal-title">View User Information</h5>
          <button class="close" data-dismiss="modal">
            <span>&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-sm-5 col-xs-6 tital " >
              <strong>Username:</strong>
            </div>
            <div class="col-sm-7 col-xs-6 ">
              <div id="viewUsername"></div>
            </div>
            <div class="col-sm-5 col-xs-6 tital " >
              <strong>Role:</strong>
            </div>
            <div class="col-sm-7 col-xs-6 ">
              <div id="viewRole"></div>
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

  <!-- UPDATE MODAL -->
  <div class="modal fade" id="updateModal">
    <div class="modal-dialog modal-md">
      <div class="modal-content">
        <div class="modal-header bg-warning text-white">
          <h5 class="modal-title">Edit User</h5>
          <button class="close" data-dismiss="modal">
            <span>&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="user_update.php" method="POST">
            <input type="hidden" name="updateId" id="updateId">
            <div class="form-group">
              <label for="updateUsername">Username</label>
              <input type="text" name="updateUsername" id="updateUsername" class="form-control" placeholder="Enter username" required>
            </div>
            <div class="form-group">
              <label for="updatePassword">Password</label>
              <input type="password" name="updatePassword" id="updatePassword" class="form-control" placeholder="Enter new password (optional)">
            </div>
            <div class="form-group">
              <label for="updateRole">Role</label>
              <select name="updateRole" id="updateRole" class="form-control">
                <option value="user">User</option>
                <option value="admin">Admin</option>
              </select>
            </div>
            <div class="modal-footer">
              <button type="submit" class="btn btn-primary" name="updateData">Save Changes</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- DELETE MODAL -->
  <div class="modal fade" id="deleteModal">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header bg-danger text-white">
          <h5 class="modal-title" id="exampleModalLabel">Delete User</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="user_delete.php" method="POST">
          <div class="modal-body">
            <input type="hidden" name="deleteId" id="deleteId">
            <h4>Are you sure you want to delete this user?</h4>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
            <button type="submit" class="btn btn-primary" name="deleteData">Yes</button>
          </div>
        </form>
      </div>
    </div>
  </div>
