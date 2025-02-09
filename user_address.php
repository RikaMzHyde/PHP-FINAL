<?php
session_start();
require_once("functions/security.php");
require_once('cart_functions.php');
checkCartItems(); //Verificar si el carrito tiene items

//Si se ha enviado el form con datos con POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Guardar los datos del formulario en la sesión
    $_SESSION['user_address'] = [
        'nombre' => $_POST['nombre'],
        'apellidos' => $_POST['apellidos'],
        'direccion' => $_POST['direccion'],
        'localidad' => $_POST['localidad'],
        'provincia' => $_POST['provincia'],
        'telefono' => $_POST['telefono'],
        'email' => $_POST['email']
    ];

    //Redirigir a stripe_payment
    header('Location: stripe_payment.php');
    exit;
}

//Función para obtener los valores de la dirección almacenada en la sesión
function getAddressValue($fname)
{
    //Verifica si la clave de la dirección existe en la sesión y tiene valor
    if (isset($_SESSION['user_address']) && isset($_SESSION['user_address'][$fname]) && !empty($_SESSION['user_address'][$fname])) {
        return $_SESSION['user_address'][$fname]; //Devuelve el valor de la clave
    } else {
        return ''; //Si no existe, vacío
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Amato - Dirección de Envío</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="stylesheetcart.css">
</head>

<body class="d-flex flex-column min-vh-100">
    <?php require('navbar.php') ?>
    <main class="py-5">
        <div class="container">
            <div class="card">
                <div class="card-body">
                    <!--Formulario-->
                    <h4 class="card-title text-center mb-4">Introduzca sus Datos y Dirección de Envío</h4>
                    <form action="user_address.php" method="post">
                        <!--Nombre-->
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="nombre" name="nombre"
                                value="<?= getAddressValue('nombre') ?>" readonly>
                        </div>
                        <!--Correo-->
                        <div class="mb-3">
                            <label for="email" class="form-label">Correo Electrónico</label>
                            <input type="email" class="form-control" id="email" name="email" required
                                pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" value="<?= getAddressValue('email') ?>"
                                title="El correo debe tener un formato válido, como usuario@dominio.com" readonly>
                        </div>
                        <!--Dirección-->
                        <div class="mb-3">
                            <label for="direccion" class="form-label">Dirección</label>
                            <input type="text" class="form-control" id="direccion" name="direccion"
                                value="<?= getAddressValue('direccion') ?>" required>
                        </div>
                        <!--Localidad-->
                        <div class="mb-3">
                            <label for="localidad" class="form-label">Localidad</label>
                            <input type="text" class="form-control" id="localidad" name="localidad"
                                value="<?= getAddressValue('localidad') ?>" required>
                        </div>
                        <!--Provincia-->
                        <div class="mb-3">
                            <label for="provincia" class="form-label">Provincia</label>
                            <input type="text" class="form-control" id="provincia" name="provincia"
                                value="<?= getAddressValue('provincia') ?>" required>
                        </div>
                        <!--Teléfono-->
                        <div class="mb-3">
                            <label for="telefono" class="form-label">Teléfono</label>
                            <input type="tel" class="form-control" id="telefono" name="telefono" pattern="[0-9]{9}"
                                title="El teléfono debe tener 9 dígitos"
                                value="<?= getAddressValue(fname: 'telefono') ?>" required>
                        </div>
                        <!--Botón continuar para enviar el form-->
                        <div class="d-flex justify-content-center mt-4">
                            <button type="submit" class="btn btn-custom">Continuar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
    <?php require('footer.php'); ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>

    </script>
</body>

</html>