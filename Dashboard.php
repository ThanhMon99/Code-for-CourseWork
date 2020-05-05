<?php
session_start();
include('connect.php');
include('checkLogin.php');
//get time
$current_timestamp = strtotime(date("Y-m-d H:i:s"));
$year = date('Y', $current_timestamp);
$month = date('m', $current_timestamp);
$id = $_SESSION['id'];
$role = $_SESSION['role'];
//get admin id
$stmt1 = $conn->prepare("select * from account where role = 'Admin'");
$stmt1->execute();
$r1 = $stmt1->fetch(PDO::FETCH_ASSOC);
$id2 = $r1['id'];
//get login history form now
$query = "SELECT user_id, last_activity FROM login_details WHERE user_id != '" . $_SESSION['id'] . "' and user_id != $id2 and MONTH(last_activity) = '$month' and YEAR(last_activity) = '$year'";
$statement = $conn->prepare($query);
$statement->execute();
$result = $statement->fetchAll();

$array[] = array();
$array1[] = array();
$s =0;
for ($x = 1; $x <= 12; $x++) {
    $y = 0;
$st = $conn->prepare("SELECT user_id, last_activity FROM login_details WHERE user_id != '" . $_SESSION['id'] . "' and user_id != $id2 and MONTH(last_activity) = '$x' and YEAR(last_activity) = '$year'");
$st->execute();
$res = $st->fetchAll();
foreach ($res as $rr){
    $y ++;
}
$array[$x] = $y;
$s = $s + $y;
}
for ($x = 1; $x <= 12; $x++) {
    $array1[$x] = $array[$x] / $s *100;
}

