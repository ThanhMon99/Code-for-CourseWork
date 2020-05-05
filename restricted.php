<?php
session_start();
$role = $_SESSION['role'];

switch ($role) {
     case 'Admin':
         $_SESSION['role'] = 'Admin';

         header( 'Location: chat.php');
         break;
     case 'Staff':
         $_SESSION['role'] = 'Staff';

         header( 'Location: allocate.php');
         break;
      
        }
            
       

?>