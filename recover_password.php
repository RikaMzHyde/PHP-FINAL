<?php
include("user_class.php");
// include("functions/security.php");


$mensaje = '';
$mensajeTipo = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $dni = $_POST["dni"];
    $email = $_POST["email"];

    if ($dni && $email) {
        //Verificamos si existe un usuario con el DNI y email introducidos
        $usuarioSesion = Usuario::obtenerUsuarioDNI($dni);

        if ($usuarioSesion && $usuarioSesion->getEmail() == $email) {
            //Si el usuario existe y el email coincide
            $mensaje = "Usuario encontrado. Puedes restablecer tu contraseña.";
            $mensajeTipo = 'exito';

            //Redirigir a la página para que el usuario pueda ingresar su nueva contraseña
            header("Location: change_password.php?dni=" . urlencode($dni) . "&email=" . urlencode($email));
            exit();
        } else {
            $mensaje = "Usuario no encontrado o correo electrónico incorrecto.";
            $mensajeTipo = 'error';
        }
    } else {
        $mensaje = "Por favor, ingresa tu DNI y correo electrónico.";
        $mensajeTipo = 'error';
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="stylesheet.css">
    <title>Recuperar Contraseña</title>
</head>

<body>
    <div class="vh-center">
        <div id="contenedor">
            <div id="login">
                <h1 class="titulo">Recuperar Contraseña</h1>

                <!-- Mostrar mensaje de error o éxito dentro del card -->
                <?php if (!empty($mensaje)): ?>
                    <div style="color: <?php echo $mensajeTipo === 'error' ? 'red' : 'green'; ?>; text-align: center; font-size: 16px; margin-top: 10px;">
                        <?php echo $mensaje; ?>
                    </div>
                    <br>
                <?php endif; ?>

                <form action="recover_password.php" method="POST">
                    <input type="text" name="dni" placeholder="DNI" required>
                    <input type="email" name="email" placeholder="Email" required>
                    <button type="submit">Reestablecer Contraseña</button>
                    <div class="footer">
                        <button type="button" onclick="window.history.back();" class="btn">Volver</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>