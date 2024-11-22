<?php
// Incluir la conexión a la base de datos
include('bd.php');
global $conn;
// Obtener el ID de la noticia desde la URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];
} else {
    die('No se ha proporcionado el ID de la noticia.');
}

// Consulta para obtener los datos completos de la noticia
$sql = "SELECT n.id, n.titulo, n.contenido, n.imagen, c.tipo AS categoria
        FROM noticias n
        JOIN categorias c ON n.categoriaID = c.id
        WHERE n.id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $id);
$stmt->execute();
$result = $stmt->get_result();

// Verifica si la noticia existe
if ($result->num_rows > 0) {
    $noticia = $result->fetch_assoc();
} else {
    die('No se encontró la noticia.');
}

$stmt->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $noticia['titulo']; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
    <h1><?php echo $noticia['titulo']; ?></h1>
    <p><strong>Categoría:</strong> <?php echo $noticia['categoria']; ?></p>
    <!-- Usamos la URL de la imagen desde la base de datos -->
    <img src="<?php echo $noticia['imagen']; ?>" class="img-fluid mb-4" alt="Imagen de la noticia">
    <p><?php echo $noticia['contenido']; ?></p>
    <a href="index.php" class="btn btn-secondary">Volver a la página principal</a>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
$conn->close();
?>