?>
<html lang="en">
    <?php require_once('Form/head_section.php') ?>  
    <style>
        * {
            box-sizing: border-box;
        }

        /* Create two equal columns that floats next to each other */
        .column {
            float: left;
            width: 50%;
            padding: 10px;
            height: 300px; /* Should be removed. Only for demonstration */
        }

        /* Clear floats after the columns */
        .row:after {
            content: "";
            display: table;
            clear: both;
        }
    </style>
     <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">

      // Load the Visualization API and the piechart package.
      google.load('visualization', '1.0', {'packages':['corechart']});
      google.setOnLoadCallback(drawChart);

      function drawChart() {
          
        // Create the data table.
        var data = new google.visualization.DataTable();
        // Create columns for the DataTable
        data.addColumn('string');
        data.addColumn('number', 'Devices');
        // Create Rows with data
        data.addRows([
          ['Jan',<?php echo $array1[1];?>],
          ['Feb', <?php echo $array1[2];?>],
          ['Mar', <?php echo $array1[3];?>],
          ['Apr', <?php echo $array1[4];?>],
          ['May', <?php echo $array1[5];?>],
          ['Jun', <?php echo $array1[6];?>],
           ['Jul', <?php echo $array1[7];?>],
          ['Aug', <?php echo $array1[8];?>],
          ['Sep', <?php echo $array1[9];?>],
          ['Oct', <?php echo $array1[10];?>],
          ['Nov', <?php echo $array1[11];?>],
          ['Dec', <?php echo $array1[12];?>]
         
        ]);
		//Create option for chart
        var options = {
          title: 'User Visit Each Month -  <?php echo $year; ?>',
     
          is3D : true
        };

        // Instantiate and draw our chart, passing in some options.
        var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
        chart.draw(data, options);
      }
    </script>

    <body>
        <?php require_once('Form/navbar.php') ?>
        <?php require_once('Form/side_bar.php') ?>
        </br>
       
            <h2 align="center">User Status At <?php echo $month . ', ' . $year; ?></h2>
                <table class="table table-bordered table-striped" style="width:100%" align="center">
                    <tr>
                        <th width="50%">Username</th>
                        <th width="50%">Status</th>
                    </tr>
                    <?php
                    $stmt2 = $conn->prepare("select * from account where role != 'Admin' and role != 'Staff'");
                    $stmt2->execute();
                    $r2 = $stmt2->fetchAll();
                  foreach ($r2 as $r) {
                        if($r['status1']==0 && $r['status']==0  )
                        {
                            $status = $r['username'].' has no activities for this month!';
                        }
                        else{
                            $status = $r['username'].' has some activity!';
                        }
                   ?>    


                       <tr>
                            <td><?php echo $r['username']; ?></td>
                            <td><?php echo $status; ?></td>

                        </tr>

<?php  } ?>
                </table>
          <hr  width="90%" align="center" />
                
                
                <h2 align="center">User Activities At <?php echo $month . ', ' . $year; ?></h2>
      
        <div class="row" >
            <div class="column">
           <div id="chart_div" style="backgroundColor: windowframe;"></div>
          
            <h2 align="left">Login Total</h2>
                <table class="table table-bordered table-striped" style="width:100%" align="center">
                    <tr>
                        <th width="50%">Username</th>
                        <th width="50%">Total</th>
                    </tr>
                    <?php
                    foreach ($r2 as $r) {
                        $i = 0;
                        foreach ($result as $row) {

                            if ($r['id'] == $row['user_id']) {
                                $i++;
                            }
                        }
                        ?>     


                        <tr>
                            <td><?php echo $r['username']; ?></td>
                            <td><?php
                                if ($i != 0) {
                                    echo $i . ' time';
                                } else {
                                    echo 'No login activity for this month!';
                                }
                                ?></td>

                        </tr>

<?php } ?>
                </table>
        </div>
            <div class="column" >
                
                <h2 align="left">Post Total</h2>
                <table class="table table-bordered table-striped" style="width:100%" align="center">
                    <tr>
                        <th width="50%">Username</th>
                        <th width="50%">Total</th>
                    </tr>
                    <?php
                    $stmt3 = $conn->prepare("select * from posts");
                    $stmt3->execute();
                    $re = $stmt3->fetchAll();
                    foreach ($r2 as $r) {
                        $i = 0;
                           $usid = $r['id'];
                        foreach ($re as $r1) {

                            if ($r['id'] == $r1['user_id']) {
                                $i++;
                            }
                        }
                        ?>     


                        <tr>
                            <td><?php echo $r['username']; ?></td>
                            <td><?php
                                if ($i != 0) {
                                    echo $i . ' post';
                                 
                                    $st1 = $conn->prepare(" UPDATE `account` SET `status`= 1 WHERE id = '$usid'");
                                    $st1->execute();
                                } else {
                                     $st1 = $conn->prepare(" UPDATE `account` SET `status`= 0 WHERE id = '$usid'");
                                     $st1->execute();
                                    echo 'No post for this month!';
                                }
                                ?></td>

                        </tr>

<?php } ?>
                </table>
                </br>
                <h2 align="left">Chat Total</h2>
                <table class="table table-bordered table-striped" style="width:100%" align="center">
                    <tr>
                        <th width="50%">Username</th>
                        <th width="50%">Total</th>
                    </tr>
                    <?php
                    $stmt4 = $conn->prepare("select * from chat_message");
                    $stmt4->execute();
                    $res = $stmt4->fetchAll();
                    foreach ($r2 as $r) {
                        $i = 0;
                         $usid1 = $r['id'];
                        foreach ($res as $r1) {

                            if ($r['id'] == $r1['from_user_id']) {
                                $i++;
                            }
                        }
                        ?>     


                        <tr>
                            <td><?php echo $r['username']; ?></td>
                            <td><?php
                            if ($i != 0) {
                                echo $i . ' message';
                                $st1 = $conn->prepare(" UPDATE `account` SET `status1`= 1 WHERE id = '$usid1'");
                                $st1->execute();

                            } else {
                                $st1 = $conn->prepare(" UPDATE `account` SET `status1`= 0 WHERE id = '$usid1'");
                                $st1->execute();
                                echo 'No message for this month!';
                            }
                            ?></td>

                        </tr>

<?php } ?>
                </table>
                
            </div>
         
        </div>

   
          
<?php require_once('Form/footer.php') ?>
    </body>
</html>

