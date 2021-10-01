<?php

      require_once __DIR__.'/config.php';

      $host = DB_host;
      $database_user = DB_user;
      $password = DB_password;
      $database_name = DB_name;

      $con=mysqli_connect($host, $database_user, $password);
      if(!$con){
         die("Error!; mysqli_connect_error()");
      }
      else
      {
         $a=mysqli_select_db($con, $database_name);
      }
 

?>


