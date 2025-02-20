<?php
require_once("connect.php");
include("functions/security.php");
include("article_class.php");

$articulosPorPagina = 3;
$pagina = 1;
$inicio = 0;
$sort = '';

//Si se recibe una solicitud y se selecciona un criterio de ordenamiento lo almacena y recarga la página para aplicar el orden
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['sort'])) {
    $_SESSION['sort'] = $_POST['sort'];
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Administración de Artículos</title>
    
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="stylesheetcart.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
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
            margin: 20px auto;
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
        #nuevoArticulo a,
        #gestionarCategorias a,
        #modificarArticulo a,
        #borrarArticulo a,
        .paginacion a,
        .ordenacion_nombre button,
        .buscar button {
            border: none;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            font-size: 16px;
            border-radius: 5px;
            background-color: #85b1c5;
            color: #4e4363;
            transition: background-color 0.3s;
        }

        #botonAtras a:hover,
        #logout a:hover,
        #nuevoArticulo a:hover,
        #gestionarCategorias a:hover,
        #modificarArticulo a:hover,
        #borrarArticulo a:hover,
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
            color: #4e4363;
            transition: background-color 0.3s;
        }

        /* Tabla */
        /*table {
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
        }*/

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
    
    <?php require('navbar.php'); ?>
    <div id="formularioad">
        <h1 class="titulo">Administración de Artículos</h1>

        <!-- Muestra los mensajes -->
        <?php
        if (isset($_GET['mensaje']) && $_GET['mensaje'] == 'eliminado') {
            echo '<div style="color: green; font-weight: bold; margin-bottom: 10px;">
            El artículo ha sido eliminado correctamente
          </div>';
        } elseif (isset($_GET['mensaje']) && $_GET['mensaje'] == 'error') {
            echo '<div style="color: red; font-weight: bold; margin-bottom: 10px;">
            Ha ocurrido un error al eliminar el artículo
          </div>';
        }
        ?>


        <section class="acciones">
            <div id="botonAtras">
                <?php
                //Verifica el rol del usuario y redirige a la página correspondiente
                if (isset($_SESSION['rol'])) {
                    if ($_SESSION['rol'] === 'ADMIN') {
                        //A la sesión de administrador
                        echo '<a href="admin_session.php">Volver a "Mi Cuenta"</a>';
                    } else if ($_SESSION['rol'] === 'EDITOR') {
                        //A la sesión de editor
                        echo '<a href="editor_session.php">Volver a "Mi Cuenta"</a>';
                    }
                }
                ?>
            </div>
            <div id="nuevoArticulo">
                <a href="new_article.php">Agregar Nuevo Artículo</a>
            </div>
            <div id="gestionarCategorias">
                <a href="manage_categories.php">Gestionar Categorías</a>
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
            <form action="editor_articles.php" method="get">
                <input type="text" name="busqueda" placeholder="Buscar por nombre" style="padding: 8px; font-size: 16px; border-radius: 5px;">
                <button type="submit" name="submit_busqueda">Buscar</button>
            </form>
        </div>
        <br>
        <br>
        <table class="table table-secondary  table-striped-columns">
            <thead>
                <tr>
                    <th>Código</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Categoría</th>
                    <th>Precio</th>
                    <th>Imagen</th>
                    <th class="editar">Modificar</th>
                    <th class="borrar">Borrar</th>
                </tr>
            </thead>
            <tbody class="align-middle">
                <?php
            $conn = conectar_db();

if (!$conn) {
    die("Error al conectar a la base de datos");
}
//Determina la página y el inicio para la paginación
if (isset($_GET["pagina"])) {
    $pagina = $_GET["pagina"];
    $inicio = ($pagina - 1) * $articulosPorPagina;
}

try {
    //Consulta para obtener el total de artículos
    $stmt = $conn->prepare("SELECT * FROM articulos");
    $stmt->execute();
    $totalArticulos = $stmt->rowCount();
    $totalPaginas = ceil($totalArticulos / $articulosPorPagina);
    //Consulta para obtener los artículos según la paginación
    $stmt = $conn->prepare("SELECT * FROM articulos LIMIT :inicio, :articulosPorPagina");
    //Determinar el orden actual
    if (isset($_SESSION['sort']) && !empty($_SESSION['sort'])) {
        $sort = $_SESSION['sort'];
        unset($_SESSION['sort']);
    }

    //Realizar la búsqueda si se recibe un parámetro de búsqueda
    $busqueda = isset($_GET['busqueda']) ? $_GET['busqueda'] : '';
    
    //Consulta con el orden y la busqueda según el criterio
    switch ($sort) {
        case 'nombre_asc':
            $consulta = "SELECT a.*, s.descripcion AS subcategoria 
                         FROM articulos a 
                         LEFT JOIN subcategoria s ON a.id_subcategoria = s.id 
                         WHERE a.nombre LIKE :busqueda 
                         ORDER BY a.nombre ASC 
                         LIMIT :inicio, :articulosPorPagina";
            break;
        case 'nombre_desc':
            $consulta = "SELECT a.*, s.descripcion AS subcategoria 
                         FROM articulos a 
                         LEFT JOIN subcategoria s ON a.id_subcategoria = s.id 
                         WHERE a.nombre LIKE :busqueda 
                         ORDER BY a.nombre DESC 
                         LIMIT :inicio, :articulosPorPagina";
            break;
        default:
            $consulta = "SELECT a.*, s.descripcion AS subcategoria 
                         FROM articulos a 
                         LEFT JOIN subcategoria s ON a.id_subcategoria = s.id 
                         WHERE a.nombre LIKE :busqueda 
                         LIMIT :inicio, :articulosPorPagina";
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
                    <td>" . $datos["subcategoria"] . "</td>
                    <td>" . $datos["precio"] . '€' . "</td>
                    <td><img src='" . $datos["imagen"] . "' alt='imagen'></td>
                    <td><a href='modify_article.php?codigo=" . $datos["codigo"] . "'>✏️</a></td>
                    <td><a href='delete_article.php?codigo=" . $datos["codigo"] . "'>✖️</a></td>
                </tr>";
    }
} catch (PDOException $e) {
    echo 'Error: ' . $e->getMessage();
}
?>
            </tbody>
        </table>

        <div class="paginacion">
            <?php
            for ($i = 1; $i <= $totalPaginas; $i++) {
                echo "<a href='editor_articles.php?pagina=" . $i . "'>$i</a>";
            }
            ?>
        </div>
    </div>
    <?php require('footer.php'); ?>
</body>

</html>