<?php
session_start();
include('connect.php');
include('checkLogin.php');
if ($_SESSION['role'] == 'Admin' || $_SESSION['role'] == 'Staff') {
    $stmt = $conn->prepare("select * from posts");

    $stmt->execute();
    $result = $stmt->fetchAll();
} else {
    $userid = $_SESSION['id'];
    $stmt = $conn->prepare("select * from posts Where user_id = '$userid' ");
    $stmt->execute();
    $result = $stmt->fetchAll();
    
    $stmt1 = $conn->prepare("select * from posts Where to_user_id = '$userid' ");
    $stmt1->execute();
    $result1 = $stmt1->fetchAll();
}
?>
<html lang="en"> 
    <?php require_once('Form/head_section.php') ?>  
    <body>  
          <?php require_once('Form/navbar.php') ?>
        <?php require_once('Form/side_bar.php') ?>
        <div class="container">
            <br />
            <div class="table-responsive" align="center">
                <h1>Post</h1>
                <?php 
                if ($_SESSION['role'] != 'Admin' && $_SESSION['role'] != 'Staff'){
                ?>
                <button class="btn btn-info"><a href='file_upload.php'>Add new post</a></button>
                <?php } ?>
            </div>
            <div class="innertube">
               
                    </br>
                    <hr  width="90%" align="center" />
                        <?php
                        if ($_SESSION['role'] == 'Admin' || $_SESSION['role'] == 'Staff'){
                        ?>
                         <h4 align="center">All Post</h4>
                        <?php
                        }else{
                        ?>
                         <h4 align="center">Your Post</h4>
                        <?php } ?>
                       
                        <?php
                        if ($stmt->rowCount() > 0) {
                            $i = 1;
                            ?>
                            <table class="table table-bordered table-striped">
                           <tr>
                            <th width="90%">Post</th>
                            <th width="10%">Options</th>
                           </tr>
                           <?php
                            foreach ($result as $row) {
//                                $Userid1 = $row['user_id'];
//                                $s1 = $conn->prepare("select * from account where id = $Userid1");
//                                $s1->execute();
//                                $r1 = $s1->fetch(PDO::FETCH_ASSOC);
                                
                                $Userid2 = $row['to_user_id'];
                                $s2 = $conn->prepare("select * from account where id = $Userid2");
                                $s2->execute();
                                $r2 = $s2->fetch(PDO::FETCH_ASSOC);
                                ?>
                           <tr >
                                    <td>
                                    
                                    <h1>Post <?php echo $i; ?> to <?php echo $r2['username']; ?></h1>
                                    <b><?php echo $row["title"]; ?></b>
                                    <p><?php //echo substr($row["content"], 0, 100) . " ...";  ?></p>
                                    </td>
                                    
                                    <td>
                                    <button class="btn btn-info" ><a href="display.php?id=<?php echo $row["id"]; ?>">Detail</a></button>
                                    <form action="DeletePost.php" method="post" onsubmit="return confirmDelete();">
                                        <input type="hidden" name="id" value= "<?php echo $row["id"]; ?>"/>
                                        <input type="submit" value="Delete" class="btn btn-info" />

                                    </form>
                                </td>
                            </tr>
                            <?php
                            $i++;
                        }
                        ?>
                             </table>
                         <?php
                    } else {
                        ?>
                        <p align="center">No post</p>     
                        <?php
                    }
                    ?>
                       
                
            </div>
            <?php
                if ($_SESSION['role'] == 'Tutor' || $_SESSION['role'] == 'Student'){
            ?>
            <hr  width="90%" align="center" />
             <div class="innertube">
             
                    </br>
                    <tr>
                        <h4 align="center">Post to you</h4>
                        <?php
                        if ($stmt1->rowCount() > 0) {
                            $i = 1;
                            ?>
                            <table class="table table-bordered table-striped">
                           <tr>
                            <th width="90%">Post</th>
                            <th width="10%">Options</th>
                           </tr>
                           <?php
                            foreach ($result1 as $row1) {
                                 $Userid2 = $row1['user_id'];
                                $s2 = $conn->prepare("select * from account where id = $Userid2");
                                $s2->execute();
                                $r2 = $s2->fetch(PDO::FETCH_ASSOC);
                                ?>
                                <tr >
                                    <td>
                                    <h1>Post <?php echo $i; ?> by <?php echo $r2['username'] ?></h1>
                                    <b><?php echo $row1["title"]; ?></b>
                                    <p><?php //echo substr($row["content"], 0, 100) . " ...";  ?></p>
                                    </td>
                                    
                                    <td>
                                    <button class="btn btn-info" ><a href="display.php?id=<?php echo $row1["id"]; ?>">Detail</a></button>
                                </td>
                            </tr>
                            <?php
                            $i++;
                        }
                    } else {
                        ?>
                        <p align="center">No post</p>     
                        <?php
                }}
                    ?>
	
            </div>
        </div>
        <?php require_once('Form/footer.php') ?>
    </body>
</html>