<?php
require_once("connect.php");
include("functions/security.php");

include("article_class.php");

$mensajeError = "";
$mensajeExito = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['enviar'])) {

    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $categoria = $_POST['categoria'];
    $precio = $_POST['precio'];
    $nombre_archivo = $_FILES['imagen']['name'];
    $imagen = "productos/" . $nombre_archivo;
    $temp = $_FILES['imagen']['tmp_name'];
    $size = $_FILES['imagen']['size'];

    //Validamos el archivo
    if (!isset($_FILES['imagen']) || $size == 0) {
        $mensajeError = "No se ha podido cargar el archivo.";
    } elseif ($size > 300000) {
        $mensajeError = "El archivo introducido es demasiado pesado.";
    } else {
        $extensionesValidas = ['jpg', 'jpeg', 'png', 'gif'];
        $extension = strtolower(pathinfo($nombre_archivo, PATHINFO_EXTENSION));
        if (!in_array($extension, $extensionesValidas)) {
            $mensajeError = "La imagen que desea añadir no es válida, por favor, seleccione un archivo de imagen válido (jpeg, jpg, png, gif).";
        } elseif (!exif_imagetype($temp)) {
            $mensajeError = "El archivo no es una imagen válida.";
        } else {
            //Obtenemos las dimensiones de la imagen
            list($ancho, $alto) = getimagesize($temp);

            //Las validamos
            if ($ancho > 200 || $alto > 200) {
                $mensajeError = "Las dimensiones de la imagen deben ser como máximo 200x200 píxeles.";
            } elseif (!move_uploaded_file($temp, $imagen)) {
                $mensajeError = "Error al guardar el archivo en el servidor.";
            } else {
                //Si el archivo se ha subido correctamente..
                $conn = conectar_db();
                if ($conn) {
                    $articulo = new Articulo('aaa00000', $nombre, $descripcion, $categoria, $precio, $imagen);
                    $codigoArticulo = $articulo->codigoArticulo();
                    $articulo->setCodigo($codigoArticulo);

                    $stmt = $conn->prepare("INSERT INTO articulos(codigo, nombre, descripcion, categoria, precio, imagen) VALUES (:codigo, :nombre, :descripcion, :categoria, :precio, :imagen)");
                    $stmt->bindParam(':codigo', $codigoArticulo);
                    $stmt->bindParam(':nombre', $nombre);
                    $stmt->bindParam(':descripcion', $descripcion);
                    $stmt->bindParam(':categoria', $categoria);
                    $stmt->bindParam(':precio', $precio);
                    $stmt->bindParam(':imagen', $imagen);

                    if ($stmt->execute()) {
                        $mensajeExito = "Artículo añadido correctamente.";
                    } else {
                        $mensajeError = "Ocurrió un error al insertar el artículo en la base de datos.";
                    }
                } else {
                    $mensajeError = "Error en la conexión con la Base de Datos.";
                }
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Datos del Nuevo Artículo</title>
    <link rel="stylesheet" href="stylesheet.css">
    <script>
        //Función para validar la imagen
        function validarArchivo(input) {
            const archivo = input.files[0];
            const extensionesValidas = ['jpeg', 'jpg', 'png', 'gif'];
            const mensaje = document.getElementById('mensaje');

            if (archivo) {
                const extension = archivo.name.split('.').pop().toLowerCase();
                //Verifica que la extensión sea válida
                if (!extensionesValidas.includes(extension)) {
                    mensaje.style.display = 'block';
                    mensaje.style.color = 'red';
                    mensaje.textContent = "La imagen que desea añadir no es válida, por favor, seleccione un archivo de imagen válido (jpeg, jpg, png, gif).";
                    input.value = "";
                    return false;
                }

                const reader = new FileReader();
                reader.onload = function(e) {
                    const img = new Image();
                    img.src = e.target.result;
                    //Verifica las dimensiones de la imagen
                    img.onload = function() {
                        if (img.width > 200 || img.height > 200) {
                            mensaje.style.display = 'block';
                            mensaje.style.color = 'red';
                            mensaje.textContent = "Las dimensiones de la imagen deben ser como máximo 200x200 píxeles.";
                            input.value = "";
                            return false;
                        }
                        mensaje.style.display = 'none';
                        mensaje.textContent = "";
                    };
                };
                reader.readAsDataURL(archivo);
            }
        }
    </script>
</head>

<body>
    <div id="contenedor">
        <h1 class="titulo">Datos del Nuevo Artículo</h1>

        <div id="mensaje" style="font-weight: bold; text-align: center; margin-bottom: 10px; color: 
            <?php echo empty($mensajeError) ? 'green' : 'red'; ?>;">
            <?php echo !empty($mensajeError) ? $mensajeError : $mensajeExito; ?>
        </div>

        <form name="formarticulos" method="post" action="new_article.php" enctype="multipart/form-data">
            <input name="nombre" type="text" id="tipo" maxlength="100" placeholder="Nombre" required>
            <textarea name="descripcion" type="textarea" id="descripcion" maxlength="500" placeholder="Descripción" required rows="5" style="width: 100%; box-sizing: border-box; margin-bottom: 5px;"></textarea>
            <input name="categoria" type="text" id="categoria" maxlength="40" placeholder="Categoría" required>
            <input name="precio" type="number" id="precio" step="0.01" min="0" max="999999999999.99" placeholder="Precio €" required>
            <input
                name="imagen"
                id="imagen"
                type="file"
                accept=".jpeg, .jpg, .png, .gif"
                required
                onchange="validarArchivo(this)">

            <button type="submit" name="enviar">Añadir</button>
            <div class="footer">
                <button class="btn" onclick="window.location.href='editor_articles.php'">Volver a "Administración de Artículos"</button>
            </div>
        </form>
    </div>
</body>

</html>