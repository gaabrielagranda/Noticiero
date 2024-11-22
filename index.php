<?php
global $conn;
include_once('bd.php'); // Incluye el archivo de conexión a la base de datos

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
$sql = "SELECT * FROM categorias";
$resultCategorias = $conn->query($sql); // Ejecuta la consulta para obtener categorías
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
    <meta charset="UTF-8"> <!-- Establece la codificación de caracteres en UTF-8 -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Asegura que el sitio sea responsivo en dispositivos móviles -->
    <title>Noticias</title> <!-- Título de la página -->
    <!-- Enlace a la hoja de estilos de Bootstrap para el diseño y la estructura -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Enlace a la librería de jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>

<!-- Barra de navegación con categorías -->
<nav class="navbar navbar-expand-lg navbar-dark bg-primary"> <!-- Barra de navegación con un fondo azul -->
    <a class="navbar-brand" href="#">Noticias</a> <!-- Logo o nombre del sitio -->
    <div class="collapse navbar-collapse" id="navbarNav"> <!-- Contenedor para los elementos de navegación que se despliegan en pantallas grandes -->
        <ul class="navbar-nav"> <!-- Lista de los enlaces de navegación -->
            <li class="nav-item">
                <a class="nav-link" href="index.php">Todas</a> <!-- Enlace a la página principal que muestra todas las noticias -->
            </li>
            <!-- Recorre las categorías obtenidas de la base de datos y las muestra como enlaces en el menú de navegación -->
            <?php foreach ($categorias as $categoria): ?>
                <li class="nav-item">
                    <a class="nav-link" href="index.php?categoriaID=<?= $categoria['id'] ?>" data-id="<?= $categoria['id'] ?>"><?= $categoria['tipo'] ?></a> <!-- Enlace a una categoría específica, pasando el ID como parámetro en la URL -->
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</nav>

<!-- Contenedor de noticias -->
<div class="container mt-5"> <!-- Contenedor con un margen superior -->
    <div class="row" id="noticias"> <!-- Contenedor para las noticias con un diseño en fila -->
        <!-- Si hay noticias en la base de datos, se muestran -->
        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <!-- Cada noticia se coloca en una columna -->
                <div class="col-md-4 mb-4"> <!-- Se usa col-md-4 para 3 columnas en pantallas grandes y mb-4 para margen inferior -->
                    <div class="card"> <!-- Contenedor de cada noticia con el estilo de Bootstrap de tarjeta -->
                        <img src="<?= $row['imagen'] ?>" class="card-img-top" alt="Imagen de la noticia"> <!-- Imagen de la noticia -->
                        <div class="card-body"> <!-- Contenido de la tarjeta -->
                            <h5 class="card-title"><?= $row['titulo'] ?></h5> <!-- Título de la noticia -->
                            <p class="card-text"><?= substr($row['contenido'], 0, 100) ?>...</p> <!-- Muestra los primeros 100 caracteres del contenido de la noticia -->
                            <a href="noticia.php?id=<?= $row['id'] ?>" class="btn btn-primary">Ver más</a> <!-- Enlace para ver la noticia completa -->
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>No se encontraron noticias.</p> <!-- Mensaje si no hay noticias en la base de datos -->
        <?php endif; ?>
    </div>
</div>

<script type="text/javascript" src="cargardatos.js"></script>
<script>
    // Espera a que el documento esté completamente cargado antes de ejecutar el código
    $(document).ready(function () {

        // Escucha el evento de clic en los botones con la clase 'btn-primary' dentro del contenedor '#noticias'
        $('#noticias').on('click', '.btn-primary', function () {
            // Extrae el ID de la noticia (noticiaID) de la URL del enlace
            var noticiaID = $(this).attr('href').split('=')[1]; // La URL tiene la forma 'noticia.php?id=valor', así que se obtiene el valor después del '='

            // Obtiene el valor de la cookie almacenada llamada 'cookie'
            var cookie = getCookie('cookie'); // Llama a la función getCookie para obtener el valor de la cookie

            // Envía los datos (cookie y noticiaID) al servidor usando AJAX
            $.ajax({
                url: 'guardar_cookie.php', // La URL del servidor donde se enviarán los datos
                type: 'POST', // Método de la solicitud
                data: { cookie: cookie, noticiaID: noticiaID }, // Datos que se enviarán al servidor
                success: function (response) {
                    // Si la solicitud es exitosa, se imprime la respuesta en la consola
                    console.log('Data logged:', response);
                },
                error: function (error) {
                    // Si hay un error en la solicitud, se imprime el error en la consola
                    console.error('Error logging data:', error);
                }
            });
        });

        // Función para obtener el valor de una cookie por su nombre
        function getCookie(name) {
            let decodedCookie = decodeURIComponent(document.cookie); // Decodifica las cookies para manejarlas correctamente
            let ca = decodedCookie.split(';'); // Divide todas las cookies en un arreglo
            for (let i = 0; i < ca.length; i++) { // Itera sobre las cookies
                let c = ca[i].trim(); // Elimina los espacios en blanco
                // Si la cookie comienza con el nombre que se busca, devuelve el valor de la cookie
                if (c.indexOf(name + "=") === 0) {
                    return c.substring(name.length + 1); // Retorna el valor de la cookie
                }
            }
            return null; // Si no encuentra la cookie, retorna null
        }
    });
</script>

</body>
</html>