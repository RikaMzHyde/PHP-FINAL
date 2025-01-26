<?php
include("user_class.php");
session_start();
$mensajeEliminado = "";
$mensajeError = "";
$mensajeConfirmacion = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //Obtenemos el nombre y contraseña del usuario
    $dni = $_POST["dni"];
    $password = $_POST["password"];

    //Llama a usuarioContrasena de la clase usuario para obtener los datos del usuario
    $usuarioObj = Usuario::login($dni, $password);
    //Si el login ha sido exitoso (el usuario es válido)
    if ($usuarioObj) {
        //Almacena el DNI en la sesión (como cadena, no objeto)
        $_SESSION["dni"] = $dni;
        if ($usuarioObj->getAdmin() == 1) {
            //Si es admin, lo redirige a admin_session
            $_SESSION['rol'] = 'ADMIN';
            header("Location: admin_session.php");
            exit();
        } else if ($usuarioObj->getEditor() == 1) {
            //Si es editor, lo redirige a editor_session
            $_SESSION['rol'] = 'EDITOR';
            header("Location: editor_session.php");
            exit();
        } else {
            //Si es un usuario normal, se le redirige a user_session
            $_SESSION['rol'] = 'USER';
            header("Location: user_session.php?dni=" . urlencode($dni));
            exit();
        }
    } else {
        //Si el login falla, se guarda el mensaje de error en la variable de sesión
        $_SESSION["mensajeError"] = "Usuario o contraseña incorrectos";
        //Así evitamos que se muestre el mensaje de error por defecto al recargar la página
        header("Location: login.php");
        exit();
    }
}
//Verifica si hay un mensaje de confirmación guardado en la sesión
if (isset($_SESSION["mensajeConfirmacion"])) {
    $mensajeConfirmacion = $_SESSION["mensajeConfirmacion"];
    //Elimina el mensaje de confirmación de la sesión después de transferirlo a una variable temporal
    unset($_SESSION["mensajeConfirmacion"]);
}

//Verifica si hay un mensaje de error guardado en la sesión
if (isset($_SESSION["mensajeError"])) {
    $mensajeError = $_SESSION["mensajeError"];
    //Elimina el mensaje de error de la sesión después de mostrarlo
    unset($_SESSION["mensajeError"]);
}

//Verifica si hay un mensaje de eliminación en la URL
if (isset($_SESSION["mensajeEliminado"])) {
    $mensajeEliminado = $_SESSION["mensajeEliminado"];
    //Y lo elimina después de mostrarlo
    unset($_SESSION["mensajeEliminado"]);
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="stylesheetcart.css?v=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
    <title>Amato - Login</title>
</head>

<body class="d-flex flex-column min-vh-100">
<nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand fs-2" href="#">Amato</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="index.php">Inicio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Contacto</a>
                    </li>
                    <a class="nav-link" href="login.php">
                        <i class="bi bi-person"></i> Mi Cuenta
                    </a>
                </ul>
            </div>
            <a href="cart.php" class="nav-link ms-3"><i class="bi bi-cart3 fs-4"></i></a>
            <div class="cart-summary d-flex align-items-center justify-content-end p-3">
                <span class="me-3">Items en carrito: <strong id="cart-items-count">0</strong></span>
                <span>Total: <strong id="cart-total-price">0.00</strong> €</span>
            </div>
        </div>
    </nav>
    <main class="flex-grow-1">
    <div class="vh-center">
        <div id="contenedor">
            <div id="login">
                <h1 class="titulo">¡Bienvenido!</h1>
                <!-- Mostrar mensaje de eliminación -->
                <?php if (!empty($mensajeEliminado)): ?>
                    <div style="color: green; font-weight: bold; margin-bottom: 10px;">
                        <?php echo $mensajeEliminado; ?>
                    </div>
                <?php endif; ?>

                <!-- Mostrar mensaje de confirmación -->
                <?php if (!empty($mensajeConfirmacion)): ?>
                    <div style="color: green; font-weight: bold; margin-bottom: 10px;">
                        <?php echo $mensajeConfirmacion; ?>
                    </div>
                <?php endif; ?>

                <form action="login.php" method="POST">
                    <input type="text" name="dni" placeholder="DNI (Usuario)" required>
                    <input type="password" placeholder="Contraseña" name="password" required>
                    <button type="submit" name="submit">Entrar</button>
                </form>

                <!-- Mostrar mensaje de error-->
                <?php if (!empty($mensajeError)): ?>
                    <div style="color: red; font-weight: bold; margin-top: 10px;">
                        <?php echo $mensajeError; ?>
                    </div>
                <?php endif; ?>
                <div class="footer">
                <br>
                    <a href="new_user.php">¿Es tu primera vez aquí? ¡Registrate!</a>
                    <br><br>
                    <a href="recover_password.php">¿Has olvidado la contraseña?</a>
                </div>
            </div>
        </div>
    </div>
    </main>
    <footer class="footer py-4 mt-auto">
        <div class="container">
            <div class="row gy-4">
                <div class="col-12 col-md-4">
                    <h5 class="mb-3">Amato</h5>
                    <p class="small">Tu proveedor de productos de importación Japoneses de confianza 🌸</p>
                </div>
                <div class="col-12 col-md-4">
                    <h5 class="mb-3">Enlaces</h5>
                    <ul class="list-unstyled">
                        <li><a href="#" class="text-decoration-none txt-custom">Política de Privacidad</a></li>
                        <li><a href="#" class="text-decoration-none txt-custom">Términos y Condiciones</a></li>
                        <li><a href="#" class="text-decoration-none txt-custom">Contacto</a></li>
                    </ul>
                </div>
                <div class="col-12 col-md-4">
                    <h5 class="mb-3">Síguenos</h5>
                    <div class="d-flex gap-3">
                        <a href="#" class="txt-custom"><i class="bi bi-facebook"></i></a>
                        <a href="#" class="txt-custom"><i class="bi bi-twitter"></i></a>
                        <a href="#" class="txt-custom"><i class="bi bi-instagram"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <div class="py-2 text-center txt-custom small" style="background-color: #4e4363;">
        © 2024 Amato - Todos los derechos reservados
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>