<?php
include("connect.php");
include("security.php");
include("user_class.php");

//Comprobamos si el usuario está autenticado, si no hay sesión iniciada, lo redirigimos al login
if (!isset($_SESSION["dni"])) {
    header("Location: user_session.php");
    exit();
}

//Verificamos si el usuario está definido en la sesión y su DNI no está vacío
if (isset($_SESSION["dni"]) && !empty($_SESSION["dni"])) {
    $dni = $_SESSION["dni"];

    //Sacamos el usuario por su DNI
    $usuarioSesion = Usuario::obtenerUsuarioDNI($dni);

    //Si se ha obtenido el usuario
    if ($usuarioSesion) {
        //Sacamos sus datos en variables para usarlas en la vista
        $nombre = $usuarioSesion->getNombre();
        $direccion = $usuarioSesion->getDireccion();
        $localidad = $usuarioSesion->getLocalidad();
        $provincia = $usuarioSesion->getProvincia();
        $telefono = $usuarioSesion->getTelefono();
        $email = $usuarioSesion->getEmail();
        $password = $usuarioSesion->getPassword();
    } else {
        echo "Error: No se pudo obtener el usuario.";
        exit();
    }
} else {
    echo "Error: Falta el valor de DNI.";
    exit();
}
//Verificamos si el form se ha enviado (con confirmar)
if (isset($_POST["confirmar"])) {

    //Obtenemos el DNI
    $dniUsuario = $usuarioSesion->getDni();

    //Y eliminamos el usuario
    if (Usuario::eliminarUsuario($dniUsuario)) {
        //Destruimos la sesión y redirigimos al login
        session_destroy();
        session_start();
        $_SESSION["mensajeEliminado"] = "Se han eliminado los datos del usuario";
        header("Location: login.php");
        exit();
    } else {
        //Si nos encontramos con un error, volvemos a la página de eliminar
        header("Location: delete_user.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="stylesheet.css">
    <title>Ejercicio PDO</title>
</head>

<body>

    <div class="vh-center">
        <div id="contenedor">
            <div>
                <h1 class="titulo">Mi Cuenta</h1>
                <h2 style="color: white">Mis Datos</h2>
                <p style="color: white">¿Seguro que quieres eliminar tu cuenta? Si es así, pulsa "Confirmar".</p>

                <form method="POST" action="delete_user.php">
                    <input type="text" name="dni" value="<?php echo $dni; ?>" disabled placeholder="DNI">
                    <input type="text" name="nombre" value="<?php echo $nombre; ?>" disabled placeholder="Nombre">
                    <input type="text" name="direccion" value="<?php echo $direccion; ?>" disabled placeholder="Dirección">
                    <input type="text" name="localidad" value="<?php echo $localidad; ?>" disabled placeholder="Localidad">
                    <input type="text" name="provincia" value="<?php echo $provincia; ?>" disabled placeholder="Provincia">
                    <input type="text" name="telefono" value="<?php echo $telefono; ?>" disabled placeholder="Teléfono">
                    <input type="email" name="email" value="<?php echo $email; ?>" disabled placeholder="Email">
                    <input type="password" name="password" value="<?php echo $password; ?>" disabled
                        placeholder="Contraseña">

                    <button type="submit" name="confirmar">Confirmar</button>
                    <button type="button" onclick="history.back()">Volver</button>
                </form>
            </div>
        </div>
    </div>
</body>

</html>