<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "noticiero";

// Crear una nueva conexión a la base de datos utilizando la clase mysqli
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar si ocurrió algún error al intentar conectarse
if ($conn->connect_error) {
    // Si hay un error, detener la ejecución y mostrar un mensaje con detalles
    die("Connection failed: " . $conn->connect_error);
}

// Si no hay errores, la conexión está establecida correctamente
?>

<!-- ¿Que hace este codigo?
El código establece una conexión a la base de datos MySQL usando las credenciales proporcionadas.
Si la conexión falla, detiene la ejecución y muestra un mensaje de error.-->

