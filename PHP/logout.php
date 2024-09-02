<?php

session_start();

//session_destroy();
$_SESSION = array();

// revine la main page
header("Location: ./login.html");

exit;

?>