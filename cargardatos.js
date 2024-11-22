// Función para cargar categorías y noticias
function cargarDatos() {
    // Realiza una solicitud a "get_categoria.php" para obtener las categorías
    fetch('get_categoria.php')
        .then(response => response.json()) // Convierte la respuesta en JSON
        .then(categorias => {
            if (categorias) {
                // Obtiene el elemento select donde se mostrarán las categorías
                let categoriaSelect = document.getElementById('categoriaSelect');

                // Recorre las categorías recibidas y las agrega como opciones al select
                categorias.forEach(categoria => {
                    let option = document.createElement('option');
                    option.value = categoria.id; // ID de la categoría
                    option.text = categoria.tipo; // Nombre de la categoría
                    categoriaSelect.appendChild(option);
                });

                // Busca si existe una preferencia de categoría guardada en cookies
                let categoriaGuardada = getCookie('preferencia_categoria');
                if (categoriaGuardada) {
                    // Si existe, selecciona esa categoría y carga sus noticias
                    categoriaSelect.value = categoriaGuardada;
                    cargarNoticias(categoriaGuardada);
                } else {
                    // Si no hay preferencia guardada, carga la categoría predeterminada (0)
                    cargarNoticias(0);
                }
            }
        })
        .catch(error => console.error('Error al cargar categorías:', error)); // Manejo de errores

    // Agrega un evento para detectar cuando se cambia la categoría seleccionada
    document.getElementById('categoriaSelect').addEventListener('change', function () {
        let categoriaID = this.value; // Obtiene el ID de la categoría seleccionada
        setCookie('preferencia_categoria', categoriaID, 30); // Guarda la preferencia en cookies por 30 días
        cargarNoticias(categoriaID); // Carga las noticias de la categoría seleccionada
    });
}

// Función para cargar noticias de una categoría específica
function cargarNoticias(categoriaID) {
    // Realiza una solicitud a "get_datos.php" con el ID de la categoría seleccionada
    fetch(`get_datos.php?categoriaID=${categoriaID}`)
        .then(response => response.json()) // Convierte la respuesta en JSON
        .then(noticias => {
            let noticiasDiv = document.getElementById('noticias'); // Contenedor de las noticias
            noticiasDiv.innerHTML = ''; // Limpia las noticias anteriores

            if (noticias.length > 0) {
                // Recorre las noticias recibidas y las muestra en el DOM
                noticias.forEach(noticia => {
                    let noticiaDiv = document.createElement('div');
                    noticiaDiv.classList.add('noticia'); // Añade una clase para estilizar
                    noticiaDiv.innerHTML = `
                        <h3>${noticia.titulo}</h3> <!-- Título de la noticia -->
                        <p>${noticia.contenido}</p> <!-- Contenido de la noticia -->
                        <a href="noticia.php?id=${noticia.id}">Leer más</a> <!-- Enlace a la noticia completa -->
                    `;
                    noticiasDiv.appendChild(noticiaDiv);
                });
            } else {
                // Si no hay noticias, muestra un mensaje en el contenedor
                noticiasDiv.innerHTML = '<p>No se encontraron noticias.</p>';
            }
        })
        .catch(error => console.error('Error al cargar noticias:', error)); // Manejo de errores
}

// Función para obtener el valor de una cookie por su nombre
function getCookie(name) {
    let decodedCookie = decodeURIComponent(document.cookie); // Decodifica las cookies
    let ca = decodedCookie.split(';'); // Divide las cookies en un array
    for (let i = 0; i < ca.length; i++) {
        let c = ca[i].trim(); // Elimina espacios innecesarios
        if (c.indexOf(name + "=") === 0) {
            // Si encuentra la cookie con el nombre buscado, devuelve su valor
            return c.substring(name.length + 1);
        }
    }
    return null; // Devuelve null si no encuentra la cookie
}
// Función para establecer una cookie
function setCookie(name, value, days) {
    let d = new Date();
    d.setTime(d.getTime() + (days * 24 * 60 * 60 * 1000)); // Calcula la fecha de expiración
    let expires = "expires=" + d.toUTCString();
    // Crea la cookie con los parámetros indicados y configura seguridad básica
    document.cookie = `${name}=${value};${expires};path=/;Secure;SameSite=Lax`;
}
// Llamada inicial a la función para cargar las categorías y noticias
cargarDatos();

// Este código carga categorías desde un servidor, las muestra en menú y permite seleccionar una para cargar las noticias asociadas.
// Guarda la categoría preferida en cookies y la recuerda en visitas futuras.
