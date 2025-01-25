<?php
    //Comprobamos que "conectar_db" no ha sido definida antes (para evitar errores de redefinición)
    if (!function_exists('conectar_db')) {
        //Hacemos la function para conectar con la BD
        function conectar_db(){
            $host = "localhost";
            $nombrebd = "usuarios_db";
            $username = "root";
            $password = "";
            
            try {
                //Creamos nueva instancia de PDO para conectarnos y configuramos para que lance excepciones
                $conn = new PDO("mysql:host=$host;dbname=$nombrebd", $username, $password);
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                echo "Error de conexión: " . $e->getMessage();
            }
            return $conn;
        }
    }  
?>
