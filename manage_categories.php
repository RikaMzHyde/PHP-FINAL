<?php
require_once("connect.php");
session_start();
$conn = conectar_db();

$mensaje = "";
$error = "";

// Procesar acciones mediante POST
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action'])) {
    $action = $_POST['action'];
    if ($action == 'add_category') {
        $nombre = trim($_POST['nombre_categoria']);
        if (!empty($nombre)) {
            $stmt = $conn->prepare("INSERT INTO categoria (descripcion) VALUES (:descripcion)");
            $stmt->bindParam(':descripcion', $nombre, PDO::PARAM_STR);
            if ($stmt->execute()) {
                $mensaje = "Categoría agregada correctamente.";
            } else {
                $error = "Error al agregar la categoría.";
            }
        } else {
            $error = "El nombre de la categoría es requerido.";
        }
    } elseif ($action == 'edit_category') {
        $id = $_POST['id_categoria'];
        $nombre = trim($_POST['nombre_categoria']);
        if (!empty($nombre) && !empty($id)) {
            $stmt = $conn->prepare("UPDATE categoria SET descripcion = :descripcion WHERE id = :id");
            $stmt->bindParam(':descripcion', $nombre, PDO::PARAM_STR);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            if ($stmt->execute()) {
                $mensaje = "Categoría modificada correctamente.";
            } else {
                $error = "Error al modificar la categoría.";
            }
        } else {
            $error = "Todos los campos son requeridos para modificar.";
        }
    } elseif ($action == 'delete_category') {
        $id = $_POST['id_categoria'];
        if (!empty($id)) {
            // Primero verificamos si hay subcategorías
            $check_stmt = $conn->prepare("SELECT COUNT(*) FROM subcategoria WHERE id_categoria = :id");
            $check_stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $check_stmt->execute();
            $has_subcategories = $check_stmt->fetchColumn() > 0;

            if ($has_subcategories) {
                // Si hay subcategorías, enviamos un error
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'message' => 'No se puede eliminar la categoría porque tiene subcategorías asociadas']);
                exit;
            }

            // Si no hay subcategorías, procedemos con la eliminación
            $stmt = $conn->prepare("DELETE FROM categoria WHERE id = :id");
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            if ($stmt->execute()) {
                header('Content-Type: application/json');
                echo json_encode(['success' => true, 'message' => 'Categoría eliminada correctamente']);
                exit;
            } else {
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'message' => 'Error al eliminar la categoría']);
                exit;
            }
        }
    } elseif ($action == 'add_subcategory') {
        $nombre = trim($_POST['nombre_subcategoria']);
        $id_categoria = $_POST['id_categoria'];
        if (!empty($nombre) && !empty($id_categoria)) {
            $stmt = $conn->prepare("INSERT INTO subcategoria (id_categoria, descripcion) VALUES (:id_categoria, :descripcion)");
            $stmt->bindParam(':id_categoria', $id_categoria, PDO::PARAM_INT);
            $stmt->bindParam(':descripcion', $nombre, PDO::PARAM_STR);
            if ($stmt->execute()) {
                $mensaje = "Subcategoría agregada correctamente.";
            } else {
                $error = "Error al agregar la subcategoría.";
            }
        } else {
            $error = "Todos los campos son requeridos para agregar una subcategoría.";
        }
    } elseif ($action == 'edit_subcategory') {
        $id = $_POST['id_subcategoria'];
        $nombre = trim($_POST['nombre_subcategoria']);
        $id_categoria = $_POST['id_categoria'];
        if (!empty($nombre) && !empty($id) && !empty($id_categoria)) {
            $stmt = $conn->prepare("UPDATE subcategoria SET descripcion = :descripcion, id_categoria = :id_categoria WHERE id = :id");
            $stmt->bindParam(':descripcion', $nombre, PDO::PARAM_STR);
            $stmt->bindParam(':id_categoria', $id_categoria, PDO::PARAM_INT);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            if ($stmt->execute()) {
                $mensaje = "Subcategoría modificada correctamente.";
            } else {
                $error = "Error al modificar la subcategoría.";
            }
        } else {
            $error = "Todos los campos son requeridos para modificar la subcategoría.";
        }
    } elseif ($action == 'delete_subcategory') {
        $id = $_POST['id_subcategoria'];
        if (!empty($id)) {
            $stmt = $conn->prepare("DELETE FROM subcategoria WHERE id = :id");
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            if ($stmt->execute()) {
                $mensaje = "Subcategoría eliminada correctamente.";
            } else {
                $error = "Error al eliminar la subcategoría.";
            }
        }
    }
}

