<?php
session_start();
include('connect.php');
include('checkLogin.php');
?>
<html lang="en"> 
    <?php require_once('Form/head_section.php') ?>  
    <body>  
        <?php require_once('Form/navbar.php') ?>
        <?php require_once('Form/side_bar.php') ?>
        <div class="container">
            <br />
            <div class="table-responsive">
                <h4 align="center">Upload</h4>
            </div>
            <br />
            <form method="post" action="file_upload.php" enctype="multipart/form-data">
                <div class="panel panel-default">
                    <div class="panel-heading">Selecting</div>
                    <div class="panel-body">
                        <div class="form-group" id ="mainselection">
                            <label>Title :</label>
                            <input type="text" id="title" name="title" class="form-control" />
                        </div>
                        <div class="form-group" id ="mainselection">
                            <label>Content :</label>
                            <textarea name="post_content" id="post_content" rows="10" cols="150"></textarea>
                        </div>
                        <div class="form-group" id ="mainselection">
                            <label>File :</label>
                            <input type="file" name="files[]" multiple  size="60" style="width:300px" class="btn btn-info">                

                        </div>
                        <?php
                        if ($_SESSION['role'] == 'Tutor') {
                            ?>
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
                        <?php } ?>
                        <?php
                        if ($_SESSION['role'] == 'Student') {
                            ?>
                            <div class="form-group" id ="mainselection">
                                <label>Select Tutor</label>
                                <select name="Tutor">
                                    <option value="">Select...</option>
                                    <?php
                                    $query = "SELECT id, username, Email FROM account, allocate WHERE id != '" . $_SESSION['id'] . "'  and allocate.studentid = '" . $_SESSION['id'] . "' and allocate.tutorid = id ";

                                    $statement = $conn->prepare($query);

                                    $statement->execute();

                                    $result = $statement->fetchAll();
                                    foreach ($result as $row) {
                                        $Tutorid = $row['id'];
                                        $Tutorname = $row['username'];
                                        echo "<option value='$Tutorid'>$Tutorname</option>";
                                    }
                                    ?>
                                </select>    
                            </div>
                        <?php } ?>
                        <div class="form-group">
                            <input type="submit" class="btn btn-info" value="Upload" name="submit">

                        </div>

                    </div>
                </div>
            </form>
        </div>
    </section>
</section>
</section>
</body> 

</html>
<script>
    CKEDITOR.replace('post_content');
</script>
</script>
<script class="include" type="text/javascript" src="Form/lib/jquery.dcjqaccordion.2.7.js"></script>
<script src="Form/lib/jquery.scrollTo.min.js"></script>
<script src="Form/lib/jquery.nicescroll.js" type="text/javascript"></script>
<script src="Form/lib/jquery.sparkline.js"></script>
<!--common script for all pages-->
<script src="Form/lib/common-scripts.js"></script>
<script type="text/javascript" src="Form/lib/gritter/js/jquery.gritter.js"></script>
<script type="text/javascript" src="Form/lib/gritter-conf.js"></script>
<?php
// Check if form was submited 
if (isset($_POST['submit'])) {

    // Configure upload directory and allowed file types 
    $upload_dir = 'uploads' . DIRECTORY_SEPARATOR;


    // Checks if user sent an empty form  
    if (!empty(array_filter($_FILES['files']['name']))) {

        $To_id = '';
        if ($_SESSION['role'] == 'Tutor') {
            $To_id = $_POST['Student'];
        }
        if ($_SESSION['role'] == 'Student') {
            $To_id = $_POST['Tutor'];
        }
    }
    $stmt2 = $conn->prepare("SELECT MAX(id) as mid FROM posts");
    $stmt2->execute();
    $row = $stmt2->fetch(PDO::FETCH_ASSOC);

    if ($row['mid'] == 0) {
        $stmt3 = $conn->prepare("ALTER TABLE posts AUTO_INCREMENT = 1");
        $stmt3->execute();
        $postid = 1;
    } else {
        $postid = $row['mid'] + 1;
        $stmt3 = $conn->prepare("ALTER TABLE posts AUTO_INCREMENT = $postid");
        $stmt3->execute();
    }

    $title = $_POST["title"];
    $content = $_POST["post_content"];

    $user_id = $_SESSION["id"];

    $stmt1 = $conn->prepare("INSERT INTO posts(title, content, user_id,to_user_id ,createdate, updatedate ) VALUES ( '$title', '$content', '$user_id','$To_id' ,now(), now())");
    $pdoResult1 = $stmt1->execute();
    // Loop through each file in files[] array 
    $i = 0;
    $types = array('jpg', 'png', 'jpeg', 'gif');
    if ($pdoResult1) {
        if (isset($_FILES['files'])) {
            foreach ($_FILES['files']['tmp_name'] as $key => $value) {

                $file_tmpname = $_FILES['files']['tmp_name'][$key];
                $file_name = $_FILES['files']['name'][$key];
                $file_size = $_FILES['files']['size'][$key];
                $file_ext = pathinfo($file_name, PATHINFO_EXTENSION);
                if (in_array(strtolower($file_ext), $types)) {
                    $type = 'image';
                } else {
                    $type = 'file';
                }
                // Set upload file path 
                $filepath = $upload_dir . $file_name;
                $url = 'uploads/' . $file_name;
                $fileName = $file_name;
                $stmt = $conn->prepare("INSERT INTO upload_file (fileName, fileUrl, post_id,type) VALUE ('{$fileName}','{$url}','{$postid}','{$type}')");
                $pdoResult = $stmt->execute();
                if (move_uploaded_file($file_tmpname, $filepath) && $pdoResult) {
                    echo "<div class='alert alert-success'><b>{$file_name} successfully uploaded</b> <br /></div>";
                } else {
                    echo "<div class='alert alert-danger'><b>Error uploading {$file_name}</b> <br /></div>";

                    $i = 1;
                }
            }
            if($i==0){
                echo "post has been uploaded";
            $URL = "http://localhost/ASMtest/showPost.php";
            echo "<script type='text/javascript'>document.location.href='{$URL}';</script>";
            echo '<META HTTP-EQUIV="refresh" content="0;URL=' . $URL . '">';
            }
        }
 else {
     echo "post has been uploaded";
            $URL = "http://localhost/ASMtest/showPost.php";
            echo "<script type='text/javascript'>document.location.href='{$URL}';</script>";
            echo '<META HTTP-EQUIV="refresh" content="0;URL=' . $URL . '">';
 }
    } else {
        echo "<div class='alert alert-danger'><b>uploaded error</b></div>";
    }
}
?> 