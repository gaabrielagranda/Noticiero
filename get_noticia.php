<?php
// Incluir el archivo "bd.php", que probablemente establece la conexión con la base de datos.
include('bd.php');
global $conn; // Hace global la conexión a la base de datos establecida en "bd.php".

// Verifica si se recibió un `categoria_id` en la solicitud POST.
if (isset($_POST['categoria_id'])) {
    $categoria_id = $_POST['categoria_id']; // Almacena el ID de categoría recibido.

    // Consulta SQL preparada para evitar inyección SQL.
    $sql = "SELECT * FROM noticias WHERE categoriaID = ?";
    $stmt = $conn->prepare($sql); // Prepara la consulta SQL.
    $stmt->bind_param("i", $categoria_id); // Vincula el parámetro de tipo entero ("i") a la consulta.
    $stmt->execute(); // Ejecuta la consulta preparada.
    $result = $stmt->get_result(); // Obtiene el resultado de la consulta.

    // Configura el encabezado HTTP para indicar que la respuesta será en formato JSON.
    header('Content-Type: application/json');

    // Comprueba si hay resultados en la consulta.
    if ($result->num_rows > 0) {
        $noticias = []; // Array para almacenar las noticias.
        while ($row = $result->fetch_assoc()) { // Recorre los resultados de la consulta.
            // Añade cada noticia al array en formato clave-valor.
            $noticias[] = [
                'titulo' => $row['titulo'],         // Título de la noticia.
                'contenido' => $row['contenido'],   // Contenido de la noticia.
                'categoriaID' => $row['categoriaID'], // ID de la categoría.
                'imagen' => $row['imagen']          // URL o path de la imagen asociada.
            ];
        }
        // Devuelve las noticias en formato JSON.
        echo json_encode($noticias);
    } else {
        // Si no hay resultados, devuelve un array vacío.
        echo json_encode([]);
    }
} else {
    // Si no se recibió un `categoria_id`, devuelve un mensaje de error en formato JSON.
    echo json_encode(["error" => "No se ha recibido el ID de categoría."]);
}

//Este código obtiene noticias desde la base de datos según un categoria_id recibido vía POST.
// Usa una consulta preparada para prevenir inyecciones SQL. Si encuentra noticias, las devuelve como un array en formato JSON; si no, devuelve un array vacío.
// Si no recibe el ID, envía un mensaje de error.
?>





