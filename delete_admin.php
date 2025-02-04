<?php
require_once("connect.php");
include("functions/security.php");
include("user_class.php");
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="stylesheet.css">
    <title>Ejercicio PDO</title>

    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            background-color: orange;
        }

        tr {
            background-color: white;
        }

        th,
        td {
            padding: 10px;
            border: 1px solid #ddd;
        }

        .mensaje {
            color: green;
            font-weight: bold;
            margin-bottom: 15px;
        }

        .btn {
            font-size: 110%;
            width: 100%;
            height: 40px;
            border: none;
            margin-top: 10px;
        }

        .btn-eliminar {
            background-color: red;
            color: white;
        }

        .btn-cancelar {
            background-color: gray;
            color: white;
        }
    </style>
</head>

<body>

    <div class="vh-center">
        <div id="contenedor" style="display: inline-block; width: auto; max-width: none;">
            <h2 class="titulo">Confirmar Eliminación</h2>

            <?php
            //Verificamos si se ha proporcionado un DNI para saber qué usuario se va a eliminar
            if (isset($_GET["dni"])):
                $dni = $_GET["dni"];

                //Comprobar si el usuario intenta eliminarse a sí mismo
                if (isset($_SESSION["dni"]) && $_SESSION["dni"] == $dni):
                    //Si el DNI de la sesión es igual al DNI que se quiere eliminar, mostramos un mensaje de error
                    echo "<p style='color: red; text-align: center;'>¡No puedes eliminarte a ti mismo!</p>";
                else:
                    //Usamos la clase usuario para obtener los datos del usuario con ese DNI
                    $usuario = Usuario::obtenerUsuarioDNI($dni);
            ?>

                    <?php if ($usuario): ?>
                        <p style="color: white; text-align: center;">¿Estás seguro de que deseas eliminar al siguiente usuario?</p>


                        <div id="login">
                            <table class="tabla-detalles">
                                <tr>
                                    <th>DNI</th>
                                    <th>Nombre</th>
                                    <th>Dirección</th>
                                    <th>Localidad</th>
                                    <th>Provincia</th>
                                    <th>Teléfono</th>
                                    <th>Email</th>
                                    <th>Contraseña</th>
                                </tr>
                                <tr>
                                    <td><?= $usuario->getDni() ?></td>
                                    <td><?= $usuario->getNombre() ?></td>
                                    <td><?= $usuario->getDireccion() ?></td>
                                    <td><?= $usuario->getLocalidad() ?></td>
                                    <td><?= $usuario->getProvincia() ?></td>
                                    <td><?= $usuario->getTelefono() ?></td>
                                    <td><?= $usuario->getEmail() ?></td>
                                    <td><?= $usuario->getPassword() ?></td>
                                </tr>
                            </table>
                        </div>

                        <form action="delete_admin.php" method="post" style="text-align: center;">
                            <input type="hidden" name="dni" value="<?= $dni ?>">
                            <button type="submit" name="confirmar" class="btn btn-eliminar">Sí</button>
                            <button type="button" class="btn btn-cancelar" onclick="history.back()">No, Volver Atrás</button>
                        </form>

                    <?php else: ?>
                        <p style="color: white; text-align: center;">Error: El usuario no existe.</p>
                    <?php endif; ?>
                <?php endif; ?>

            <?php
            //Verificamos si el formulario se ha enviado confirmando la eliminación
            elseif (isset($_POST["confirmar"])):
                $dni = $_POST["dni"];

                //Verificamos si el usuario que está intentando eliminar es el mismo que el que está logeado
                if (isset($_SESSION["dni_usuario"]) && $_SESSION["dni_usuario"] == $dni) {
                    //Si el DNI de la sesión es igual al DNI a eliminar, mostramos un mensaje de error
                    $_SESSION["mensaje"] = "¡No puedes eliminarte a ti mismo!";
                } else {
                    //Llamamos al método de la clase usuario para eliminarlo
                    if (Usuario::eliminarUsuario($dni)) {
                        $_SESSION["mensaje"] = '<p style="color: red; font-weight: bold; margin-top: 10px;">El usuario ha sido eliminado</p>';
                    } else {
                        $_SESSION["mensaje"] = '<p style="color: red; font-weight: bold; margin-top: 10px;">Error al intentar eliminar el usuario</p>';
                    }
                }
                header("Location: admin_session.php");
            ?>
            <?php else: ?>
                <p style="color: red; text-align: center;">Error: Falta el DNI.</p>
            <?php endif; ?>
        </div>
    </div>
</body>

</html>