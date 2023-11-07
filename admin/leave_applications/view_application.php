<?php
require_once('../../config.php');

					$i = 1;
						$where = '';
						if($_settings->userdata('type') == 3){
						$qry = $conn->query("SELECT l.*,concat(u.lastname,', ',u.firstname,' ',u.middlename) as `name`,lt.code,lt.name as lname from `leave_applications` l inner join `users` u on l.user_id=u.id inner join `leave_types` lt on lt.id = l.leave_type_id where u.type = '2' AND l.status = '0' AND (date_format(l.date_start,'%Y') = '".date("Y")."' or date_format(l.date_end,'%Y') = '".date("Y")."') {$where} order by FIELD(l.status,0,1,2,3), unix_timestamp(l.date_created) desc ");
						}
						elseif ($_settings->userdata('type') == 2) {
							$qry = $conn->query("SELECT l.*,concat(u.lastname,', ',u.firstname,' ',u.middlename) as `name`,lt.code,lt.name as lname from `leave_applications` l inner join `users` u on l.user_id=u.id inner join `leave_types` lt on lt.id = l.leave_type_id where u.type = '4' AND l.status = '1' AND (date_format(l.date_start,'%Y') = '".date("Y")."' or date_format(l.date_end,'%Y') = '".date("Y")."') {$where} order by FIELD(l.status,0,1,2,3), unix_timestamp(l.date_created) desc ");
						}
						elseif ($_settings->userdata('type') == 1) {
							$qry = $conn->query("SELECT l.*,concat(u.lastname,', ',u.firstname,' ',u.middlename) as `name`,lt.code,lt.name as lname from `leave_applications` l inner join `users` u on l.user_id=u.id inner join `leave_types` lt on lt.id = l.leave_type_id where l.status = '4' OR '3' AND (date_format(l.date_start,'%Y') = '".date("Y")."' or date_format(l.date_end,'%Y') = '".date("Y")."') {$where} order by FIELD(l.status,0,1,2,3), unix_timestamp(l.date_created) desc ");
						}
						elseif ($_settings->userdata('type') == 4) {
							$qry = $conn->query("SELECT l.*,concat(u.lastname,', ',u.firstname,' ',u.middlename) as `name`,lt.code,lt.name as lname from `leave_applications` l inner join `users` u on l.user_id=u.id inner join `leave_types` lt on lt.id = l.leave_type_id where u.id= '{$_settings->userdata('id')}' AND (date_format(l.date_start,'%Y') = '".date("Y")."' or date_format(l.date_end,'%Y') = '".date("Y")."') {$where} order by FIELD(l.status,0,1,2,3), unix_timestamp(l.date_created) desc ");
						}
						while($row = $qry->fetch_assoc()):
							$lt_qry = $conn->query("SELECT meta_value FROM `employee_meta` where user_id = '{$row['user_id']}' and meta_field = 'employee_id' ");
							$row['employee_id'] = ($lt_qry->num_rows > 0) ? $lt_qry->fetch_array()['meta_value'] : "N/A";

					


if (isset($_GET['id']) && $_GET['id'] > 0) {
    $applicationId = $_GET['id']; // Sanitize the input or use prepared statements.

    // Use a prepared statement to avoid SQL injection.
    $query = "SELECT l.*, CONCAT(u.lastname, ' ', u.firstname, ' ', u.middlename) as `name`, u.username as uname, u.type, lt.code, lt.name as lname, u.department_id, l.type 
              FROM `leave_applications` l 
              INNER JOIN `users` u ON l.user_id = u.id 
              INNER JOIN `leave_types` lt ON lt.id = l.leave_type_id 
              WHERE l.id = ?";
    
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $applicationId);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Access the fetched data using the $row variable.
        $name = $row['name'];
        $uname = $row['uname'];
        $userType = $row['type']; // Changed variable name to user type
        $code = $row['code'];
        $lname = $row['lname'];
        $department_id = $row['department_id'];
    }
}


        // Use the fetched data as needed.


if (isset($_GET['id']) && $_GET['id'] > 0) {
    $qry = $conn->query("SELECT l.*, concat(u.lastname,' ',u.firstname,' ',u.middlename) as `name`, lt.code, lt.name as lname, u.department_id from `leave_applications` l inner join `users` u on l.user_id=u.id inner join `leave_types` lt on lt.id = l.leave_type_id  where l.id = '{$_GET['id']}' ");
    if ($qry->num_rows > 0) {
        foreach ($qry->fetch_assoc() as $k => $v) {
            $$k = $v;
        }

        // Retrieve employee ID
        $lt_qry = $conn->query("SELECT meta_value FROM employee_meta WHERE meta_field = 'type' AND user_id = '{$user_id}'");
        $usertype = ($lt_qry->num_rows > 0) ? $lt_qry->fetch_array()['meta_value'] : "N/A";

        $lt_qry = $conn->query("SELECT meta_value FROM employee_meta WHERE meta_field = 'employee_id' AND user_id = '{$user_id}'");
        $employee_id = ($lt_qry->num_rows > 0) ? $lt_qry->fetch_array()['meta_value'] : "N/A";

        // Fetch HR director data
        $hrDirectorQuery = $conn->query("SELECT firstname, lastname FROM users WHERE type = 2"); // Assuming HR director type is 2
        $hrDirectorData = ($hrDirectorQuery && $hrDirectorQuery->num_rows > 0) ? $hrDirectorQuery->fetch_assoc() : null;

        // Fetch HR head data
        $hrHeadQuery = $conn->query("SELECT firstname, lastname FROM users WHERE type = 3"); // Assuming HR head type is 3
        $hrHeadData = ($hrHeadQuery && $hrHeadQuery->num_rows > 0) ? $hrHeadQuery->fetch_assoc() : null;

        // Set the user's department ID as user_department
        $user_department = $conn->query("SELECT users.department_id, users.type, users.id FROM users INNER JOIN leave_applications ON users.id = leave_applications.user_id WHERE user_id = '{$user_id}'");
        $department = ($user_department->num_rows > 0) ? $user_department->fetch_array()['department_id'] : "N/A";

    }
}
?>


