<?php
        //session_cache_limiter('private_no_expire');

	session_start();
        if(empty($_SESSION['login_code'])) 
          {             
           require "index.php";
           exit;  
          }
?>

