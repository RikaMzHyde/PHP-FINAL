<?php
// Creamos la clase Usuario con su construct, sus getters y sus setters
class Usuario
{
    private $dni;
    private $nombre;
    private $direccion;
    private $localidad;
    private $provincia;
    private $telefono;
    private $email;
    private $password;
    private $admin;
    private $editor;

    public function __construct($dni, $nombre, $direccion, $localidad, $provincia, $telefono, $email, $password, $admin, $editor)
    {
        $this->dni = $dni;
        $this->nombre = $nombre;
        $this->direccion = $direccion;
        $this->localidad = $localidad;
        $this->provincia = $provincia;
        $this->telefono = $telefono;
        $this->email = $email;
        $this->password = $password;
        $this->admin = $admin;
        $this->editor = $editor;
    }

    public function getDni()
    {
        return $this->dni;
    }
    public function getNombre()
    {
        return $this->nombre;
    }
    public function getDireccion()
    {
        return $this->direccion;
    }
    public function getLocalidad()
    {
        return $this->localidad;
    }
    public function getProvincia()
    {
        return $this->provincia;
    }
    public function getTelefono()
    {
        return $this->telefono;
    }
    public function getEmail()
    {
        return $this->email;
    }
    public function getPassword()
    {
        return $this->password;
    }
    public function getAdmin()
    {
        return $this->admin;
    }
    public function getEditor()
    {
        return $this->editor;
    }

    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }
    public function setDireccion($direccion)
    {
        $this->direccion = $direccion;
    }
    public function setLocalidad($localidad)
    {
        $this->localidad = $localidad;
    }
    public function setProvincia($provincia)
    {
        $this->provincia = $provincia;
    }
    public function setTelefono($telefono)
    {
        $this->telefono = $telefono;
    }
    public function setEmail($email)
    {
        $this->email = $email;
    }
    public function setPassword($password)
    {
        $this->password = $password;
    }
    public function setAdmin($admin)
    {
        $this->admin = $admin;
    }
    public function setEditor($editor)
    {
        $this->editor = $editor;
    }
    

    //Function para sacar todos los datos del usuario a partir del DNI 
    public static function obtenerUsuarioDNI($dni)
    {
        include("connect.php");
        $conn = conectar_db();

        if ($conn) {
            try {
                $stmt = $conn->prepare("SELECT * FROM usuarios WHERE dni = :dni");
                $stmt->bindParam(":dni", $dni);
                $stmt->execute();
                //Si lo encuentra, devuelve sus datos
                if ($stmt->rowCount() > 0) {
                    $row = $stmt->fetch(PDO::FETCH_ASSOC);
                    return new Usuario(
                        $row["dni"],
                        $row["nombre"],
                        $row["direccion"],
                        $row["localidad"],
                        $row["provincia"],
                        $row["telefono"],
                        $row["email"],
                        $row["password"],
                        $row["admin"],
                        $row["editor"],

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


    //Function para login
    public static function login($dni, $password)
    {
        include("connect.php");
        $conn = conectar_db();
        if ($conn) {
            try {
                //Consulta para sacar los datos del usuario
                $stmt = $conn->prepare("SELECT * FROM usuarios WHERE dni = :dni");
                $stmt->bindParam(":dni", $dni);

                $stmt->execute();
                
                $row = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($row) {
                    if (password_verify($password, $row['password'])) {
                        return new Usuario(
                            $row["dni"],
                            $row["nombre"],
                            $row["direccion"],
                            $row["localidad"],
                            $row["provincia"],
                            $row["telefono"],
                            $row["email"],
                            $row["password"],
                            $row["admin"],
                            $row["editor"],
                        );
                    }
                }
                
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
            } finally {
                $conn = null;
            }
        }
        return null;
    }

    //Function para registrar nuevos usuarios
    public static function registrarUsuario($dni, $nombre, $direccion, $localidad, $provincia, $telefono, $email, $password, $admin, $editor)
    {
        include("connect.php");
        $conn = conectar_db();
        $hashNuevoPwd = password_hash($password, PASSWORD_DEFAULT);

        if ($conn) {
            try {
                //Comprobamos si el usuario o el DNI ya existen en nuestra BD.
                if (self::existeUsuario($dni)) {
                    $_SESSION["mensajeError"] = "El usuario con ese DNI ya se encuentra registrado.";
                    return false;
                }
                //Insertamos el nuevo usuario
                $stmt = $conn->prepare("INSERT INTO usuarios (dni, nombre, direccion, localidad, provincia, telefono, email, password, admin, editor) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

                $stmt->bindParam(1, $dni, PDO::PARAM_STR);
                $stmt->bindParam(2, $nombre, PDO::PARAM_STR);
                $stmt->bindParam(3, $direccion, PDO::PARAM_STR);
                $stmt->bindParam(4, $localidad, PDO::PARAM_STR);
                $stmt->bindParam(5, $provincia, PDO::PARAM_STR);
                $stmt->bindParam(6, $telefono, PDO::PARAM_STR);
                $stmt->bindParam(7, $email, PDO::PARAM_STR);
                $stmt->bindParam(8, $hashNuevoPwd, PDO::PARAM_STR);
                $stmt->bindParam(9, $admin, PDO::PARAM_STR);
                $stmt->bindParam(10, $editor, PDO::PARAM_STR);

                if ($stmt->execute()) {
                    echo "Inserción de datos correcta";
                    return true;
                } else {
                    echo "Error al ejecutar la inserción. <br><br>";
                }
            } catch (PDOException $e) {
                echo "Error al preparar o ejecutar la consulta: " . $e->getMessage() . "<br><br>";
            } finally {
                $conn = null;
            }
        }

        return false;
    }


    //Function para saber si ya existe el usuario en la BD
    private static function existeUsuario($dni)
    {
        include("connect.php");
        $conn = conectar_db();

        if ($conn) {
            try {
                //Consulta para contar el numero de filas donde el usuario coincide
                $stmt = $conn->prepare("SELECT COUNT(*) FROM usuarios WHERE dni = :dni");
                $stmt->bindParam(":dni", $dni);
                $stmt->execute();

                //Si la cuenta es mayor que 0, el usuario ya existe
                return ($stmt->fetchColumn() > 0);
            } catch (PDOException $e) {
                echo "Error al verificar la existencia del usuario: " . $e->getMessage() . "<br><br>";
            } finally {
                $conn = null;
            }
        }

        return false;
    }

    //Function para eliminar usuario por DNI
    public static function eliminarUsuario($dni)
    {
        include("connect.php");
        $conn = conectar_db();

        if ($conn) {
            try {
                $stmt = $conn->prepare("DELETE FROM usuarios WHERE dni = :dni");
                $stmt->bindParam(":dni", $dni);

                if ($stmt->execute()) {
                    return true;
                } else {
                    return false;
                }
            } catch (PDOException $e) {
                echo "Error al eliminar usuario: " . $e->getMessage();
                return false;
            } finally {
                $conn = null;
            }
        }
        return false;
    }

    //Function para modificar usuario
    public static function modificarUsuario($dni, $nombre, $direccion, $localidad, $provincia, $telefono, $email, $password, $admin, $editor)
    {
        include("connect.php");
        $conn = conectar_db();
        if($password != null)
            $hashNuevoPwd = password_hash($password, PASSWORD_DEFAULT);

        if ($conn) {
            try {
                $query = "UPDATE usuarios SET nombre = :nombre, direccion = :direccion, localidad = :localidad, provincia = :provincia, telefono = :telefono, email = :email";
                if($password != null)
                    $query .= " , password = :password";
                if($admin != null && $editor != null)
                    $query .= " , admin = :admin, editor = :editor";
                $query .= " WHERE dni = :dni";
                //Consulta para actualizar los datos del usuarios en la BD
                $stmt = $conn->prepare($query);
                $stmt->bindParam(":dni", $dni);
                $stmt->bindParam(":nombre", $nombre);
                $stmt->bindParam(":direccion", $direccion);
                $stmt->bindParam(":localidad", $localidad);
                $stmt->bindParam(":provincia", $provincia);
                $stmt->bindParam(":telefono", $telefono);
                $stmt->bindParam(":email", $email);
                if($password != null)
                    $stmt->bindParam(":password", $hashNuevoPwd);
                if($admin != null && $editor != null) {
                    $stmt->bindParam(":admin", $admin);
                    $stmt->bindParam(":editor", $editor);
                }

                return $stmt->execute();
            } catch (PDOException $e) {
                echo "Error al modificar usuario: " . $e->getMessage();
                return false;
            } finally {
                $conn = null;
            }
        }
    }

    //Function para modificar la contraseña
    public function modificarPassword($nuevoPwd) {
        $hashNuevoPwd = password_hash($nuevoPwd, PASSWORD_DEFAULT);

        include("connect.php");

        $conn = conectar_db();

        if ($conn) {
            try {
                $stmt = $conn->prepare("UPDATE usuarios SET password = :password WHERE dni = :dni");
                $stmt->bindParam(':password', $hashNuevoPwd);
                $stmt->bindParam(':dni', $this->dni);
                $stmt->execute();
            } catch (PDOException $e) {
                echo "Error al actualizar la contraseña: " . $e->getMessage();
            } finally {
                $conn = null;
            }
        }
    }
    
}
