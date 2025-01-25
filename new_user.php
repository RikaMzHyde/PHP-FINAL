<?php
// include("security.php");
include("user_class.php");

$mensajeError = "";

//Función para validar el DNI en PHP
function esDniValido($dni)
{
    if (preg_match('/^\d{8}[A-Za-z]$/', $dni)) {
        $numero = substr($dni, 0, 8);
        $letra = strtoupper(substr($dni, -1));
        $letrasValidas = "TRWAGMYFPDXBNJZSQVHLCKE";
        return $letra === $letrasValidas[$numero % 23];
    }
    return false;
}

//Si el formulario fue enviado, obtenemos los datos del formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $dni = $_POST["dni"];
    $nombre = $_POST["nombre"];
    $direccion = $_POST["direccion"];
    $localidad = $_POST["localidad"];
    $provincia = $_POST["provincia"];
    $telefono = $_POST["telefono"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $admin = $_POST["admin"];
    $editor = $_POST["editor"];

    //Validamos DNI en el servidor
    if (!esDniValido($dni)) {
        $_SESSION["mensajeError"] = "El DNI ingresado no es válido. Por favor, verifica los números y la letra.";
        header("Location: new_user.php");
        exit;
    }

    //Validamos email en el servidor
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION["mensajeError"] = "El correo electrónico no es válido. Por favor, verifica el formato.";
        header("Location: new_user.php");
        exit;
    }

    //Llamamos a registrarUsuario de la clase usuario para registrar el nuevo usuario
    if (Usuario::registrarUsuario($dni, $nombre, $direccion, $localidad, $provincia, $telefono, $email, $password, $admin, $editor)) {

        $_SESSION["mensajeConfirmacion"] = "Usuario registrado correctamente";

        header("Location: login.php");
        exit;
    } else {
        //Si no se ha podido registrar, mostramos el mensaje de error
        $_SESSION["mensajeError"] = "El usuario con ese DNI ya se encuentra registrado";
        header("Location: new_user.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nuevo Usuario</title>
    <link rel="stylesheet" href="stylesheet.css">
    <script>
        //Función para validar el DNI en el cliente
        function esDniValido(dni) {
            const dniRegex = /^\d{8}[A-Za-z]$/;
            const letrasValidas = "TRWAGMYFPDXBNJZSQVHLCKE";
            if (dniRegex.test(dni)) {
                const numero = parseInt(dni.slice(0, -1), 10);
                const letra = dni.slice(-1).toUpperCase();
                return letra === letrasValidas[numero % 23];
            }
            return false;
        }

        document.addEventListener("DOMContentLoaded", function() {
            const form = document.querySelector("form");
            form.addEventListener("submit", function(e) {
                const dniInput = document.querySelector('input[name="dni"]');
                if (!esDniValido(dniInput.value)) {
                    e.preventDefault();
                    const form = e.target;
                    form.action = 'new_user.php';
                    form.submit();
                }
            });
        });

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
            <div id="titulo">
                <h1 class="titulo">Nuevo Usuario</h1>
                <h2 style="color:white">Inserta tus datos</h2>
            </div>
            <div>
                <?php
                if (isset($_SESSION["mensajeError"])) {
                    echo '<div style="color: red; font-weight: bold">' . $_SESSION["mensajeError"] . "</div>";
                    //Para que no se muestre otra vez al actualizar la pagina
                    unset($_SESSION["mensajeError"]);
                }
                ?>
                <form method="POST" action="new_user.php">
                    <input type="text" name="dni" placeholder="DNI (Usuario)" required pattern="^\d{8}[A-Za-z]$"
                        title="El DNI debe tener 8 números seguidos de una letra">
                    <input type="text" name="nombre" placeholder="Nombre" required>
                    <input type="text" name="direccion" placeholder="Dirección" required>
                    <input type="text" name="localidad" placeholder="Localidad" required>
                    <input type="text" name="provincia" placeholder="Provincia" required>
                    <input type="tel" name="telefono" placeholder="Teléfono" required pattern="\d{9}"
                        title="El teléfono debe contener exactamente 9 dígitos">
                    <input type="email" name="email" placeholder="Email" required 
                        pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$"
                        title="El correo debe tener un formato válido, como usuario@dominio.com">
                    <input type="password" name="password" placeholder="Contraseña" required>
                    <input type="hidden" name="admin" value="0">
                    <input type="hidden" name="editor" value="0">
                    <button type="submit">Confirmar</button>
                    <div class="footer">
                        <button type="button" onclick="window.history.back();" class="btn">Volver</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>