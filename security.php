<?php
//Si la sesión no se ha iniciado la inicia
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

//Comprueba si el 'rol' está vacío, si lo está, significa que no se está logeado correctamente,
//por lo que se nos redirige al login
if (empty($_SESSION['rol'])){
    $_SESSION["mensajeError"] = "Error en la sesión, no está usted logeado con ningún usuario";
    header("Location: login.php?");
    exit();
}
?>
