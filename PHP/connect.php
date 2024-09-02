<?php

$connect = mysqli_connect('localhost','root','','myDBname'); 
 if(!$connect)
 {
     die($mysqli_connect_error());
 }
 else{
    //echo"Successfully connected";
    //header("Location: ./createDB.php");

 }
 

?>