<?php
global $conn;
include_once('bd.php');

// Verifica si la cookie 'cookie' existe, de lo contrario, la crea
if (!isset($_COOKIE['cookie'])) {
    $cookie = bin2hex(random_bytes(16)); // Genera un valor aleatorio para la cookie
    setcookie('cookie', $cookie, time() + 3600 * 24 * 30, "/"); // Establece la cookie con una duración de 30 días
} else {
    $cookie = $_COOKIE['cookie']; // Si ya existe la cookie, la usa
}

// Obtiene el ID de la categoría seleccionado en la URL (si existe)
$categoriaID = isset($_GET['categoriaID']) ? (int)$_GET['categoriaID'] : 0;

// Consulta para obtener las noticias, filtradas por categoría si se seleccionó alguna
$sql = "SELECT n.id, n.titulo, n.contenido, n.imagen, c.tipo AS categoria
        FROM noticias n
        JOIN categorias c ON n.categoriaID = c.id";

// Si se ha seleccionado una categoría, se agrega a la consulta
if ($categoriaID > 0) {
    $sql .= " WHERE n.categoriaID = $categoriaID"; // Filtra por la categoría seleccionada
}

// Ordena las noticias por preferencia del usuario
$sql .= " ORDER BY (SELECT COUNT(*) FROM datosnoticiero d WHERE d.noticiaID = n.id AND d.cookie = '$cookie') DESC, n.id DESC LIMIT 100"; // Limita a las 100 noticias más recientes
$result = $conn->query($sql); // Ejecuta la consulta y obtiene el resultado

// Consulta para obtener todas las categorías disponibles
$sqlCategorias = "SELECT * FROM categorias";
$resultCategorias = $conn->query($sqlCategorias); // Ejecuta la consulta para obtener categorías
$categorias = []; // Array vacío para almacenar las categorías
if ($resultCategorias->num_rows > 0) { // Si hay categorías disponibles
    while ($row = $resultCategorias->fetch_assoc()) { // Recorre cada categoría
        $categorias[] = $row; // Añade cada categoría al array
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Noticias</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <a class="navbar-brand" href="#">Noticias</a>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="index.php">Todas</a>
            </li>
            <?php foreach ($categorias as $categoria): ?>
                <li class="nav-item">
                    <a class="nav-link" href="index.php?categoriaID=<?= $categoria['id'] ?>" data-id="<?= $categoria['id'] ?>"><?= $categoria['tipo'] ?></a>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</nav>

<div class="container mt-5">
    <div class="row" id="noticias">
        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <img src="<?= $row['imagen'] ?>" class="card-img-top" alt="Imagen de la noticia">
                        <div class="card-body">
                            <h5 class="card-title"><?= $row['titulo'] ?></h5>
                            <p class="card-text"><?= substr($row['contenido'], 0, 100) ?>...</p>
                            <a href="noticia.php?id=<?= $row['id'] ?>" class="btn btn-primary">Ver más</a>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>No se encontraron noticias.</p>
        <?php endif; ?>
    </div>
</div>

<script type="text/javascript" src="cargardatos.js"></script>
<script>
    $(document).ready(function () {
        $('#noticias').on('click', '.btn-primary', function () {
            var noticiaID = $(this).attr('href').split('=')[1];
            var cookie = getCookie('cookie');

            $.ajax({
                url: 'guardar_cookie.php',
                type: 'POST',
                data: { cookie: cookie, noticiaID: noticiaID },
                success: function (response) {
                    console.log('Data logged:', response);
                },
                error: function (error) {
                    console.error('Error logging data:', error);
                }
            });
        });

        function getCookie(name) {
            let decodedCookie = decodeURIComponent(document.cookie);
            let ca = decodedCookie.split(';');
            for (let i = 0; i < ca.length; i++) {
                let c = ca[i].trim();
                if (c.indexOf(name + "=") === 0) {
                    return c.substring(name.length + 1);
                }
            }
            return null;
        }
    });
</script>

</body>
</html>