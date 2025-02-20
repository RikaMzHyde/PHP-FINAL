<?php
require_once("connect.php");
include("functions/security.php");
include("article_class.php");

if (isset($_GET['codigo'])) {
    //Obtenemos el código del artículo a eliminar
    $codigo = $_GET['codigo'];

    $conn = conectar_db();

    //Obtenemos los datos del artículo con el código proporcionado
    $stmt = $conn->prepare("SELECT a.*, s.descripcion AS subcategoria FROM articulos a 
    LEFT JOIN subcategoria s ON a.id_subcategoria = s.id WHERE a.codigo = :codigo");
    $stmt->bindParam(':codigo', $codigo);
    $stmt->execute();

    //Si se encuentra el artículo, asignamos los valores a las variables
    if ($stmt->rowCount() > 0) {
        $articulo = $stmt->fetch(PDO::FETCH_ASSOC);
        $nombre = $articulo['nombre'];
        $descripcion = $articulo['descripcion'];
        $subcategoria = $articulo['subcategoria'];
        $precio = $articulo['precio'];
        $imagen = $articulo['imagen'];
    } else {
        header("Location: editor_articles.php?mensaje=error");
        exit;
    }
} else if (isset($_POST["confirmar"])) {
    //Obtenemos el codigo
    $codigo = $_POST['codigo'];

    //Y eliminamos el articulo
    if (Articulo::eliminarArticulo($codigo)) {
        //Destruimos la sesión y redirigimos al login
        header("Location: editor_articles.php?mensaje=eliminado");
        exit();
    } else {
        //Si nos encontramos con un error, volvemos a la página de eliminar
        header("Location: delete_article.php?mensaje=error");
        exit();
    }
} else {
    header("Location: editor_articles.php?mensaje=error");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="stylesheetcart.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
    <title>Confirmar Eliminación de Artículo</title>
    <style>
    /* Estilo para los botones con diferencias específicas */
    .btn-eliminar {
        background-color: #f44336;
        color: white;
    }

    .btn-cancelar {
        background-color: #878787;
        color: white;
    }

    /* Estilo específico para la tabla */
    table {
        width: 100%;
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
</style>

</head>

<body>
<?php require('navbar.php') ?>
<main class="py-5">
    <div class="vh-center">
        <div id="contenedor" style="display: inline-block; width: auto; max-width: none;">
            <h2 class="titulo">Confirmar Eliminación de Artículo</h2>

            <div class="formulario">
                <p style="color: white; text-align: center;">¿Estás seguro de que deseas eliminar el siguiente artículo?</p>

                <table>
                    <tr>
                        <th>Código</th>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Categoría</th>
                        <th>Precio</th>
                        <th>Imagen</th>
                    </tr>
                    <tr>
                        <td><?php echo $codigo; ?></td>
                        <td><?php echo $nombre; ?></td>
                        <td><?php echo $descripcion; ?></td>
                        <td><?php echo $subcategoria; ?></td>
                        <td><?php echo $precio; ?></td>
                        <td><img src="<?php echo $imagen; ?>" alt="Vista previa de la imagen"></td>
                    </tr>
                </table>

                <form action="delete_article.php" method="post" style="text-align: center;">
                    <input type="hidden" name="codigo" value="<?php echo $codigo; ?>">
                    <button type="submit" name="confirmar" class="btn-eliminar">Sí, Eliminar</button>
                    <button type="button" class="btn-cancelar" onclick="history.back()">No, Volver Atrás</button>
                </form>
            </div>

            <?php if (isset($_GET['mensaje']) && $_GET['mensaje'] == 'eliminado') : ?>
                <div style="color: green; font-weight: bold; margin-bottom: 10px;">
                    El artículo ha sido eliminado correctamente
                </div>
            <?php elseif (isset($_GET['mensaje']) && $_GET['mensaje'] == 'error') : ?>
                <div style="color: red; font-weight: bold; margin-bottom: 10px;">
                    Ha ocurrido un error al eliminar el artículo
                </div>
            <?php endif; ?>

        </div>
    </div>
</main>
<?php require('footer.php'); ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>