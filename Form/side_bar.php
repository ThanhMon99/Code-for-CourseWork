 <?php
function getCurURL()
{
    if (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == "on") {
        $pageURL = "https://";
    } else {
      $pageURL = 'http://';
    }
    if (isset($_SERVER["SERVER_PORT"]) && $_SERVER["SERVER_PORT"] != "80") {
        $pageURL .= $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . $_SERVER["REQUEST_URI"];
    } else {
        $pageURL .= $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
    }
    return $pageURL;
}
getCurURL();
?>
<!-- **********************************************************************************************************************************************************
        MAIN SIDEBAR MENU
        *********************************************************************************************************************************************************** -->
<!--sidebar start-->
<aside>
    <div id="sidebar" class="nav-collapse ">
        <!-- sidebar menu start-->
        <ul class="sidebar-menu" id="nav-accordion">
            <p class="centered"><a href="profile.php"><img src="Form/img/pro.png" class="img-circle" width="80"></a></p>
            <h5 class="centered">Hello <?php echo $_SESSION['username']; ?></h5>
            <?php
            if ($_SESSION['role'] == 'Admin' || $_SESSION['role'] == 'Staff') {
                ?>
                <li class="mt">
                    <a <?php if(getCurURL() == 'http://localhost/ASMtest/Dashboard.php') {echo 'class="active"';} ?>href="Dashboard.php">
                        <i class="fa fa-dashboard"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <?php
            if ($_SESSION['role'] == 'Staff') {
                ?>
                <li>
                    <a <?php if(getCurURL() == 'http://localhost/ASMtest/allocate.php') {echo 'class="active"';} ?> href="allocate.php">
                        <i class="fa fa-exchange"></i>
                        <span>Allocate </span>
                    </a>
                </li>
            <?php } ?>
                <li>
                <a <?php if(getCurURL() == 'http://localhost/ASMtest/profile.php') {echo 'class="active"';} ?> href="profile.php">
                    <i class="fa fa-id-card"></i>
                    <span>Your Profile </span>
                </a>
            </li>       
            <li>
                <a <?php if(getCurURL() == 'http://localhost/ASMtest/chat.php') {echo 'class="active"';} ?> href="chat.php">
                    <i class="fa fa-comments-o"></i>
                    <span>Lobby </span>
                </a>
            </li>
            <li>
                <a <?php if(getCurURL() == 'http://localhost/ASMtest/showPost.php') {echo 'class="active"';} ?> href="showPost.php">
                    <i class="fa fa-file-text"></i>
                    <span>Post</span>
                </a>
            </li>
            <?php } 
            else{
            ?>
               <?php
            if ($_SESSION['role'] == 'Tutor') {
                ?>
             <li>
                <a <?php if(getCurURL() == 'http://localhost/ASMtest/Meeting.php') {echo 'class="active"';} ?> href="Meeting.php">
                    <i class="fa fa-handshake-o"></i>
                    <span>Meeting </span>
                </a>
            </li>
            <?php } ?>
            <li>
                <a <?php if(getCurURL() == 'http://localhost/ASMtest/profile.php') {echo 'class="active"';} ?> href="profile.php">
                    <i class="fa fa-id-card"></i>
                    <span>Your Profile </span>
                </a>
            </li>       
            <li>
                <a <?php if(getCurURL() == 'http://localhost/ASMtest/chat.php') {echo 'class="active"';} ?> href="chat.php">
                    <i class="fa fa-comments-o"></i>
                    <span>Lobby </span>
                </a>
            </li>

            <li class="sub-menu">
                <a <?php if(getCurURL() == 'http://localhost/ASMtest/file_upload.php' || getCurURL() == 'http://localhost/ASMtest/showPost.php') {echo 'class="active"';} ?> href="javascript:;">
                    <i class="fa fa-file-text"></i>
                    <span>Post</span>
                </a>
                <ul class="sub">
                    <li <?php if(getCurURL() == 'http://localhost/ASMtest/file_upload.php') {echo 'class="active"';} ?>><a href="file_upload.php">New Post</a></li>
                    <li <?php if(getCurURL() == 'http://localhost/ASMtest/showPost.php') {echo 'class="active"';} ?> ><a href="showPost.php">Post</a></li>
                </ul>
            </li>
       
            <?php } ?>
             </ul>
        <!-- sidebar menu end-->
    </div>
</aside>
<!--sidebar end-->
<section id="main-content">
    <section class="wrapper">