<?php
session_start();
include('connect.php');
include('checkLogin.php');
?>
<html>  
    <?php require_once('Form/head_section.php') ?>  
    <?php require_once('Form/css/style.php') ?> 
    <style>
        .form-control {
            width: 100%;
        }
        .multiselect-container {
            box-shadow: 0 3px 12px rgba(0,0,0,.175);
            margin: 0;
        }
        .multiselect-container .checkbox {
            margin: 0;
        }
        .multiselect-container li {
            margin: 0;
            padding: 0;
            line-height: 0;
        }
        .multiselect-container li a {
            line-height: 25px;
            margin: 0;
            padding:0 35px;
        }
        .custom-btn {
            width: 100% !important;
        }
        .custom-btn .btn, .custom-multi {
            text-align: left;
            width: 100% !important;
        }
        .dropdown-menu > .active > a:hover {
            color:inherit;
        }
    </style>
    <body >  
        <?php require_once('Form/navbar.php') ?>
        <?php require_once('Form/side_bar.php') ?>
        <div class="container">
            <br />
            <div class="table-responsive">
                <h4 align="center">New Meeting</h4>
            </div>
            <br />
            <div class="panel panel-default">
                <div class="panel-heading">Creating</div>
                <div class="panel-body">
                    <form method="post">
                        <div class="form-group">
                            <label>Select Student</label>
                            <select name="Student" class ="dropdown">
                                <?php
                                $query = "SELECT id, username, Email FROM account, allocate WHERE id != '" . $_SESSION['id'] . "'  and allocate.tutorid = '" . $_SESSION['id'] . "' and allocate.studentid = id ";

                                $statement = $conn->prepare($query);

                                $statement->execute();

                                $result = $statement->fetchAll();
                                foreach ($result as $row) {
                                    $Studentid = $row['id'];
                                    $Studentname = $row['username'];
                                    echo "<option value='$Studentid'>$Studentname</option>";
                                }
                                ?>
                            </select>    
                        </div>


                        <div class="form-group">
                            <input type="submit" name="add" class="btn btn-info" value="Start Meeting" />
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <?php
        if (isset($_POST['Student'])) {

            $stID = $_POST['Student'];
            $TtID = $_SESSION['id'];
            $s1 = $conn->prepare("SELECT * FROM allocate WHERE studentid = '$stID' and tutorid = '$TtID' ");
            $s1->execute();
            $r = $s1->fetch(PDO::FETCH_ASSOC);
    
        
            $AllocateID = $r['acid'];

            $s2 = $conn->prepare("INSERT INTO meeting (AllocateID, Date) VALUE ('{$AllocateID}', now())");
            $pdoResult = $s2->execute();

            if ($pdoResult)
                echo "<div class='alert alert-success'><b>Adding success</b></div>";
            else
                echo "<div class='alert alert-danger'><b>Adding error</b></div>";
            
        }

        $query1 = "SELECT * FROM meeting";

        $statement1 = $conn->prepare($query1);

        $statement1->execute();

        $result1 = $statement1->fetchAll();

        $output = '
<table class="table table-bordered table-striped">
 <tr>
  <th width="10%">Numerical order</td>
  <th width="30%">Your Student</td>
  <th width="30%">Meeting Date</td>
  <th width="30%">Option</td>
 </tr>
';
        $i = 0;
        foreach ($result1 as $row) {
            $i ++;
// get student name
            $stmt = $conn->prepare("SELECT * FROM allocate where acid = '" . $row['AllocateID'] . "'");
            $stmt->execute();
            $row1 = $stmt->fetch(PDO::FETCH_ASSOC);

/// get tutor name

            $stmt1 = $conn->prepare("SELECT * FROM account where id = '" . $row1['studentid'] . "'");
            $stmt1->execute();
            $row2 = $stmt1->fetch(PDO::FETCH_ASSOC);

            $output .= '
 <tr>
  <td>' . $i . ' </td>
  <td>' . $row2['username'] . ' </td>
  <td>Start at ' . $row['Date'] . ' </td>
 
 ';
            if ($row['Date_end'] == '') {
                $output .= ' <td>
     
            <form action="DeleteMeeting.php" method="post" onsubmit="return confirmDelete();">
                <input type="hidden" name="MeetingID" value= ' . $row['MeetingID'] . '/>
                <input type="submit" value="End Meeting" />
            </form>
          
  </td>
</tr>';
            } else {
                $output .= ' <td>
     
            End at  ' . $row['Date_end'] . '
  </td>
</tr>';
            }
        }
//<button class="btn btn-info" ><a href="MeetingDetail.php?id=' . $row["MeetingID"] . '">Join Meeting</a></button>
        $output .= '</table>';

        echo $output;
        ?>
        <?php require_once('Form/footer.php') ?>
    </body>  
</html>

<?php require_once('Form/AllocateScript.js') ?>

