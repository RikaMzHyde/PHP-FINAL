<?php
require_once("connect.php");
include("functions/security.php");
include("user_class.php");


//Verificamos si hay un mensaje de éxito o eliminación con GET
$mensajeExito = isset($_GET["mensaje"]) && $_GET["mensaje"] === "exito";
$mensajeEliminado = isset($_GET["mensaje"]) && $_GET["mensaje"] === "eliminado";

//Verificamos si el DNI del usuario existe en la session
if (!isset($_SESSION["dni"]) || empty($_SESSION["dni"])) {
    echo "Error: No se encontró el DNI en la sesión.";
    exit();
} else {
    $dni = $_SESSION["dni"];

    //Nos aseguramos de que $dni sea una cadena válida
    if (is_string($dni) && $dni !== "") {
        //Obtenemos el usuario asociado al DNI
        $usuarioSesion = Usuario::obtenerUsuarioDNI($dni);

        //Verificamos si el usuario se ha obtenido correctamente y recogemos sus datos
        if ($usuarioSesion) {
            $nombre = $usuarioSesion->getNombre();
            $direccion = $usuarioSesion->getDireccion();
            $localidad = $usuarioSesion->getLocalidad();
            $provincia = $usuarioSesion->getProvincia();
            $telefono = $usuarioSesion->getTelefono();
            $email = $usuarioSesion->getEmail();
            $password = $usuarioSesion->getPassword();

            //Almacenamos los datos en la sesión
            $_SESSION['user_address'] = [
                'nombre' => $nombre,
                'direccion' => $direccion,
                'localidad' => $localidad,
                'provincia' => $provincia,
                'telefono' => $telefono,
                'email' => $email
            ];
        } else {
            echo "Error: No se pudo obtener el usuario con el DNI proporcionado.";
            exit();
        }
    }
}

//Solicitud para ordenar los resultados de la tabla
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['ordenar'])) {
    $_SESSION['ordenar'] = $_GET['ordenar'] === 'desc' ? "DESC" : "ASC";
    header("Location: " . strtok($_SERVER["REQUEST_URI"], '?'));
    exit;
}

// Determinar el orden actual
if (isset($_SESSION['ordenar']) && !empty($_SESSION['ordenar'])) {
    $orden = "ORDER BY nombre " . $_SESSION['ordenar'];
} else {
    $orden = "ORDER BY dni";
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="stylesheetcart.css">
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
    <?php require('navbar.php') ?>
    <main class="py-5">
        <div id="contenedor" style="display: inline-block; width: auto; max-width: none;">
            <h1 class="titulo">Mantenimiento de Clientes</h1>

            <!-- Mostrar los mensajes almacenados en la sesión -->
            <?php if (isset($_SESSION["mensaje"]) && !empty($_SESSION["mensaje"])): ?>
                <div style="text-align: center;"><?= $_SESSION["mensaje"] ?></div>
                <?php unset($_SESSION["mensaje"]); ?>
            <?php endif; ?>
            <!-- Tabla de clientes-->
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
                    //Conexión a la BD
                    $conn = conectar_db();

                    if (!$conn) {
                        die("Error al conectar a la base de datos");
                    }

                    try {
                        // Configuración de paginación
                        $por_pagina = 5; // Elementos por página
                        $pagina = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
                        $pagina = max(1, $pagina); // Asegurar que sea mínimo 1

                        // Calcular offset
                        $offset = ($pagina - 1) * $por_pagina;

                        // Obtener total de registros
                        $total_registros = $conn->query("SELECT COUNT(*) FROM usuarios")->fetchColumn();
                        $total_paginas = ceil($total_registros / $por_pagina);

                        // Redirección si la página excede el maximo
                        if ($pagina > $total_paginas && $total_paginas > 0) {
                            header("Location: ?pagina=" . $total_paginas);
                            exit;
                        }

                        // Consulta para ordenar y paginar
                        $sql = "SELECT * FROM usuarios $orden LIMIT :limit OFFSET :offset";
                        $stmt = $conn->prepare($sql);
                        $stmt->bindValue(':limit', $por_pagina, PDO::PARAM_INT);
                        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
                        $stmt->execute();
                        //Recorremos los resultados y mostramos en la tabla
                        while ($datos = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            echo "<tr>";
                            echo "<td>" . $datos["dni"] . "</td>";
                            echo "<td>" . $datos["nombre"] . "</td>";
                            echo "<td>" . $datos["direccion"] . "</td>";
                            echo "<td>" . $datos["localidad"] . "</td>";
                            echo "<td>" . $datos["provincia"] . "</td>";
                            echo "<td>" . $datos["telefono"] . "</td>";
                            echo "<td>" . $datos["email"] . "</td>";
                            echo "<td>•••••</td>";
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

                <!-- Paginación -->
                <nav aria-label="Page navigation" class="mt-4">
                    <ul class="pagination justify-content-center">
                        <?php if ($pagina > 1): ?>
                            <li class="page-item">
                                <a class="btn btn-custom me-2" href="?pagina=<?= $pagina - 1 ?>" aria-label="Anterior">
                                    <span aria-hidden="true">&laquo;</span>
                                </a>
                            </li>
                        <?php endif; ?>
                        <!-- Generación dinámica de enlaces a páginas -->
                        <?php for ($i = 1; $i <= $total_paginas; $i++): ?>
                            <li class="page-item <?= $i == $pagina ? 'active' : '' ?>">
                                <a class="btn btn-custom me-2" href="?pagina=<?= $i ?>"><?= $i ?></a>
                            </li>
                        <?php endfor; ?>

                        <?php if ($pagina < $total_paginas): ?>
                            <li class="page-item">
                                <a class="btn btn-custom ms-2" href="?pagina=<?= $pagina + 1 ?>" aria-label="Siguiente">
                                    <span aria-hidden="true">&raquo;</span>
                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </nav>

                <br>
                <!-- Controles de ordenación por nombre -->
                <div class="ordenar">
                    <form action="" method="get">
                        <!--Mantener página actual-->
                        <input type="hidden" name="pagina" value="<?= $pagina ?>">
                        <button type="submit" name="ordenar" value="asc" class="btn btn-primary">
                            Ordenar por Nombre Ascendente ▲
                        </button>
                        <button type="submit" name="ordenar" value="desc" class="btn btn-primary">
                            Ordenar por Nombre Descendente ▼
                        </button>
                    </form>
                </div>
                <br>
                <!-- Acciones del admin -->
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
    </main>
</body>
<div style="text-align:left">
    <?php require('footer.php'); ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</div>

</html>