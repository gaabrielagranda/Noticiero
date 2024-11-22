<?php
include_once('bd.php'); // Incluye el archivo "bd.php", que probablemente establece la conexión a la base de datos.
global $conn; // Hace global la conexión a la base de datos establecida en "bd.php".
// Verifica si se recibió un parámetro 'categoriaID' en la URL; si no, lo asigna a 0 como valor predeterminado.
$categoriaID = isset($_GET['categoriaID']) ? (int)$_GET['categoriaID'] : 0;
// Configura el encabezado HTTP para indicar que la respuesta será en formato JSON.
header('Content-Type: application/json');
// Construye la consulta SQL. Si se especificó un 'categoriaID', filtra por esa categoría.
// Si no se especificó, selecciona un límite de 100 registros para evitar grandes conjuntos de datos.
if ($categoriaID > 0) {
    $sql = "SELECT id, titulo, contenido, imagen FROM noticias WHERE categoriaID = ?";
} else {
    $sql = "SELECT id, titulo, contenido, imagen FROM noticias LIMIT 100";
}
// Prepara la consulta SQL usando el método `prepare` para evitar inyecciones SQL.
$stmt = $conn->prepare($sql);
if (!$stmt) {
    // Si hay un error al preparar la consulta, devuelve un código de error HTTP 500 y un mensaje en formato JSON.
    http_response_code(500); // Error interno del servidor.
    echo json_encode(["error" => "Error preparing SQL statement"]);
    exit; // Termina la ejecución del script.
}
// Si se especificó un 'categoriaID', vincula el parámetro a la consulta preparada.
if ($categoriaID > 0) {
    $stmt->bind_param("i", $categoriaID); // "i" indica que el parámetro es un entero.
}
// Ejecuta la consulta preparada.
$stmt->execute();
$result = $stmt->get_result(); // Obtiene el conjunto de resultados de la consulta.
// Recorre los resultados y los guarda en un arreglo asociativo.
$noticias = [];
while ($row = $result->fetch_assoc()) {
    $noticias[] = $row;
}
// Si no se encontraron noticias, devuelve un mensaje en formato JSON.
if (empty($noticias)) {
    echo json_encode(["message" => "No se encontraron noticias."]);
} else {
    // Si hay resultados, los convierte en JSON y los envía como respuesta.
    echo json_encode($noticias);
}

//El código consulta una base de datos para obtener noticias. Si se recibe un categoriaID, filtra las noticias por esa categoría; de lo contrario, devuelve un máximo de 100 noticias. Los resultados se envían en formato JSON.
// Si ocurre un error o no se encuentran noticias, devuelve mensajes apropiados.
?>

