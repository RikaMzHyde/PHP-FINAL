<?php
include("user_class.php");
// include("functions/security.php");

$mensaje = '';
$mensajeTipo = '';

$dni = $_GET['dni'] ?? '';
$email = $_GET['email'] ?? '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $dni = $_POST["dni"];
    $email = $_POST["email"];
    $nuevoPwd = $_POST["nuevopassword"];
    $confirmarPwd = $_POST["confirmarpassword"];

    //Verificamos si las contraseñas coinciden
    if ($nuevoPwd != $confirmarPwd) {
        $mensaje = "Las contraseñas no coinciden. Vuelve a intentarlo.";
        $mensajeTipo = 'error';
    } else {
        $usuarioSesion = Usuario::obtenerUsuarioDNI($dni);

        if ($usuarioSesion && $usuarioSesion->getEmail() == $email) {
            //Modificamos la contraseña en la base de datos
            $usuarioSesion->modificarPassword($nuevoPwd);
            $mensaje = "Contraseña modificada correctamente.";
            $mensajeTipo = 'exito';
            header("refresh:2;url=login.php");
        } else {
            $mensaje = "No se pudo modificar la contraseña. Verifica tu DNI y correo electrónico.";
            $mensajeTipo = 'error';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="stylesheet.css">
    <title>Modificar Contraseña</title>
</head>

<body>
    <div class="vh-center">
        <div id="contenedor">
            <div id="login">
                <h1 class="titulo">Modificar Contraseña</h1>

                <!-- Mostrar mensajes de error o éxito -->
                <?php if (!empty($mensaje)): ?>
                    <div style="color: <?php echo $mensajeTipo === 'error' ? 'red' : 'green'; ?>; text-align: center; font-size: 16px; margin-top: 10px;">
                        <?php echo $mensaje; ?>
                    </div>
                    <br>
                <?php endif; ?>

                <form action="change_password.php" method="POST">
                    <input type="password" name="nuevopassword" placeholder="Introduce tu nueva contraseña" required>

                    <input type="password" name="confirmarpassword" placeholder="Confirma tu nueva contraseña" required>

                    <input type="hidden" name="dni" value="<?php echo htmlspecialchars($dni); ?>">
                    <input type="hidden" name="email" value="<?php echo htmlspecialchars($email); ?>">

                    <button type="submit">Cambiar Contraseña</button>
                </form>

                <div class="footer">
                    <form action="login.php" method="get">
                        <button type="submit">Volver</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>