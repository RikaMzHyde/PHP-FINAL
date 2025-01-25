<?php
include("connect.php");
include("security.php");
include("user_class.php");
include("article_class.php");


$mensajeExito = isset($_GET['mensaje']) && $_GET['mensaje'] === 'exito';
$mensajeEliminado = isset($_GET['mensaje']) && $_GET['mensaje'] === 'eliminado';

$articulosPorPagina = 3;
$pagina = 1;
$inicio = 0;
$sort = '';

//Si recibe una solicitud POST con 'sort' se guarda la ordenación en la sesión
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['sort'])) {
    $_SESSION['sort'] = $_POST['sort'];
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

?>

<!DOCTYPE html>
<html>

<head>
    <title>Artículos Disponibles</title>
    
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            background-color: #9f8bc0;
            height: 100%;
            margin: 0;
        }

        .vh-center {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        #contenedor {
            max-width: 300px;
            width: 100%;
            padding: 10px;
            background-color: #4e4363;
            box-sizing: border-box;
            border-radius: 10px;
        }

        .titulo {
            color: rgb(80, 255, 203);
            margin-bottom: 40px;
            text-align: center;
        }

        /* Estilos generales */
        #formularioad {
            width: 90%;
            margin: auto;
            padding: 20px 10px;
            display: flex;
            box-sizing: border-box;
            text-align: center;
            border-radius: 5px;
            display: block;
            align-items: center;
            justify-content: center;
            background-color: #4e4363;
        }

        /* Estilos de los botones */
        #botonAtras a,
        #logout a,
        .paginacion a,
        .ordenacion_nombre button,
        .buscar button {
            border: none;
            color: black;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            font-size: 16px;
            border-radius: 5px;
            background-color: #85b1c5;
        }

        #botonAtras a:hover,
        #logout a:hover,
        .paginacion a:hover,
        .ordenacion_nombre button:hover,
        .buscar button:hover {
            background-color: rgb(80, 255, 203);
            cursor: pointer;
        }

        .paginacion {
            color: white;
            padding: 16px;
            background-color: #85b1c5;
            border-radius: 5px;
            margin-right: 0px;
        }

        .buscar button {
            width: 150px;
            background-color: #85b1c5;
            color: black;
        }

        /* Tabla */
        table {
            width: 100%;
            height: 100%;
            border-radius: 5px;
            font-size: 16px;
            background-color: #4e4363;
        }

        th,
        td {
            padding: 15px;
            text-align: center;
            border-radius: 5px;
            background-color: white;
        }

        th {
            background-color: #b3a9c7;
        }

        td img {
            width: 120px;
            height: 170px;
        }

        .acciones {
            display: flex;
            justify-content: space-around;
            width: 100%;
            margin-top: 40px;
            background-color: #85b1c5;
            height: 70px;
            align-items: center;
        }

        .alert {
            padding: 10px;
            border-radius: 5px;
            margin: 10px 0;
        }

        .alert-success {
            color: green;
        }

        .alert-danger {
            color: red;
        }
    </style>
</head>

<body>

    <?php if ($mensajeExito) : ?>
        <div class="alert alert-success">Se han modificado los datos de forma correcta</div>
    <?php endif; ?>
    <?php if ($mensajeEliminado) : ?>
        <div class="alert alert-danger">Se ha eliminado el usuario correctamente</div>
    <?php endif; ?>

    <div id="formularioad">
        <h1 class="titulo">Artículos Disponibles</h1>

        <section class="acciones">
            <div id="botonAtras">
                <a href="user_session.php">Volver a "Mi Cuenta"</a>
            </div>
            <div id="logout">
                <a href="logout.php">Cerrar Sesión</a>
            </div>
        </section>
        <br>
        <br>
        <div class="ordenacion_nombre">
            <form action="" method="post">
                <button type="submit" name="sort" value="nombre_asc">Ordenar por Nombre Ascendente ▲</button>
                <button type="submit" name="sort" value="nombre_desc">Ordenar por Nombre Descendente ▼</button>
            </form>
        </div>
        <br>
        <br>

        <div class="buscar">
            <form action="user_articles.php" method="get">
                <input type="text" name="busqueda" placeholder="Buscar por nombre" style="padding: 8px; font-size: 16px; border-radius: 5px;">
                <button type="submit" name="submit_busqueda">Buscar</button>
            </form>
        </div>
        <br>
        <br>
        <table>
            <tr>
                <th>Código</th>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Categoría</th>
                <th>Precio</th>
                <th>Imagen</th>
            </tr>

            <?php

            $conn = conectar_db();

            if (!$conn) {
                die("Error al conectar a la base de datos");
            }

            if (isset($_GET["pagina"])) {
                $pagina = $_GET["pagina"];
                $inicio = ($pagina - 1) * $articulosPorPagina;
            }
            //Obtenemos el total de artículos para calcular las páginas
            try {
                $stmt = $conn->prepare("SELECT * FROM articulos");
                $stmt->execute();
                $totalArticulos = $stmt->rowCount();
                $totalPaginas = ceil($totalArticulos / $articulosPorPagina);
                //Consulta para obtener los artículos con límite para paginación
                $stmt = $conn->prepare("SELECT * FROM articulos LIMIT :inicio, :articulosPorPagina");
                //Determinar el orden actual
                if (isset($_SESSION['sort']) && !empty($_SESSION['sort'])) {
                    $sort = $_SESSION['sort'];
                    unset($_SESSION['sort']);
                }
                //Filtrar la búsqueda
                $busqueda = isset($_GET['busqueda']) ? $_GET['busqueda'] : '';

                //Según el orden, generar la consulta
                switch ($sort) {
                    case 'nombre_asc':
                        $consulta = "SELECT * FROM articulos WHERE nombre LIKE :busqueda ORDER BY nombre ASC LIMIT :inicio, :articulosPorPagina";
                        break;
                    case 'nombre_desc':
                        $consulta = "SELECT * FROM articulos WHERE nombre LIKE :busqueda ORDER BY nombre DESC LIMIT :inicio, :articulosPorPagina";
                        break;
                    default:
                        $consulta = "SELECT * FROM articulos WHERE nombre LIKE :busqueda LIMIT :inicio, :articulosPorPagina";
                }

                $stmt = $conn->prepare($consulta);
                $stmt->bindValue(':busqueda', '%' . $busqueda . '%', PDO::PARAM_STR);
                $stmt->bindParam(':inicio', $inicio, PDO::PARAM_INT);
                $stmt->bindParam(':articulosPorPagina', $articulosPorPagina, PDO::PARAM_INT);
                $stmt->execute();

                while ($datos = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo "<tr>
                                <td>" . $datos["codigo"] . "</td>
                                <td>" . $datos["nombre"] . "</td>
                                <td>" . $datos["descripcion"] . "</td>
                                <td>" . $datos["categoria"] . "</td>
                                <td>" . $datos["precio"] . '€' . "</td>
                                <td><img src='" . $datos["imagen"] . "' alt='imagen'></td>
                            </tr>";
                }
            } catch (PDOException $e) {
                echo 'Error: ' . $e->getMessage();
            }
            ?>
        </table>

        <div class="paginacion">
            <?php
            for ($i = 1; $i <= $totalPaginas; $i++) {
                echo "<a href='user_articles.php?pagina=" . $i . "'>$i</a>";
            }
            ?>
        </div>
    </div>
</body>

</html>