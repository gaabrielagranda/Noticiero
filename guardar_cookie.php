<?php
global $conn; // Declara la variable global `$conn` para poder usarla dentro de la función.
include 'bd.php'; // Incluye el archivo de conexión a la base de datos.

// Verifica si la solicitud fue realizada mediante el método POST.
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtiene el valor de la cookie enviada en el POST, o asigna `null` si no existe.
    $cookie = isset($_POST['cookie']) ? $_POST['cookie'] : null;

    // Obtiene el ID de la noticia del POST, convirtiéndolo en un entero, o asigna 0 si no existe.
    $noticiaID = isset($_POST['noticiaID']) ? intval($_POST['noticiaID']) : 0;

    // Verifica que la cookie no esté vacía y que `noticiaID` sea mayor a 0.
    if ($cookie && $noticiaID > 0) {
        try {
            // Prepara una consulta SQL para insertar una interacción en la base de datos.
            // Si ya existe una entrada con la misma cookie y noticiaID, actualiza la fecha a la actual.
            $stmt = $conn->prepare("
                INSERT INTO datosnoticiero (cookie, noticiaID, fecha)
                VALUES (?, ?, NOW())
                ON DUPLICATE KEY UPDATE fecha = NOW()
            ");

            // Vincula los valores de la cookie y el ID de la noticia como parámetros.
            $stmt->bind_param("si", $cookie, $noticiaID);

            // Ejecuta la consulta.
            $stmt->execute();

            // Responde con un mensaje de éxito en formato JSON.
            echo json_encode(['success' => true, 'message' => 'Interaction saved successfully.']);
        } catch (Exception $e) {
            // Si ocurre un error, responde con un mensaje de error en formato JSON.
            echo json_encode(['success' => false, 'error' => $e->getMessage()]);
        }
    } else {
        // Si los datos proporcionados son inválidos, responde con un error.
        echo json_encode(['success' => false, 'error' => 'Invalid data provided.']);
    }
} else {
    // Si el método de solicitud no es POST, responde con un error.
    echo json_encode(['success' => false, 'error' => 'Invalid request method.']);
}

// Este código guarda o actualiza la interacción de un usuario con una noticia en una base de datos.
// La interacción se identifica por una cookie y el ID de la noticia.
// Si ya existe una entrada con esa combinación, solo actualiza la fecha.
// Responde en formato JSON con mensajes de éxito o error según los datos enviados y el resultado de la operación.
?>

