<?php
session_start();
require_once("connect.php");
?>
<?php
$post_id = -1;
if (isset($_GET["id"])) {
    $post_id = intval($_GET['id']);
}
$_SESSION['postid'] = $post_id;
$stmt = $conn->prepare("select * from posts where id = $post_id");
$stmt->execute();
$result = $stmt->fetchAll();

$stmt1 = $conn->prepare("select * from upload_file where post_id = $post_id");
$stmt1->execute();
$result1 = $stmt1->fetchAll();
?>
<html lang="en"> 
    <?php require_once('Form/head_section.php') ?>  
    <body>
        <?php require_once('Form/navbar.php') ?>
        <?php require_once('Form/side_bar.php') ?>
        <br />
        <h2 align="center">POST DETAIL</h2>
        <br />
        <div class="table-responsive">
            <p align="center"><button class="btn btn-info"><a href='showPost.php'>Back</a></button></p>
        </div>
        <hr  width="90%" align="center" />
        <div class="container">
            <div class="innertube">
                <?php
                foreach ($result as $row) {
                    $Userid = $row['user_id'];
                    $stmt2 = $conn->prepare("select * from account where id = $Userid");
                    $stmt2->execute();
                    $r = $stmt2->fetch(PDO::FETCH_ASSOC);
                    ?>
                    <h1><?php echo $row['title']; ?></h1></div></ br>
                <i> Create Date : <?php echo $row['createdate']; ?>, by <?php echo $r['username']; ?></i>
                <hr  width="30%"  align="left" />
                <p><?php echo $row['content']; ?></p>
                 <hr  width="30%"  align="left" />
                <h4>#File Upload :</h4>
                <?php
                foreach ($result1 as $row1) {
                    if ($row1['type'] == 'image') {
                        ?>
                        <a href="download.php?file_id=<?php echo $row1['upload_id'] ?>"><img src="<?php echo $row1['fileUrl']; ?>" alt="" width="300" height="300"/></a>

                        </br>
                        <?php
                    } else {
                        ?>
                        <a href="download.php?file_id=<?php echo $row1['upload_id'] ?>"><p><?php echo $row1['fileName']; ?></p></a>
                        </br>
                        <?php
                    }
                }
                ?>
            <?php } ?>
            </br>
            <form method="POST" id="comment_form">
                <div class="form-group">
                    <textarea name="comment_content" id="comment_content" class="form-control" placeholder="Enter Comment" rows="5"></textarea>
                </div>
                <div class="form-group">
                    <input type="hidden" name="comment_id" id="comment_id" value="0" />
                    <input type="submit" name="submit" id="submit" class="btn btn-info" value="Submit" />
                </div>
            </form>
            <span id="comment_message"></span>
            <br />
            <div id="display_comment"></div>
        </div>
    </section>
</section>
</section>
</body>
</html>
<script>
    $(document).ready(function () {

        $('#comment_form').on('submit', function (event) {
            event.preventDefault();
            var form_data = $(this).serialize();
            $.ajax({
                url: "add_comment.php",
                method: "POST",
                data: form_data,
                dataType: "JSON",
                success: function (data)
                {
                    if (data.error != '')
                    {
                        $('#comment_form')[0].reset();
                        $('#comment_message').html(data.error);
                        $('#comment_id').val('0');
                        load_comment();
                    }
                }
            })
        });

        load_comment();

        function load_comment()
        {
            $.ajax({
                url: "fetch_comment.php",
                method: "POST",
                success: function (data)
                {
                    $('#display_comment').html(data);
                }
            })
        }
    });
</script>
<script class="include" type="text/javascript" src="Form/lib/jquery.dcjqaccordion.2.7.js"></script>
<script src="Form/lib/jquery.scrollTo.min.js"></script>
<script src="Form/lib/jquery.nicescroll.js" type="text/javascript"></script>
<script src="Form/lib/jquery.sparkline.js"></script>
<!--common script for all pages-->
<script src="Form/lib/common-scripts.js"></script>
<script type="text/javascript" src="Form/lib/gritter/js/jquery.gritter.js"></script>
<script type="text/javascript" src="Form/lib/gritter-conf.js"></script>






