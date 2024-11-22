-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 21-11-2024 a las 22:58:46
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `noticiero`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `id` int(11) NOT NULL,
  `tipo` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`id`, `tipo`) VALUES
(1, 'Tecnología'),
(2, 'Deportes'),
(3, 'Política');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `datosnoticiero`
--

CREATE TABLE `datosnoticiero` (
  `cookie` varchar(255) NOT NULL,
  `noticiaID` int(11) NOT NULL,
  `fecha` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `datosnoticiero`
--

INSERT INTO `datosnoticiero` (`cookie`, `noticiaID`, `fecha`) VALUES
('aec2e8ab9356f0c4f109a174bc2fbccf', 12, '2024-11-21 20:32:46'),
('aec2e8ab9356f0c4f109a174bc2fbccf', 14, '2024-11-21 20:48:26'),
('aec2e8ab9356f0c4f109a174bc2fbccf', 17, '2024-11-21 20:49:33'),
('ce4512154b1be1901df3523ee55c9f03', 8, '2024-11-21 22:05:50'),
('ce4512154b1be1901df3523ee55c9f03', 10, '2024-11-21 20:36:44'),
('ce4512154b1be1901df3523ee55c9f03', 11, '2024-11-21 22:28:25'),
('ce4512154b1be1901df3523ee55c9f03', 17, '2024-11-21 20:29:43');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `noticias`
--

CREATE TABLE `noticias` (
  `id` int(11) NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `contenido` text NOT NULL,
  `categoriaID` int(11) NOT NULL,
  `imagen` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `noticias`
--

INSERT INTO `noticias` (`id`, `titulo`, `contenido`, `categoriaID`, `imagen`) VALUES
(1, 'La Inteligencia Artificial revoluciona la industria tecnológica', 'Empresas globales están integrando la inteligencia artificial para automatizar procesos, lo que genera un aumento en la productividad y reduce costos significativamente.', 1, 'https://img2.rtve.es/i/?w=1600&i=1650539398690.jpg'),
(2, 'El Internet 6G promete velocidades sin precedentes', 'Los primeros desarrollos de la tecnología 6G muestran un potencial 100 veces más rápido que el 5G, transformando sectores como el entretenimiento y la telemedicina.', 1, 'https://cdn.businessinsider.es/sites/navi.axelspringer.es/public/media/image/2023/03/grafico-muestra-logo-6g-2973136.jpg?tf=1200x900'),
(3, 'El Futuro de la Inteligencia Artificial', 'La inteligencia artificial continúa evolucionando a un ritmo acelerado, transformando industrias y creando nuevas oportunidades para las empresas.', 1, 'https://www.seguritecnia.es/wp-content/uploads/2022/03/inteligencia-artificial-900x600.jpg'),
(4, 'La Evolución del 5G: Impacto en las Comunicaciones', 'El 5G no solo mejora la velocidad de internet, sino que también abre nuevas posibilidades para la conectividad, como la automatización industrial.', 1, 'https://content.nationalgeographic.com.es/medio/2019/06/25/conectividad-total_4fc78a23_1280x913.jpg'),
(5, 'Cómo la Realidad Aumentada Está Transformando el Entretenimiento', 'La realidad aumentada está revolucionando la manera en que experimentamos los videojuegos, creando entornos más interactivos y realistas.', 1, 'https://metaverso.pro/wp-content/uploads/2024/01/futuro-de-la-realidad-virtual-2.jpg'),
(6, 'El Impacto del COVID-19 en los Juegos Olímpicos', 'La pandemia del COVID-19 ha tenido un profundo impacto en los eventos deportivos internacionales, cambiando la logística de los Juegos Olímpicos.', 2, 'https://fotografias.larazon.es/clipping/cmsimages01/2024/07/17/AA316E3D-269D-4C2E-846F-10358055860A/diferencia-juegos-olimpicos-olimpiadas-que-pocos-conocen_98.jpg?crop=1280,720,x0,y0&width=1900&height=1069&optimize=low&format=webply'),
(7, '¿Por qué el Futbol Americano es Cada Vez Más Popular?', 'Con un aumento de seguidores y el crecimiento de la NFL, el fútbol americano se está consolidando como uno de los deportes más populares.', 2, 'https://library.sportingnews.com/styles/crop_style_16_9_desktop/s3/2022-10/Patrick%20Mahomes%20100322.jpg?itok=YSKl3QAz'),
(8, 'Los Últimos Avances en Tecnología para Mejora del Rendimiento Atlético', 'Las nuevas tecnologías están cambiando la forma en que los atletas entrenan y compiten, desde la biomecánica hasta el uso de IA en el análisis de rendimiento.', 2, 'https://universidadeuropea.com/resources/media/images/rendimiento_deportivo_og.original.jpg'),
(9, 'El Futuro de la Democracia en Tiempos de Crisis', 'La democracia enfrenta desafíos globales, desde la desinformación hasta la polarización política, afectando el proceso electoral.', 3, 'https://lectambulos.com/wp-content/uploads/2022/05/Afondo1E_N54.jpg'),
(10, 'El Cambio Climático y la Política Global', 'El cambio climático es uno de los mayores desafíos del siglo XXI y tiene un impacto directo en la política internacional y las relaciones entre países.', 3, 'https://dobetter.esade.edu/sites/default/files/post/2020-02/politics-performance.jpg'),
(11, 'Las Elecciones de 2024: Un Panorama de la Política Mundial', 'Las elecciones de 2024 serán un momento crucial para determinar el futuro político, económico y social de muchos países.', 3, 'https://image.ondacero.es/clipping/cmsimages01/2024/05/09/16B3E28F-DC0D-47AC-B01C-1CEBDB9E0132/elecciones-europeas_98.jpg?crop=1280,720,x0,y0&width=1900&height=1069&optimize=medium&format=webply'),
(12, 'Lanzamiento de nuevo chip cuántico', 'La empresa ABC Corp ha anunciado el lanzamiento de su nuevo chip cuántico, que promete revolucionar la computación y permitir desarrollos más rápidos en IA y criptografía.', 1, 'https://i.blogs.es/6c0013/chipchino-ap/500_333.jpeg'),
(13, 'Victoria histórica en el campeonato mundial de fútbol', 'El equipo nacional de fútbol ha logrado su primera victoria en el campeonato mundial, marcando un hito en la historia deportiva del país.', 2, 'https://business-sports.es/wp-content/uploads/2023/10/Organizar-un-torneo-de-futbol.jpg'),
(14, 'La temporada de NBA comienza con grandes sorpresas', 'La nueva temporada de la NBA ha comenzado con resultados inesperados, sorprendiendo a los fanáticos con victorias inesperadas y actuaciones destacadas de jugadores jóvenes.', 2, 'https://ng-sportingnews.com/s3/files/styles/crop_style_16_9_desktop/s3/2024-11/nba-plain--4ae7b2ae-4d82-429d-b6f9-8de0e3af3858.png?h=920929c4&itok=H6fpDXpz'),
(15, 'Acuerdo internacional sobre el cambio climático', 'Líderes mundiales han firmado un nuevo acuerdo para combatir el cambio climático, comprometiéndose a reducir las emisiones de carbono en un 40% para 2030.', 3, 'https://www.federacionanarquista.net/wp-content/uploads/2023/02/cambio-4-1.jpg'),
(16, 'Reformas en el sistema de salud pública', 'El gobierno ha anunciado un paquete de reformas para mejorar el sistema de salud pública, aumentando la financiación y mejorando el acceso a servicios médicos en zonas rurales.', 3, 'https://gacetamedica.com/wp-content/uploads/2023/05/GettyImages-1417889922.jpg'),
(17, 'La inteligencia artificial supera las expectativas en diagnóstico médico', 'Una nueva inteligencia artificial ha demostrado ser más precisa que los médicos en el diagnóstico de enfermedades, lo que podría transformar la medicina en los próximos años.', 1, 'https://static.eldiario.es/clip/299a87cc-53e0-4a60-9583-b9d251b7d21c_16-9-discover-aspect-ratio_default_0.jpg');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `datosnoticiero`
--
ALTER TABLE `datosnoticiero`
  ADD PRIMARY KEY (`cookie`,`noticiaID`),
  ADD KEY `noticiaID` (`noticiaID`);

--
-- Indices de la tabla `noticias`
--
ALTER TABLE `noticias`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_categoriaID` (`categoriaID`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `noticias`
--
ALTER TABLE `noticias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `datosnoticiero`
--
ALTER TABLE `datosnoticiero`
  ADD CONSTRAINT `datosnoticiero_ibfk_1` FOREIGN KEY (`noticiaID`) REFERENCES `noticias` (`id`);

--
-- Filtros para la tabla `noticias`
--
ALTER TABLE `noticias`
  ADD CONSTRAINT `noticias_ibfk_1` FOREIGN KEY (`categoriaID`) REFERENCES `categorias` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
