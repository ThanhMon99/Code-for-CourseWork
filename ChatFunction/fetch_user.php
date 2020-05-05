<?php

include('connect.php');
session_start();

$role = $_SESSION['role'];

if ($role == 'Admin' || $role == 'Staff') {
    $query = "SELECT * FROM account WHERE id != '" . $_SESSION['id'] . "' ";
}

if ($role == 'Tutor') {

    $query = "SELECT id, username, Email FROM account, allocate WHERE id != '" . $_SESSION['id'] . "'  and allocate.tutorid = '" . $_SESSION['id'] . "' and allocate.studentid = id ";
}

if ($role == 'Student') {

    $query = "SELECT id, username, Email FROM account, allocate WHERE id != '" . $_SESSION['id'] . "'  and allocate.studentid = '" . $_SESSION['id'] . "' and allocate.tutorid = id ";
}

$statement = $conn->prepare($query);

$statement->execute();

$result = $statement->fetchAll();

$output = '
<table class="table table-bordered table-striped">
 <tr>
  <th width="30%">Username</td>
  <th width="40%">Email</td>
  <th width="15%">Status</td>
  <th width="15%">Chat</td>
 </tr>
';

foreach ($result as $row) {
    $status = '';
    $current_timestamp = strtotime(date("Y-m-d H:i:s") . '+ 5390 second');
    $current_timestamp = date('Y-m-d H:i:s', $current_timestamp);
    $user_last_activity = fetch_user_last_activity($row['id'], $conn);
    if ($user_last_activity > $current_timestamp) {
        $status = '<span class="label label-success">Online</span>';
    } else {
        $status = '<span class="label label-danger">Offline</span>';
    }
    $output .= '
 <tr>
  <td>' . $row['username'] . ' ' . count_unseen_message($row['id'], $_SESSION['id'], $conn) . ' ' . fetch_is_type_status($row['id'], $conn) . '</td>
  <td>' . $row['Email'] . '</td>
  <td>' . $status . '</td>
  <td><button type="button" class="btn btn-info btn-xs start_chat" data-touserid="' . $row['id'] . '" data-tousername="' . $row['username'] . '">Start Chat</button></td>
</tr>
 ';
}

$output .= '</table>';

echo $output;
?>
