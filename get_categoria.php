<?php
// Incluye el archivo "bd.php", que probablemente contiene funciones y configuraciones para interactuar con la base de datos
include('bd.php');
// Llama a la función "muestraCategorias()" definida en "bd.php"
// Se espera que esta función obtenga las categorías desde la base de datos
$categorias = muestraCategorias();
// Envía la respuesta en formato JSON utilizando la función "sendJsonResponse"
// Esta función también podría estar definida en "bd.php"
// Convierte las categorías obtenidas en un formato JSON para que puedan ser consumidas por una aplicación cliente, como JavaScript en el navegador
sendJsonResponse($categorias);


//El código obtiene las categorías de una base de datos usando una función de bd.php y las envía como respuesta en formato JSON.
// Esto permite que un cliente (por ejemplo, el navegador) las utilice dinámicamente.
