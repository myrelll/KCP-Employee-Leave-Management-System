


<h1>Welcome to <?php echo $_settings->info('name') ?></h1>
<hr class="bg-light">
<?php if($_settings->userdata('type') == 1 ): ?>
<div class="row">
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
              <span class="info-box-icon bg-light elevation-1"><i class="fas fa-file-alt"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Pending Applications</span>
                <span class="info-box-number text-right">
                  <?php 
                    $pending = $conn->query("SELECT * FROM `leave_applications` where date_format(date_start,'%Y') = '".date('Y')."' and date_format(date_end,'%Y') = '".date('Y')."' and status = 1 ")->num_rows;
                    echo number_format($pending);
                  ?>
                  <?php ?>
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-info elevation-1"><i class="fas fa-building"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Total Departments</span>
                <span class="info-box-number text-right">
                  <?php 
                    $department = $conn->query("SELECT id FROM `department_list` ")->num_rows;
                    echo number_format($department);
                  ?>
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->

          <!-- fix for small devices only -->
          <div class="clearfix hidden-md-up"></div>

          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-lightblue elevation-1"><i class="fas fa-th-list"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Total Designations</span>
                <span class="info-box-number text-right">
                <?php 
                    $designation = $conn->query("SELECT id FROM `designation_list`")->num_rows;
                    echo number_format($designation);
                  ?>
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-purple elevation-1"><i class="fas fa-list"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Total Type of Leave</span>
                <span class="info-box-number text-right">
                <?php 
                    $leave_types = $conn->query("SELECT id FROM `leave_types` where status = 1 ")->num_rows;
                    echo number_format($leave_types);
                  ?>
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
        </div>
<?php elseif($_settings->userdata('type') == 2 ): ?>
  <div class="row">
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
              <span class="info-box-icon bg-light elevation-1"><i class="fas fa-file-alt"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Pending Applications</span>
                <span class="info-box-number text-right">
                <?php
                  $loggedInUserID = $_settings->userdata('id'); // Assuming you have a method to retrieve the user ID of the logged-in user

                  $query = "SELECT COUNT(*) AS pending_count FROM `leave_applications` INNER JOIN `users` ON `leave_applications`.`user_id` = `users`.`id` WHERE `leave_applications`.`status` = '0' AND `users`.`type` = '4'";
                  $result = $conn->query($query);

                  if ($result === false) {
                    // Query execution failed
                    echo "Error: " . $conn->error;
                    exit;
                  }

                  $row = $result->fetch_assoc();
                  $pending = $row['pending_count'];
                  echo number_format($pending);
                  ?>

                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-info elevation-1"><i class="fas fa-building"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Your Upcoming Leave</span>
              <span class="info-box-number text-right">
            <?php 
              $upcoming = $conn->query("SELECT * FROM `leave_applications` where date(date_start) > '".date('Y-m-d')."' and status = 4 and user_id = '{$_settings->userdata('id')}' ")->num_rows;
              echo number_format($upcoming);
            ?>
          </span>
        </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-lightblue elevation-1"><i class="fas fa-th-list"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Total of Users</span>
                <span class="info-box-number text-right">
                <?php 
                   $loggedInDepartmentID = $_settings->userdata('department_id');
                   $query = "SELECT COUNT(*) AS leave_type_count
                             FROM `users`
                             WHERE type = '4'";
                   $result = $conn->query($query);
                  
                  if ($result === false) {
                    // Query execution failed
                    echo "Error: " . $conn->error;
                    exit;
                  }
                  
                  $row = $result->fetch_assoc();
                  $leaveTypeCount = $row['leave_type_count'];
                  echo number_format($leaveTypeCount);
                  
                 ?>

                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>

          <!-- fix for small devices only -->
          <div class="clearfix hidden-md-up"></div>
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-purple elevation-1"><i class="fas fa-list"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Total Type of Leave</span>
                <span class="info-box-number text-right">
                <?php 
                    $leave_types = $conn->query("SELECT id FROM `leave_types` where status = 1 ")->num_rows;
                    echo number_format($leave_types);
                  ?>
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
        </div>
