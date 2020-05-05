<?php session_start(); 
 
if (isset($_SESSION['username'])){
    unset($_SESSION['username']); 
    unset($_SESSION['role']);
    header( 'Location: login.php');    
}
?>
