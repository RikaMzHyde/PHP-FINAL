<?php
require_once("connect.php");
include("functions/security.php");
include("user_class.php");

//Verificamos si se ha proporcionado un DNI para saber qué usuario se va a modificar
if (isset($_GET["dni"])) {
    $dni = $_GET["dni"];

    //Usamos la clase usuario para obtener los datos del usuario con ese DNI
    $usuarioSesion = Usuario::obtenerUsuarioDNI($dni);

    //Si se encuentra el usuario, asignamos los datos a variables
    if ($usuarioSesion) {
        $dni = $usuarioSesion->getDni();
        $nombre = $usuarioSesion->getNombre();
        $direccion = $usuarioSesion->getDireccion();
        $localidad = $usuarioSesion->getLocalidad();
        $provincia = $usuarioSesion->getProvincia();
        $telefono = $usuarioSesion->getTelefono();
        $email = $usuarioSesion->getEmail();
        $password = $usuarioSesion->getPassword();
        $admin = $usuarioSesion->getAdmin();
        $editor = $usuarioSesion->getEditor();
    } else {
        echo "Error: No se pudo obtener el usuario.";
        exit();
    }
} else {
    echo "Error: Falta el valor de usuario.";
    exit();
}



//Si el formulario se ha enviado y se ha confirmado la acción de modificar
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["confirmar"])) {
    $nombre = $_POST["nombre"];
    $direccion = $_POST["direccion"];
    $localidad = $_POST["localidad"];
    $provincia = $_POST["provincia"];
    $telefono = $_POST["telefono"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $admin = null;
    $editor = null;
    if($_SESSION['dni'] != $dni){
        $admin = isset($_POST["admin"]) ? 1 : 0;
        $editor = isset($_POST["editor"]) ? 1 : 0;
    }
    

    //Si el usuario es admin, también se marca como editor
    if ($admin == 1) {
        $editor = 1;
    }

    //Validar email en el servidor
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION["mensajeError"] = "El correo electrónico no es válido. Por favor, verifica el formato.";
        header("Location: modify_admin.php?dni=$dni");
        exit();
    }

    if (
        $nombre != $usuarioSesion->getNombre() ||
        $direccion != $usuarioSesion->getDireccion() ||
        $localidad != $usuarioSesion->getLocalidad() ||
        $provincia != $usuarioSesion->getProvincia() ||
        $telefono != $usuarioSesion->getTelefono() ||
        $email != $usuarioSesion->getEmail() ||
        $password != $usuarioSesion->getPassword() ||
        $admin != $usuarioSesion->getAdmin() ||
        $editor != $usuarioSesion->getEditor()
    ) {
        //Llamamos a "modificarUsuario" para actualizar la información
        $password = $password == $usuarioSesion->getPassword() ? null : $password;
        if (Usuario::modificarUsuario($dni, $nombre, $direccion, $localidad, $provincia, $telefono, $email, $password, $admin, $editor)) {
            //Redirige a admin_session
            $_SESSION["mensaje"] = '<p style="color: green; font-weight: bold; margin-bottom: 10px;">Datos modificados con éxito</p>';
            header("Location: admin_session.php");
            exit();
        } else {
            echo "Error al modificar el usuario.";
        }
    } else {
        header("Location: admin_session.php?dni=$dni");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="stylesheetcart.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">    <title>Actualizar usuario</title>
    <script>
        //Validación del email en el cliente
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

            //Sincronizar el checkbox de editor con admin
            adminCheckbox.addEventListener("change", function() {
                if (adminCheckbox.checked) {
                    editorCheckbox.checked = true;
                }
            });

            //Asegurar sincronización al cargar la página
            if (adminCheckbox.checked) {
                editorCheckbox.checked = true;
            }
        });
    </script>
</head>

<body>
    <?php require('navbar.php') ?>
    <main class="py-5">
        <div class="vh-center">
            <div id="contenedor">
                <div>
                    <h1 class="titulo">Actualizar Usuario</h1>
                </div>

                <div>
                    <h2 class="titulo">Estos son los datos que puedes Modificar:</h2>
                </div>

                <div>
                    <?php
                    if (isset($_SESSION["mensajeError"])) {
                        echo '<div style="color: red;">' . $_SESSION["mensajeError"] . "</div>";
                        unset($_SESSION["mensajeError"]);
                    }
                    ?>
                    <form method="POST" action="modify_admin.php?dni=<?= $dni; ?>">
                        <label for="dni">DNI:</label>
                        <input type="text" name="dni" value="<?= $dni; ?>" disabled>

                        <label for="nombre">Nombre:</label>
                        <input type="text" name="nombre" value="<?= $nombre; ?>" required>

                        <label for="direccion">Dirección:</label>
                        <input type="text" name="direccion" value="<?= $direccion; ?>" required>

                        <label for="localidad">Localidad:</label>
                        <input type="text" name="localidad" value="<?= $localidad; ?>" required>

                        <label for="provincia">Provincia:</label>
                        <input type="text" name="provincia" value="<?= $provincia; ?>" required>

                        <label for="telefono">Teléfono:</label>
                        <input type="text" name="telefono" value="<?= $telefono; ?>" pattern="\d{9}" title="El teléfono debe contener exactamente 9 dígitos" required>

                        <label for="email">Email:</label>
                        <input type="email" name="email" value="<?= $email; ?>" required>

                        <label for="password">Password:</label>
                        <input type="password" name="password" value="<?= $password; ?>" required>

                        <div>
                            <label for="admin" style="color: white;">Asignar Privilegios de Administrador</label>
                            <!-- Con el session dni deshabilitamos los checkbox si se intenta editar sus propios permisos -->
                            <input
                                type="checkbox"
                                <?=
                                $_SESSION['dni'] == $dni ? 'disabled' : ''
                                ?>
                                id="admin"
                                name="admin"
                                value="1"
                                style="transform: scale(0.8); margin-right: 5px;"
                                <?= $admin ? 'checked' : ''; ?>>
                        </div>
                        <div>
                            <label for="editor" style="color: white;">Asignar Privilegios de Editor</label>
                            <!-- Con el session dni deshabilitamos los checkbox si se intenta editar sus propios permisos -->
                            <input
                                type="checkbox"
                                <?=
                                $_SESSION['dni'] == $dni ? 'disabled' : ''
                                ?>
                                id="editor"
                                name="editor"
                                value="1"
                                style="transform: scale(0.8); margin-right: 5px;"
                                <?= $editor ? 'checked' : ''; ?>>
                        </div>

                        <div class="footer">
                            <button type="submit" name="confirmar" class="btn">Confirmar</button>
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