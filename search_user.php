<?php
include("user_class.php");
include("functions/security.php");

$msg = "";
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    //Obtiene el valor del DNI si está disponible
    $dni = isset($_GET["dni"]) ? $_GET["dni"] : null;

    if ($dni) {
        //Llamamos a obtenerUsuarioDNI de la clase usuario apara obtener la info del usuario a partir de su DNI
        $usuario = Usuario::obtenerUsuarioDNI($dni);
        //Si se encuentra el usuario, sacamos sus datos y los asignamos a variables para usarlos luego
        if ($usuario) {
            $dniUsuario = $usuario->getDni();
            $nombreUsuario = $usuario->getNombre();
            $direccionUsuario = $usuario->getDireccion();
            $localidadUsuario = $usuario->getLocalidad();
            $provinciaUsuario = $usuario->getProvincia();
            $telefonoUsuario = $usuario->getTelefono();
            $emailUsuario = $usuario->getEmail();
        } else {
            $msg = "Usuario no encontrado";
        }
    }
} else {
    $msg = "Acceso no válido";
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="stylesheetcart.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
    <title>Buscar usuario</title>
</head>

<body>
    <?php require('navbar.php') ?>
    <main class="py-5"></main>
    <div class="vh-center">
        <div id="contenedor">
            <div>
                <h1 class="titulo">Buscar usuario</h1>
            </div>
            <div style="color: red">
                <?= $msg ?>
            </div>
            <?php if (isset($dniUsuario)) : ?>
                <div style="color:white">
                    <strong>Datos Personales</strong><br><br>
                    <strong>DNI:</strong> <?php echo $dniUsuario; ?><br>
                    <strong>Nombre:</strong> <?php echo $nombreUsuario; ?><br>
                    <strong>Dirección:</strong> <?php echo $direccionUsuario; ?><br>
                    <strong>Localidad:</strong> <?php echo $localidadUsuario; ?><br>
                    <strong>Provincia:</strong> <?php echo $provinciaUsuario; ?><br>
                    <strong>Teléfono:</strong> <?php echo $telefonoUsuario; ?><br>
                    <strong>Email:</strong> <?php echo $emailUsuario; ?><br><br><br>
                </div>
            <?php endif; ?>

            <div id="buscador">
                <form action="search_user.php" method="get">
                    <label for="dni" class="label" style="font-weight: bold; color: white">Introduce el DNI del usuario</label>
                    <input type="text" id="dni" name="dni" required class="input">
                    <button type="submit">Buscar</button>
                    <button type="button" onclick="window.history.back()">Volver</button>
                    <button type="button" onclick="window.location.href='admin_session.php'">Volver a "Mantenimiento de Clientes"</button>
                </form>
            </div>
        </div>
    </div>
    </main>
    <?php require('footer.php'); ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>