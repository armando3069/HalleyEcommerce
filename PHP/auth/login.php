<?php
//connect la baza de date
 include("./connectDB.php");
 session_destroy();
$_SESSION = array();

  session_start();

 $email = $_POST['email'];
 $parola = $_POST['password'];

 /// sql injection 
 

 $sql = "SELECT parola , id  FROM users  WHERE email = '$email' "; 

 if($result = mysqli_query( $connect , $sql))
 {
    $row = mysqli_fetch_array($result);
   
    if( $row['parola'] == $parola) {

         echo "Esti conectat ! !";

         $_SESSION["user_email"] = $email;
         $_SESSION["user_id"] = $row['id'];

         header("Location: ./home.php");

        }

    else { 
        echo "<script>alert('Parolă greșită ❌ ')</script> ";
        sleep(2);
        header("Location: ./login.html");  
        die(mysqli_error($connect));

    }


 }
  

?>