<?php
session_start();
session_destroy();

//Redirigimos al login
header("Location: login.php");

exit();
?>