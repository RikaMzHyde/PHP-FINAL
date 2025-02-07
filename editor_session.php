<?php
require_once("connect.php");
include("functions/security.php");

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
            
            $_SESSION['user_address'] = [
                'nombre' => $nombre,
                'direccion' => $direccion,
                'localidad' => $localidad,
                'provincia' => $provincia,
                'telefono' => $telefono,
                'email' => $email
            ];
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
$mensajeError = isset($_GET["mensaje"]) && $_GET["mensaje"] === "error";
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="stylesheetcart.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
    <title>Sesión de Editor</title>
</head>

<body>
<?php require('navbar.php') ?>
<main class="py-5">

    <div class="vh-center">
        <div id="contenedor">
            <!-- Sección de datos del usuario -->
            <div id="datosmostrados">
                <h1 class="titulo">Mi Cuenta</h1>
                <h2 style="color: white; text-align: center; margin-bottom: 20px;">Mis Datos</h2>

                <!-- Mensajes de estado -->
                <?php if ($mensajeExito): ?>
                    <div class="footer" style="color: green; font-weight: bold; margin-bottom: 10px;">Datos modificados con éxito</div>
                <?php elseif ($mensajeError): ?>
                    <div class="footer" style="color: red; font-weight: bold; margin-bottom: 10px;">Error al modificar los datos</div>
                <?php endif; ?>

                <!-- Datos del usuario -->
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

            <!-- Opciones disponibles -->
            <div id="login">
                <h2 class="titulo">¿Qué necesitas?</h2>
                <div class="footer">
                    <form action="delete_user.php" method="get">
                        <button type="submit" id="autoeliminado" class="btn">Eliminar Datos</button>
                    </form>

                    <form action="modify_user.php" method="get">
                        <button type="submit" id="automodificado" class="btn">Modificar Datos</button>
                    </form>

                    <form action="editor_articles.php" method="get">
                        <button type="submit" id="editorarticles" class="btn">Herramientas de Editor</button>
                    </form>

                    <form action="logout.php" method="get">
                        <button type="submit" id="logout" class="btn">Cerrar Sesión</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>
<?php require('footer.php'); ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