<?php elseif($_settings->userdata('type') == 3 ): ?>
  <div class="row">
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
              <span class="info-box-icon bg-light elevation-1"><i class="fas fa-file-alt"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Pending Applications</span>
                <span class="info-box-number text-right">
                <?php
                  $loggedInUserID = $_settings->userdata('id'); // Assuming you have a method to retrieve the user ID of the logged-in user

                  $query = "SELECT COUNT(*) AS pending_count FROM `leave_applications` INNER JOIN `users` ON `leave_applications`.`user_id` = `users`.`id` WHERE `leave_applications`.`status` = '0' AND `users`.`type` = '2'";
                  $result = $conn->query($query);

                  if ($result === false) {
                    // Query execution failed
                    echo "Error: " . $conn->error;
                    exit;
                  }

                  $row = $result->fetch_assoc();
                  $pending = $row['pending_count'];
                  echo number_format($pending);
                  ?>

                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-info elevation-1"><i class="fas fa-building"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Your Upcoming Leave</span>
              <span class="info-box-number text-right">
            <?php 
              $upcoming = $conn->query("SELECT * FROM `leave_applications` where date(date_start) > '".date('Y-m-d')."' and status = 4 and user_id = '{$_settings->userdata('id')}' ")->num_rows;
              echo number_format($upcoming);
            ?>
          </span>
        </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-lightblue elevation-1"><i class="fas fa-th-list"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Total of Users</span>
                <span class="info-box-number text-right">
                  
                <?php 
                   $loggedInDepartmentID = $_settings->userdata('department_id');
                   $query = "SELECT COUNT(*) AS leave_type_count
                             FROM `users`
                             WHERE type = '2'";
                   $result = $conn->query($query);
                  
                  if ($result === false) {
                    // Query execution failed
                    echo "Error: " . $conn->error;
                    exit;
                  }
                  
                  $row = $result->fetch_assoc();
                  $leaveTypeCount = $row['leave_type_count'];
                  echo number_format($leaveTypeCount);
                  
                 ?>
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>

          <!-- fix for small devices only -->
          <div class="clearfix hidden-md-up"></div>
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-purple elevation-1"><i class="fas fa-list"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Total Type of Leave</span>
                <span class="info-box-number text-right">
                <?php 
                    $leave_types = $conn->query("SELECT id FROM `leave_types` where status = 1 ")->num_rows;
                    echo number_format($leave_types);
                  ?>
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
        </div>
<?php else: ?>
  <div class="row">
    <div class="col-12 col-sm-6 col-md-3">
      <div class="info-box">
        <span class="info-box-icon bg-light elevation-1"><i class="fas fa-file-alt"></i></span>

        <div class="info-box-content">
          <span class="info-box-text">Pending Applications</span>
          <span class="info-box-number text-right">
            <?php 
              $pending = $conn->query("SELECT * FROM `leave_applications` where date_format(date_start,'%Y') = '".date('Y')."' and date_format(date_end,'%Y') = '".date('Y')."' and status = 0 and user_id = '{$_settings->userdata('id')}' ")->num_rows;
              echo number_format($pending);
            ?>
            <?php ?>
          </span>
        </div>
        <!-- /.info-box-content -->
      </div>
      <!-- /.info-box -->
    </div>
    <div class="col-12 col-sm-6 col-md-3">
      <div class="info-box">
        <span class="info-box-icon bg-lightblue elevation-1"><i class="fas fa-th-list"></i></span>

        <div class="info-box-content">
          <span class="info-box-text">Upcoming Leave</span>
          <span class="info-box-number text-right">
            <?php 
              $upcoming = $conn->query("SELECT * FROM `leave_applications` where date(date_start) > '".date('Y-m-d')."' and status = 4 and user_id = '{$_settings->userdata('id')}' ")->num_rows;
              echo number_format($upcoming);
            ?>
            <?php ?>
          </span>
        </div>
        <!-- /.info-box-content -->
      </div>
      <!-- /.info-box -->
    </div>
  </div>
<?php endif; ?>
