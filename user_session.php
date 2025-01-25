<?php
include("connect.php");
include("security.php");
include("user_class.php");

//Verificamos si la sesión contiene el DNI
if (isset($_SESSION["dni"]) && !empty($_SESSION["dni"])) {
    $dni = $_SESSION["dni"];

    //Nos aseguramos de que $dni sea una cadena válida
    if (is_string($dni) && $dni !== "") {
        //Obtenemos el usuario asociado al DNI
        $usuarioSesion = Usuario::obtenerUsuarioDNI($dni);

        //Verificamos si el usuario se ha obtenido correctamente
        if ($usuarioSesion) {
            $nombre = $usuarioSesion->getNombre();
            $direccion = $usuarioSesion->getDireccion();
            $localidad = $usuarioSesion->getLocalidad();
            $provincia = $usuarioSesion->getProvincia();
            $telefono = $usuarioSesion->getTelefono();
            $email = $usuarioSesion->getEmail();
            $password = $usuarioSesion->getPassword();
        } else {
            echo "Error: No se pudo obtener el usuario con el DNI proporcionado.";
            exit();
        }
    } else {
        echo "Error: El valor del DNI en la sesión no es válido.";
        exit();
    }
} else {
    echo "Error: No se encontró el DNI en la sesión.";
    exit();
}

$mensajeExito = isset($_GET["mensaje"]) && $_GET["mensaje"] === "exito";
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
            <div id="datosmostrados">
                <div class="titulo">
                    <h1>Mi Cuenta</h1>
                </div>
                <div class="titulo2">
                    <h2 style="color: white;">Mis Datos</h2>
                </div>
                <?php if ($mensajeExito) : ?>
                    <div class="footer" style="color: green; font-weight: bold; margin-bottom: 10px;">Datos modificados con éxito</div>
                    <br>
                <?php endif; ?>

                <form method="POST" action="user_session.php">
                    <input type="text" name="dni" value="<?php echo $dni; ?>" placeholder="DNI" disabled>
                    <input type="text" name="nombre" value="<?php echo $nombre; ?>" placeholder="Nombre" disabled>
                    <input type="text" name="direccion" value="<?php echo $direccion; ?>" placeholder="Dirección" disabled>
                    <input type="text" name="localidad" value="<?php echo $localidad; ?>" placeholder="Localidad" disabled>
                    <input type="text" name="provincia" value="<?php echo $provincia; ?>" placeholder="Provincia" disabled>
                    <input type="text" name="telefono" value="<?php echo $telefono; ?>" placeholder="Teléfono" disabled>
                    <input type="text" name="email" value="<?php echo $email; ?>" placeholder="Email" disabled>
                    <input type="password" name="password" value="<?php echo $password; ?>" placeholder="Contraseña" disabled>
                </form>
            </div>

            <div id="login">
                <h2 class="titulo">¿Qué necesitas?</h2>
                <div class="footer">
                    <form action="delete_user.php" method="get">
                        <button type="submit" id="autoeliminado" class="btn">Eliminar Datos</button>
                    </form>

                    <form action="modify_user.php" method="get">
                        <button type="submit" id="automodificado" class="btn">Modificar Datos</button>
                    </form>

                    <form action="user_articles.php" method="get">
                        <button type="submit" id="articulosusu" class="btn">Ver Artículos</button>
                    </form>

                    <form action="logout.php" method="get">
                        <button type="submit" id="logout" class="btn">Cerrar Sesión</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>