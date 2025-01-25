<?php
// Creamos la clase Articulo con su construct, sus getters y sus setters
class Articulo
{
    private $codigo;
    private $nombre;
    private $descripcion;
    private $categoria;
    private $precio;
    private $imagen;

    public function __construct($codigo, $nombre, $descripcion, $categoria, $precio, $imagen)
    {
        $this->codigo = $codigo;
        $this->nombre = $nombre;
        $this->descripcion = $descripcion;
        $this->categoria = $categoria;
        $this->precio = $precio;
        $this->imagen = $imagen;
    }

    public function getCodigo()
    {
        return $this->codigo;
    }
    public function getNombre()
    {
        return $this->nombre;
    }
    public function getDescripcion()
    {
        return $this->descripcion;
    }
    public function getCategoria()
    {
        return $this->categoria;
    }
    public function getPrecio()
    {
        return $this->precio;
    }
    public function getImagen()
    {
        return $this->imagen;
    }


    public function setCodigo($codigo)
    {
        $this->codigo = $codigo;
    }
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;
    }
    public function setCategoria($categoria)
    {
        $this->categoria = $categoria;
    }
    public function setPrecio($precio)
    {
        $this->precio = $precio;
    }
    public function setImagen($imagen)
    {
        $this->imagen = $imagen;
    }


    //Function para generar un código de articulo al añadirlo nuevo
    function codigoArticulo()
    {
        //Generamos 3 letras aleatorias
        $letras = '';
        for ($i = 0; $i < 3; $i++) {
            $letras .= chr(rand(ord('A'), ord('Z'))); // Letras de 'A' a 'Z'
        }
        //Generamos 5 números aleatorios
        $numeros = str_pad(rand(0, 99999), 5, '0', STR_PAD_LEFT); // Número con 5 dígitos, rellenado con ceros a la izquierda

        //Combinamos las letras y los números
        $codigo = $letras . $numeros;

        return $codigo;
    }

    //Function para obtener el codigo del artículo
    public static function obtenerCodigoArticulo($codigo)
    {
        include("connect.php");
        $conn = conectar_db();

        if ($conn) {
            try {
                //Preparamos y ejecutamos la consulta para obtener el articulo por el codigo
                $stmt = $conn->prepare("SELECT * FROM articulos WHERE codigo = :codigo");
                $stmt->bindParam(':codigo', $codigo);
                $stmt->execute();

                if ($stmt->rowCount() > 0) {
                    $row = $stmt->fetch(PDO::FETCH_ASSOC);
                    return new Articulo(
                        $row['codigo'],
                        $row['nombre'],
                        $row['descripcion'],
                        $row['categoria'],
                        $row['precio'],
                        $row['imagen'],
                    );
                } else {
                    return null;
                }
            } catch (PDOException $e) {
                echo "Error al buscar cliente: " . $e->getMessage();
            } finally {
                $conn = null;
            }
        }
        return null;
    }

    //Function para modificar un artículo
    public static function modificarArticulo($codigo, $nombre, $descripcion, $categoria, $precio, $imagen)
{
    try {
        $conn = conectar_db();

        //Consulta para actualizar los datos del artículo
        $sql = "UPDATE articulos SET nombre = :nombre, descripcion = :descripcion, categoria = :categoria, precio = :precio, imagen = :imagen WHERE codigo = :codigo";
        $stmt = $conn->prepare($sql);

        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':descripcion', $descripcion);
        $stmt->bindParam(':categoria', $categoria);
        $stmt->bindParam(':precio', $precio);
        $stmt->bindParam(':imagen', $imagen);
        $stmt->bindParam(':codigo', $codigo);

        $stmt->execute();

        //Verificamos si la modificación fue exitosa
        $filasAfectadas = $stmt->rowCount();

        $conn = null;

        return $filasAfectadas;
    } catch (PDOException $e) {
        echo "Error al modificar el artículo: " . $e->getMessage();
        return false;
    }
}

    //Function para eliminar el articulo
    public static function eliminarArticulo($codigo)
    {
        include("connect.php");
        $conn = conectar_db();

        if ($conn) {
            try {
                //Elimina el artículo con el código proporcionado
                $stmt = $conn->prepare("DELETE FROM articulos WHERE codigo = :codigo");
                $stmt->bindParam(':codigo', $codigo);

                if ($stmt->execute()) {
                    return true;
                } else {
                    return false;
                }
            } catch (PDOException $e) {
                echo "Error al eliminar artículo: " . $e->getMessage();
                return false;
            } finally {
                $conn = null;
            }
        }
    }
}
