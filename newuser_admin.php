<?php
include("user_class.php");
include("functions/security.php");

//Función para validar el DNI
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

$mensajeError = "";

//Si el formulario se ha enviado, recoge los datos del formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $dni = $_POST["dni"];
    $nombre = $_POST["nombre"];
    $direccion = $_POST["direccion"];
    $localidad = $_POST["localidad"];
    $provincia = $_POST["provincia"];
    $telefono = $_POST["telefono"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    //Verificamos si se ha marcado la casilla de admin o no
    $admin = isset($_POST["admin"]) ? 1 : 0;
    //Verificamos si se ha marcado la casilla de editor o no
    $editor = isset($_POST["editor"]) ? 1 : 0;

    //Si se pulsa la opción de admin, se le asignará también el rol de editor
    if ($admin == 1) {
        $editor = 1;
    }

    //Validamos el DNI en el servidor
    if (!esDniValido($dni)) {
        $_SESSION["mensaje"] = "El DNI ingresado no es válido. Por favor, verifica los números y la letra.";
        header("Location: newuser_admin.php");
        exit;
    }

    //Validamos del email en el servidor
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION["mensaje"] = "El correo electrónico no es válido. Por favor, verifica el formato.";
        header("Location: newuser_admin.php");
        exit;
    }

    //Llama a registrarUsuario de la clase usuario para registrar al nuevo usuario
    if (Usuario::registrarUsuario($dni, $nombre, $direccion, $localidad, $provincia, $telefono, $email, $password, $admin, $editor)) {
        // Establecemos un mensaje de confirmación en la sesión
        $_SESSION["mensaje"] = '<p style="color: green; font-weight: bold; margin-bottom: 10px;">Usuario registrado correctamente</p>';
        header("Location: admin_session.php");
        exit;
    } else {
        //Si no se ha podido registrar, mostramos el mensaje de error
        $_SESSION["mensaje"] = "El usuario con ese DNI ya se encuentra registrado";
        header("Location: newuser_admin.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear usuario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="stylesheetcart.css">    <script>
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
                    form.action = 'newuser_admin.php';
                    form.submit();
                }
            });
        });

        //Función para validar el formato de email en tiempo real
        document.addEventListener("DOMContentLoaded", function() {
            const emailInput = document.querySelector('input[name="email"]');
            const emailPattern = /^[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$/;

            emailInput.addEventListener("input", function() {
                if (emailInput.value === "" || emailPattern.test(emailInput.value)) {
                    emailInput.setCustomValidity("");
                } else {
                    emailInput.setCustomValidity("El correo debe tener un formato válido, como usuario@dominio.com");
                }
            });
        });

        document.addEventListener("DOMContentLoaded", function() {
            const adminCheckbox = document.getElementById("admin");
            const editorCheckbox = document.getElementById("editor");

            //Sincroniza el checkbox de editor con admin
            adminCheckbox.addEventListener("change", function() {
                if (adminCheckbox.checked) {
                    editorCheckbox.checked = true;
                }
            });

            //Validamos valores antes de enviar
            const form = document.querySelector("form");
            form.addEventListener("submit", function(e) {
                if (adminCheckbox.checked) {
                    editorCheckbox.checked = true;
                    editorCheckbox.value = "1";
                }
            });
        });
    </script>
</head>

<body>
<?php require('navbar.php') ?>
<main class="py-5">
    <div class="vh-center">
        <div id="contenedor">
            <div id="titulo">
                <h1 class="titulo">Crear Nuevo Usuario</h1>
                <h2 style="color:white">Datos del Usuario:</h2>
            </div>
            <div>
                <?php
                if (isset($_SESSION["mensaje"])) {
                    echo '<div class="error">' . $_SESSION["mensaje"] . "</div>";
                    //Para que no se muestre otra vez al actualizar la pagina
                    unset($_SESSION["mensaje"]);
                }
                ?>
                <form method="POST" action="newuser_admin.php">
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
                    <div>
                        <label for="admin" style="color: white;">Asignar Privilegios de Administrador</label>
                        <input type="checkbox" id="admin" name="admin" value="1" style="transform: scale(0.8); margin-right: 5px;">
                    </div>
                    <div>
                        <label for="editor" style="color: white;">Asignar Privilegios de Editor</label>
                        <input type="checkbox" id="editor" name="editor" value="1" style="transform: scale(0.8); margin-right: 5px;">
                    </div>
                    <script>
                        document.addEventListener("DOMContentLoaded", function() {
                            const adminCheckbox = document.getElementById("admin");
                            const editorCheckbox = document.getElementById("editor");

                            adminCheckbox.addEventListener("change", function() {
                                if (adminCheckbox.checked) {
                                    editorCheckbox.checked = true;
                                }
                            });
                        });
                    </script>
                    <div class="form-actions">
                        <button type="submit" name="confirmar" class="btn">Agregar Usuario</button>
                        <button type="button" onclick="history.back()" class="btn">Volver</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    </main>
    <?php require('footer.php'); ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>