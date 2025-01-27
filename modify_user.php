<?php
include("connect.php");
include("functions/security.php");
include("user_class.php");


//Verificamos si hay una sesión activa con datos del usuario y obtenemos el usuario desde la sesión
if (isset($_SESSION["dni"])) {
    $dni = $_SESSION["dni"];

    if ($dni) {
        //Si se ha obtenido el DNI correctamente, obtenemos todos los datos del usuario
        $usuarioSesion = Usuario::obtenerUsuarioDNI($dni);

        if ($usuarioSesion) {
            //Los asignamos a variables para usarlos luego
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
        echo "Error: No se pudo obtener el DNI del usuario.";
        exit();
    }
} else {
    echo "Error: Falta el valor de usuario.";
    exit();
}
//Si se ha confirmado el envío
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["confirmar"])) {
    //Obtenemos el DNI del usuario y cogemos los valores actualizados enviados en el formulario
    $dniUsuario = $usuarioSesion->getDni();
    $nombre = $_POST["nombre"];
    $direccion = $_POST["direccion"];
    $localidad = $_POST["localidad"];
    $provincia = $_POST["provincia"];
    $telefono = $_POST["telefono"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $password = $password == $usuarioSesion->getPassword() ? null : $password;

    //Llamamos a modificarUsuario de la clase usuario para actualizar los datos en la BD
    if (Usuario::modificarUsuario($dniUsuario, $nombre, $direccion, $localidad, $provincia, $telefono, $email, $password, null, null)) {
        //Redirige a user_session después de la modificación
        header("Location: user_session.php?mensaje=exito");
        exit();
    } else {
        echo "Error al modificar el usuario.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="stylesheet.css">
    <title>Modificar</title>
    <script>
        //Función para validar el formato de email en tiempo real
        document.addEventListener("DOMContentLoaded", function() {
            const emailInput = document.querySelector('input[name="email"]');
            const emailPattern = /^[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$/;

            emailInput.addEventListener("input", function () {
                if (emailInput.value === "" || emailPattern.test(emailInput.value)) {
                    emailInput.setCustomValidity("");
                } else {
                    emailInput.setCustomValidity("El correo debe tener un formato válido, como usuario@dominio.com");
                }
            });
        });
    </script>
</head>

<body>

    <div class="vh-center">
        <div id="contenedor">
            <div>
                <div class="titulo">
                    <h1>Estos son los datos que puedes modificar</h1>
                </div>
                <form method="POST" action="modify_user.php">
                    <div class="dato">
                        <label for="dni">DNI:</label>
                        <input type="text" id="dni" name="dni" value="<?php echo $dni; ?>" disabled>
                    </div>
                    <div class="dato">
                        <label for="nombre">Nombre:</label>
                        <input type="text" id="nombre" name="nombre" value="<?php echo $nombre; ?>" required>
                    </div>
                    <div class="dato">
                        <label for="direccion">Dirección:</label>
                        <input type="text" id="direccion" name="direccion" value="<?php echo $direccion; ?>" required>
                    </div>
                    <div class="dato">
                        <label for="localidad">Localidad:</label>
                        <input type="text" id="localidad" name="localidad" value="<?php echo $localidad; ?>" required>
                    </div>
                    <div class="dato">
                        <label for="provincia">Provincia:</label>
                        <input type="text" id="provincia" name="provincia" value="<?php echo $provincia; ?>" required>
                    </div>
                    <div class="dato">
                        <label for="telefono">Teléfono:</label>
                        <input type="tel" id="telefono" name="telefono" value="<?php echo $telefono; ?>" pattern="\d{9}" title="El teléfono debe contener exactamente 9 dígitos" required>
                    </div>
                    <div class="dato">
                        <label for="email">Email:</label>
                        <input type="email" id="email" name="email" value="<?php echo $email; ?>" required 
                               pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" 
                               title="El correo debe tener un formato válido, como usuario@dominio.com">
                    </div>
                    <div class="dato">
                        <label for="password">Password:</label>
                        <input type="password" id="password" name="password" value="<?php echo $password; ?>" required>
                    </div>
                    <div class="form-actions">
                        <button type="submit" name="confirmar" class="btn">
                            Confirmar
                        </button>
                        <button type="button" onclick="history.back()" class="btn">
                            Volver
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>