// Obtener las categorías actuales
$stmt = $conn->prepare("SELECT * FROM categoria ORDER BY ID ASC");
$stmt->execute();
$categorias = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Obtener las subcategorías (incluyendo el nombre de la categoría padre)
$stmt = $conn->prepare("SELECT s.*, c.descripcion AS categoria_nombre FROM subcategoria s JOIN categoria c ON s.id_categoria = c.id ORDER BY s.id ASC");
$stmt->execute();
$subcategorias = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Categorías y Subcategorías</title>
    <link rel="stylesheet" href="stylesheetcart.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <style>
        body { background-color: #f2f2f2; font-family: Arial, sans-serif; }
        .container { margin-top: 30px; }
        h2 { margin-top: 20px; }
        .mensaje { margin: 10px 0; font-weight: bold; }
    </style>
</head>
<body>
    <?php require('navbar.php'); ?>
    <div class="container">
        <h1>Gestión de Categorías y Subcategorías</h1>
        <?php if ($mensaje): ?>
            <div class="alert alert-success"><?php echo $mensaje; ?></div>
        <?php endif; ?>
        <?php if ($error): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <!-- Sección de Categorías -->
        <h2>Categorías</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Descripción</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($categorias as $cat): ?>
                <tr>
                    <td><?php echo $cat['id']; ?></td>
                    <td><?php echo htmlspecialchars($cat['descripcion']); ?></td>
                    <td>
                        <button type="button" class="btn btn-sm btn-primary" onclick="editarCategoria(<?php echo $cat['id']; ?>, '<?php echo addslashes($cat['descripcion']); ?>')">Editar</button>
                        <button type="button" class="btn btn-sm btn-danger" onclick="eliminarCategoria(<?php echo $cat['id']; ?>)">Eliminar</button>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <!-- Formulario para agregar nueva categoría -->
        <h3>Agregar Nueva Categoría</h3>
        <form method="post" class="mb-4">
            <input type="hidden" name="action" value="add_category">
            <div class="mb-3">
                <label for="nombre_categoria" class="form-label">Nombre de la Categoría:</label>
                <input type="text" class="form-control" name="nombre_categoria" id="nombre_categoria" required>
            </div>
            <button type="submit" class="btn btn-success">Agregar Categoría</button>
        </form>

        <!-- Sección de Subcategorías -->
        <h2>Subcategorías</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Descripción</th>
                    <th>Categoría Padre</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($subcategorias as $sub): ?>
                <tr>
                    <td><?php echo $sub['id']; ?></td>
                    <td><?php echo htmlspecialchars($sub['descripcion']); ?></td>
                    <td><?php echo htmlspecialchars($sub['categoria_nombre']); ?></td>
                    <td>
                        <button type="button" class="btn btn-sm btn-primary" onclick="editarSubcategoria(<?php echo $sub['id']; ?>, '<?php echo addslashes($sub['descripcion']); ?>', <?php echo $sub['id_categoria']; ?>)">Editar</button>
                        <form method="post" style="display:inline-block;" onsubmit="return confirm('¿Eliminar esta subcategoría?');">
                            <input type="hidden" name="id_subcategoria" value="<?php echo $sub['id']; ?>">
                            <input type="hidden" name="action" value="delete_subcategory">
                            <button type="submit" class="btn btn-sm btn-danger">Eliminar</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <!-- Formulario para agregar nueva subcategoría -->
        <h3>Agregar Nueva Subcategoría</h3>
        <form method="post" class="mb-4">
            <input type="hidden" name="action" value="add_subcategory">
            <div class="mb-3">
                <label for="nombre_subcategoria" class="form-label">Nombre de la Subcategoría:</label>
                <input type="text" class="form-control" name="nombre_subcategoria" id="nombre_subcategoria" required>
            </div>
            <div class="mb-3">
                <label for="id_categoria" class="form-label">Categoría Padre:</label>
                <select name="id_categoria" id="id_categoria" class="form-control" required>
                    <?php foreach ($categorias as $cat): ?>
                        <option value="<?php echo $cat['id']; ?>"><?php echo htmlspecialchars($cat['descripcion']); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button type="submit" class="btn btn-success">Agregar Subcategoría</button>
        </form>
    </div>

    <!-- Modal para editar categoría -->
    <div class="modal" tabindex="-1" id="modalCategoria">
      <div class="modal-dialog">
        <div class="modal-content">
          <form method="post" id="formEditarCategoria">
              <div class="modal-header">
                <h5 class="modal-title">Editar Categoría</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
              </div>
              <div class="modal-body">
                  <input type="hidden" name="id_categoria" id="edit_id_categoria">
                  <input type="hidden" name="action" value="edit_category">
                  <div class="mb-3">
                      <label for="edit_nombre_categoria" class="form-label">Nombre de la Categoría:</label>
                      <input type="text" class="form-control" name="nombre_categoria" id="edit_nombre_categoria" required>
                  </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-primary">Guardar cambios</button>
              </div>
          </form>
        </div>
      </div>
    </div>

    <!-- Modal para editar subcategoría -->
    <div class="modal" tabindex="-1" id="modalSubcategoria">
      <div class="modal-dialog">
        <div class="modal-content">
          <form method="post" id="formEditarSubcategoria">
              <div class="modal-header">
                <h5 class="modal-title">Editar Subcategoría</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
              </div>
              <div class="modal-body">
                  <input type="hidden" name="id_subcategoria" id="edit_id_subcategoria">
                  <input type="hidden" name="action" value="edit_subcategory">
                  <div class="mb-3">
                      <label for="edit_nombre_subcategoria" class="form-label">Nombre de la Subcategoría:</label>
                      <input type="text" class="form-control" name="nombre_subcategoria" id="edit_nombre_subcategoria" required>
                  </div>
                  <div class="mb-3">
                      <label for="edit_id_categoria" class="form-label">Categoría Padre:</label>
                      <select name="id_categoria" id="edit_id_categoria" class="form-control" required>
                          <?php foreach ($categorias as $cat): ?>
                              <option value="<?php echo $cat['id']; ?>"><?php echo htmlspecialchars($cat['descripcion']); ?></option>
                          <?php endforeach; ?>
                      </select>
                  </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-primary">Guardar cambios</button>
              </div>
          </form>
        </div>
      </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function editarCategoria(id, nombre) {
            document.getElementById('edit_id_categoria').value = id;
            document.getElementById('edit_nombre_categoria').value = nombre;
            var modal = new bootstrap.Modal(document.getElementById('modalCategoria'));
            modal.show();
        }
        function editarSubcategoria(id, nombre, id_categoria) {
            document.getElementById('edit_id_subcategoria').value = id;
            document.getElementById('edit_nombre_subcategoria').value = nombre;
            document.getElementById('edit_id_categoria').value = id_categoria;
            var modal = new bootstrap.Modal(document.getElementById('modalSubcategoria'));
            modal.show();
        }

        function eliminarCategoria(id) {
            if (confirm('¿Eliminar esta categoría?')) {
                const formData = new FormData();
                formData.append('action', 'delete_category');
                formData.append('id_categoria', id);

                fetch(window.location.href, {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    Toastify({
                        text: data.message,
                        duration: 3000,
                        gravity: "top",
                        position: "center",
                        style: {
                            background: data.success ? "linear-gradient(to right, #00b09b, #96c93d)" : "linear-gradient(to right, #ff5f6d, #ffc371)",
                        },
                    }).showToast();

                    if (data.success) {
                        // Recargar la página después de una eliminación exitosa
                        setTimeout(() => {
                            window.location.reload();
                        }, 1000);
                    }
                })
                .catch(error => {
                    Toastify({
                        text: "Error al procesar la solicitud",
                        duration: 3000,
                        gravity: "top",
                        position: "center",
                        style: {
                            background: "linear-gradient(to right, #ff5f6d, #ffc371)",
                        },
                    }).showToast();
                });
            }
        }
        
    </script>
</body>
</html>
