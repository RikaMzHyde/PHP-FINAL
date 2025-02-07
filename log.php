<?php
function writeLog($message, $file = "log.txt") {
    $date = date("Y-m-d H:i:s"); // Obtener fecha y hora actual
    $logMessage = "[$date] $message" . PHP_EOL; // Formato de log

    // Escribir en el archivo de log
    file_put_contents($file, $logMessage, FILE_APPEND | LOCK_EX);
}
?>