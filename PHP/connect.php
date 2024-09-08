<?php

// $connect = mysqli_connect('localhost','root','','HalleyEcommerce'); 
//  if(!$connect)
//  {
//      die($mysqli_connect_error());
//  }
//  else{
//     //echo"Successfully connected";
//     //header("Location: ./createDB.php");
//     echo "succes conect";

//  }
 

?>


<?php

	$dsn = 'mysql:host=localhost;dbname=HalleyEcommerce';
	$user = 'root';
	$pass = '';
	$option = array(
		PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
	);

	try {
		$con = new PDO($dsn, $user, $pass, $option);
		$con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        //echo "succes conect";
	}

	catch(PDOException $e) {
		echo 'Failed To Connect' . $e->getMessage();
	}