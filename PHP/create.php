<?php
    include("./connectDB.php");

    $sql = "CREATE TABLE IF NOT EXISTS todo (
        id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
        id_User INT(100) NOT NULL,
        makedo VARCHAR(100) NOT NULL 
    )";

    if(mysqli_query($connect, $sql)){
        echo "crated with succes";
    } else{
        echo "pagina este creata";
        //echo "ERROR: Could not able to execute $sql. " . mysqli_error($connect);
    }


    $sql = "CREATE TABLE IF NOT EXISTS users (
        id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
        nume VARCHAR(30) NOT NULL,
        prenume VARCHAR(30) NOT NULL,
        parola VARCHAR(50) NOT NULL,
        email VARCHAR(70) NOT NULL UNIQUE,
        img VARCHAR(100) NOT NULL
        
    )";

    if(mysqli_query($connect, $sql)){
        echo "crated with succes";
    } else{
        echo "pagina este creata";

        //echo "ERROR: Could not able to execute $sql. " . mysqli_error($connect);
    }

    
    


?>