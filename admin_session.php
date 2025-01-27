<?php
include("connect.php");
include("functions/security.php");
include("user_class.php");

//Verificamos si hay un mensaje de éxito o eliminación con GET
$mensajeExito = isset($_GET["mensaje"]) && $_GET["mensaje"] === "exito";
$mensajeEliminado = isset($_GET["mensaje"]) && $_GET["mensaje"] === "eliminado";

//Verificamos si el DNI del usuario existe en la session
if (!isset($_SESSION["dni"]) || empty($_SESSION["dni"])) {
    echo "Error: No se encontró el DNI en la sesión.";
    exit();
}

//Solicitud para ordenar los resultados de la tabla
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ordenar'])) {
    $_SESSION['ordenar'] = $_POST['ordenar'] === 'desc' ? "DESC" : ($_POST['ordenar'] === 'asc' ? "ASC" : "");
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

//Determinamos el orden actual (por defecto DNI)
if (isset($_SESSION['ordenar']) && !empty($_SESSION['ordenar'])) {
    $orden = "ORDER BY nombre " . $_SESSION['ordenar'];
    unset($_SESSION['ordenar']);
} else {
    $orden = "ORDER BY dni";
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="stylesheet.css">
    <title>Mantenimiento Clientes</title>

    <style>
        body {
            text-align: center;
        }

        table {
            width: 100%;
            height: 100%;
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

        .editar {
            background-color: lime;
        }

        .borrar {
            background-color: red;
        }

        .mensaje {
            color: green;
            font-weight: bold;
            margin-bottom: 15px;
        }

        .ordenar {
            display: flex;
            justify-content: center;
            gap: 10px;
        }
    </style>
</head>

<body>
    <div id="contenedor" style="display: inline-block; width: auto; max-width: none;">
        <h1 class="titulo">Mantenimiento de Clientes</h1>

        <!-- Mostrar los mensajes almacenados en la sesión -->
        <?php if (isset($_SESSION["mensaje"]) && !empty($_SESSION["mensaje"])): ?>
            <div style="text-align: center;"><?= $_SESSION["mensaje"] ?></div>
            <?php unset($_SESSION["mensaje"]); ?>
        <?php endif; ?>

        <div id="login">
            <table>
                <tr>
                    <th>DNI</th>
                    <th>Nombre</th>
                    <th>Dirección</th>
                    <th>Localidad</th>
                    <th>Provincia</th>
                    <th>Teléfono</th>
                    <th>Email</th>
                    <th>Password</th>
                    <th>Admin</th>
                    <th>Editor</th>
                    <th class="editar">Editar</th>
                    <th class="borrar">Borrar</th>
                </tr>

                <?php
                $conn = conectar_db();

                if (!$conn) {
                    die("Error al conectar a la base de datos");
                }

                try {
                    //Obtenemos los usuarios
                    $stmt = $conn->prepare("SELECT * FROM usuarios $orden");
                    $stmt->execute();
                    //Los recorremos y mostramos en la tabla
                    while ($datos = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        echo "<tr>";
                        echo "<td>" . $datos["dni"] . "</td>";
                        echo "<td>" . $datos["nombre"] . "</td>";
                        echo "<td>" . $datos["direccion"] . "</td>";
                        echo "<td>" . $datos["localidad"] . "</td>";
                        echo "<td>" . $datos["provincia"] . "</td>";
                        echo "<td>" . $datos["telefono"] . "</td>";
                        echo "<td>" . $datos["email"] . "</td>";
                        echo "<td>" . $datos["password"] . "</td>";
                        echo "<td>" . ($datos["admin"] == 1 ? "Sí" : "No") . "</td>";
                        echo "<td>" . ($datos["editor"] == 1 ? "Sí" : "No") . "</td>";
                        echo "<td><a href='modify_admin.php?dni=" . $datos["dni"] . "'>✏️</a></td>";

                        //Permitimos solo eliminar a otros usuarios que no sean el actual (evitar que el admin se elimine a sí mismo)
                        if (isset($_SESSION['dni']) && $_SESSION['dni'] != $datos['dni']) {
                            echo "<td><a href='delete_admin.php?dni=" . $datos['dni'] . "'>✖️</a></td>";
                        }
                        echo "</tr>";
                    }
                } catch (PDOException $e) {
                    echo 'Error: ' . $e->getMessage();
                }
                ?>
            </table>
            <br>
            <div class="ordenar">
                <form action="" method="post">
                    <button type="submit" name="ordenar" value="asc" >Ordenar por Nombre Ascendente ▲</button>
                </form>
                <form action="" method="post">
                    <button type="submit" name="ordenar" value="desc">Ordenar por Nombre Descendente ▼</button>
                </form>
            </div>
            <br>

            <form action="newuser_admin.php" method="get">
                <button type="submit">Nuevo Usuario</button>
            </form>

            <form action="search_user.php" method="get">
                <button type="submit">Buscar Usuario</button>
            </form>

            <form action="editor_articles.php" method="get">
                <button type="submit">Gestionar Artículos</button>
            </form>
        </div>

        <div id="logout" class="footer">
            <form action="logout.php" method="post">
                <button type="submit">Cerrar Sesión</button>
            </form>
        </div>
    </div>
</body>

</html>