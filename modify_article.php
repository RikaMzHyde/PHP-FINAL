<?php
require_once("connect.php");
include("functions/security.php");
include("article_class.php");

$conn = conectar_db();
$stmt = $conn->prepare("SELECT s.id, s.descripcion FROM subcategoria s ORDER BY s.descripcion");
$stmt->execute();
$subcategorias = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (isset($_GET["codigo"])) {
    $codigo = $_GET["codigo"];
    $articulo = Articulo::obtenerCodigoArticulo($codigo);

    if ($articulo) {
        //Obtenemos los valores del Articulo
        $codigo = $articulo->getCodigo();
        $nombre = $articulo->getNombre();
        $descripcion = $articulo->getDescripcion();
        $subcategoria = $articulo->getIdSubcategoria();
        $precio = $articulo->getPrecio();
        $imagenActual = $articulo->getImagen();
    } else {
        echo "Error: No se pudo obtener el artículo.";
        exit();
    }
} else {
    echo "Error: Falta el valor de artículo.";
    exit();
}

$mensajeError = "";
$mensajeExito = "";

//Verificamos si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //Obtenemos los datos del form
    $nombre = $_POST["nombre"];
    $descripcion = $_POST["descripcion"];
    $id_subcategoria = $_POST["id_subcategoria"];
    $precio = $_POST["precio"];
    $imagenActual = $_POST["imagen"];

    //Verificamos si se ha subido una nueva imagen
    if (!empty($_FILES["nuevaImagen"]["name"])) {
        $directorioImagenes = "productos/";
        $nombreImagen = basename($_FILES["nuevaImagen"]["name"]);
        $rutaNuevaImagen = $directorioImagenes . $codigo . generateRandomString(10) . ".png";
        $temp = $_FILES['nuevaImagen']['tmp_name'];
        $size = $_FILES['nuevaImagen']['size'];

        //Validamos que el archivo cumpla con los requisitos que necesitamos
        if ($size > 300000) {
            $mensajeError = "El archivo introducido es demasiado pesado.";
        } else {
            $extensionesValidas = ['jpg', 'jpeg', 'png', 'gif'];
            $extension = strtolower(pathinfo($nombreImagen, PATHINFO_EXTENSION));
            if (!in_array($extension, $extensionesValidas)) {
                $mensajeError = "La imagen debe ser de tipo jpeg, jpg, png o gif.";
            } elseif (!exif_imagetype($temp)) {
                $mensajeError = "El archivo no es una imagen válida.";
            } else {
                //Obtenemos las dimensiones de la imagen y verificamos que las dimensiones son válidas
                list($ancho, $alto) = getimagesize($temp);
                if ($ancho > 200 || $alto > 200) {
                    $mensajeError = "Las dimensiones de la imagen deben ser como máximo 200x200 píxeles.";
                } elseif (!move_uploaded_file($temp, $rutaNuevaImagen)) {
                    $mensajeError = "Error al guardar el archivo en el servidor.";
                } else {
                    //Elimina la imagen anterior si existe para evitar problemas
                    if ($imagenActual && file_exists($imagenActual)) {
                        unlink($imagenActual);
                    }
                    $imagen = $rutaNuevaImagen;
                    $imagenActual = $rutaNuevaImagen;
                }
            }
        }
    } else {
        $imagen = $imagenActual;
    }

    //Si no hay errores, se modifica el artículo
    if (empty($mensajeError)) {
        $conn = conectar_DB();
        $resultado = Articulo::modificarArticulo($codigo, $nombre, $descripcion, $id_subcategoria, $precio, $imagen);


        if ($resultado > 0) {
            $mensajeExito = "Artículo modificado correctamente.";
        } else if ($resultado == 0) {
            $mensajeExito = "No se realizaron cambios en el artículo.";
        } else {
            $mensajeError = "Error al modificar el artículo.";
        }
    }
}

//Function para generar un random string para asignar al nombre de la imagen
function generateRandomString($length = 10)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';

    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[random_int(0, $charactersLength - 1)];
    }

    return $randomString;
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Artículo</title>
    <link rel="stylesheet" href="stylesheetcart.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
    <script>
        //Validamos la imagen antes de subirla
        function validarArchivo(input) {
            const archivo = input.files[0];
            const extensionesValidas = ['jpeg', 'jpg', 'png', 'gif'];
            const mensaje = document.getElementById('mensaje');

            if (archivo) {
                const extension = archivo.name.split('.').pop().toLowerCase();
                //Verificamos que la extensión sea válida
                if (!extensionesValidas.includes(extension)) {
                    mensaje.style.display = 'block';
                    mensaje.style.color = 'red';
                    mensaje.textContent = "La imagen debe ser de tipo jpeg, jpg, png o gif.";
                    input.value = "";
                    return false;
                }

                const reader = new FileReader();
                reader.onload = function(e) {
                    const img = new Image();
                    img.src = e.target.result;
                    img.onload = function() {
                        //Verificamos que las dimensiones no excedan los 200 pixeles
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
    <?php require('navbar.php') ?>
    <main class="py-5" style="display: flex; justify-content: center; align-items: center; min-height: 100vh; margin: 0; flex-direction: column;">
        <div id="contenedor">
            <h1 class="titulo">Editar Artículo</h1>

            <div id="mensaje" style="font-weight: bold; text-align: center; margin-bottom: 10px; color: 
            <?php echo empty($mensajeError) ? 'green' : 'red'; ?>;">
                <?php echo !empty($mensajeError) ? $mensajeError : $mensajeExito; ?>
            </div>

            <div class="formulario">
                <form method="POST" action="modify_article.php?codigo=<?php echo $codigo; ?>" enctype="multipart/form-data">
                    <label for="codigo">Código:</label>
                    <input type="text" name="codigo" value="<?php echo $codigo; ?>" disabled>

                    <label for="nombre">Nombre:</label>
                    <input type="text" name="nombre" maxlength="40" value="<?php echo $nombre; ?>" required>

                    <label for="descripcion">Descripción:</label>
                    <textarea name="descripcion" maxlength="255" required rows="5" style="width: 100%; box-sizing: border-box; margin-bottom: 5px;"><?php echo $descripcion; ?></textarea>

                    <label for="subcategoria">Subcategoría:</label>
                    <select name="id_subcategoria" id="id_subcategoria" class="form-select"  style="margin-bottom: 5px;" required>
                        <?php foreach ($subcategorias as $sub): ?>
                            <option value="<?= $sub['id'] ?>" <?= (isset($subcategoria) && $subcategoria == $sub['id']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($sub['descripcion']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    
                    <label for="precio">Precio:</label>
                    <input type="number" name="precio" step="0.01" min="0" max="999999999999.99" value="<?php echo $precio; ?>" required>

                    <label for="imagen">Imagen Actual:</label>
                    <input type="text" name="imagen" value="<?php echo $imagenActual; ?>" readonly>

                    <label for="nuevaImagen">Nueva Imagen:</label>
                    <input type="file" name="nuevaImagen" accept="image/*" onchange="validarArchivo(this)">

                    <div class="vista-previa">
                        <img src="<?php echo $imagenActual; ?>" alt="Vista previa de la imagen" style="width: 120px; height: 170px; object-fit: cover; display: block; margin: 0 auto;">
                    </div>

                    <button type="submit">Confirmar</button>
                </form>

                <div class="footer">
                    <button type="button" onclick="window.location.href='editor_articles.php'">Volver a "Administración de Artículos"</button>
                </div>

            </div>
        </div>
    </main>
    <?php require('footer.php'); ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>