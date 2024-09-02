<?php
//connect la baza de date
 include("./connectDB.php");
 session_start();
 
 $nume = mysqli_real_escape_string($connect, $_POST['name']);
$prenume = mysqli_real_escape_string($connect, $_POST['surname']);
$email = mysqli_real_escape_string($connect, $_POST['email']);
$parola = mysqli_real_escape_string($connect, $_POST['password']);
$image = "/profil.png";


 $sql = "INSERT INTO users (nume,prenume,parola,email,img) VALUES ('$nume','$prenume','$parola','$email','$image')";
 
 if(mysqli_query($connect,$sql))
 {
    header("Location: ./login.html");
  
 } else
  {
    die(mysqli_error($connect));
  }




?>