<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //Procesamos los datos del formulario (cogemos nombre, email y mensaje)
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $mensaje = $_POST['mensaje'];

    //Solo mostraremos un mensaje de éxito
    $success = true;
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Amato - Contacto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="stylesheetcart.css">
    <style>
        .success {
            background-color: rgba(80, 255, 203, 0.2);
            border: 1px solid rgb(80, 255, 203);
            border-radius: 5px;
            padding: 10px;
            margin-bottom: 20px;
            text-align: center;
        }
    </style>
</head>

<body>
    <?php require('navbar.php') ?>
    <main class="vh-center">
        <div id="contenedor">
            <h1 class="titulo"><i class="bi bi-envelope-heart"></i> Contacto</h1>

            <!-- Mostramos mensaje de éxito si el form se envió correctamente -->
            <?php if (isset($success) && $success): ?>
                <div class="success">
                    <i class="bi bi-check-circle-fill"></i> ¡Gracias por tu mensaje! Te responderemos pronto.
                </div>
            <?php endif; ?>

            <!-- Formulario como tal-->
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                <input type="text" id="nombre" name="nombre" placeholder="Nombre" required>
                <input type="email" id="email" name="email" placeholder="Email" required>
                <textarea id="mensaje" name="mensaje" placeholder="Mensaje" rows="10" cols="41"></textarea>
                <button type="submit" class="btn-custom">
                    <i class="bi bi-send"></i> Enviar mensaje
                </button>
            </form>
        </div>
    </main>

    <?php require('footer.php'); ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>