<?php endwhile; ?>
<!DOCTYPE html>
<html lang="en">
<head>
   
    <link rel="stylesheet" type="text/css" href="/leave_system/assets/css/print.css">

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leave Application</title>
</head>
<body>
<div id="print_out">
    <div class="container-fluid">
        <div class="header">
            <img src="http://localhost/leave_system/images/header.png" class="logo" alt="Logo">
        </div>
        <div class="human-resource">
            <p><b>HUMAN RESOURCES MANAGEMENT OFFICE</b></p>
            <p>APPLICATION FOR LEAVE</p><br>
        </div>
        <div class="employee-info">
            <h5>Employee Info:</h5>
            <table class="table">
                <tbody>
                    <tr>
                        <th><b>Employee ID:</b></th>
                        <td><?php echo $employee_id; ?></td>
                    </tr>
                    <tr>
                        <th><b>Name:</b></th>
                        <td><?php echo $name; ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="leave-info">
            <h5>Leave Info:</h5>
            <table class="table">
                <tbody>
                    <tr>
                        <th><b>Leave Type:</b></th>
                        <td><?php echo $code.' - '.$lname; ?></td>
                    </tr>
                    <tr>
                        <th><b>Date:</b></th>
                        <td>
                            <?php
                            if($date_start == $date_end){
                                echo date("Y-m-d", strtotime($date_start));
                            }else{
                                echo date("Y-m-d", strtotime($date_start)).' - '.date("Y-m-d", strtotime($date_end));
                            }
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <th><b>Days of Leave:</b></th>
                        <td><?php echo $leave_days; ?></td>
                    </tr>
                    <tr>
                        <th><b>Reason:</b></th>
                        <td><?php echo $reason; ?></td>
                    </tr>
                    <tr>
                        <th><b>Status:</b></th>
                        <td>
                            <?php if($status == 1): ?>
                                <span class="status-badge badge-warning">Forwarded</span>
                            <?php elseif($status == 2): ?>
                                <span class="status-badge badge-danger">Denied</span>
                            <?php elseif($status == 3): ?>
                                <span class="status-badge badge-cancelled">Cancelled</span>
                            <?php elseif($status == 4): ?>
                                <span class="status-badge badge-success">Approved</span>
                            <?php else: ?>
                                <span class="status-badge badge-pending">Pending</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="signature-container">
    <div class="signature-block">
        <div class="signature-name1">
            Noted by:
        </div>
        <div class="signature1">
            <?php
            $image_filename = 'http://localhost/leave_system/images/' . $department . '.png';
            if ($status == 4 || $status == 2 || $status == 3 || $status == 1) :
            ?>
                <img src=<?php echo $image_filename; ?>>
            <?php endif; ?>
        </div>
                
                <div class="signature-designation">
                    <?php if ($usertype == 4 ) {
                        echo '<p style="text-decoration: underline;">' . $hrDirectorData['firstname'] . ' ' . $hrDirectorData['lastname'] . '</p>';
                        echo 'Immediate Supervisor';
                    } elseif ($usertype == 2) {
                        echo '<p style="text-decoration: underline;">' . $hrHeadData['firstname'] . ' ' . $hrHeadData['lastname'] . '</p>';
                        echo 'Immediate Supervisor';
                    } elseif ($usertype == 3) {
                        echo '<p style="text-decoration: underline;">' . $hrHeadData['firstname'] . ' ' . $hrHeadData['lastname'] . '</p>';
                        echo 'Immediate Supervisor';
                    } else {
                        echo "HR Director/HR Head Not Found";
                    }
                    ?>
                </div>
            </div>
            <div class="signature-block">
                <div class="signature-name1">
                    Approved by:
                </div>
                <div class="signature1">
                    <?php if($status == 4): ?>
                        <img src="http://localhost/leave_system/images/signature.png" alt="Approved Signature">
                    <?php elseif($status == 2): ?>
                        <img src="http://localhost/leave_system/images/signature.png" alt="Denied Signature">
                    <?php elseif($status == 3): ?>
                        <img src="http://localhost/leave_system/images/signature.png" alt="Cancelled Signature">
                    
                    <?php endif; ?>
                </div>
                <div class="signature-designation1">
                    <p style="text-decoration: underline;">Ginard S. Guaki</p>
                    HR Director
                </div>
            </div>
        </div>
        <div class="button-container">
            <div class="print-button">
                <button class="btn btn-flat btn-sm btn-default bg-blue" onclick="printContent()"><i class="fa fa-print"></i> Print</button>

            </div>
            <div class="close-button">
                <button class="btn btn-flat btn-sm btn-default bg-blue" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
            </div>
        </div>
    </div>
                    </div>
                    <script>
function printContent() {
    var printContents = document.getElementById("print_out").innerHTML;
    var originalContents = document.body.innerHTML;

    document.body.innerHTML = printContents;

    window.print();

    document.body.innerHTML = originalContents;
}
</script>

</body>
</html>
