<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pagina de inicio</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="style.css" rel="stylesheet">
</head>
<body class="d-flex flex-column min-vh-100 align-items-center">
    <nav class="navbar navbar-expand-lg navbar-light bg-light w-100">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">Aplicación de Sistemas Web</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Inicio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="01-formulario.php">Registrar Libro</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="listado.php">Listado de Libros</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="contacto.php">Contacto</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="text-center mt-3">
        <h1>LIBRO EXPRESS</h1>
        <p>LOS MEJORES LIBROS QUE VAS A ENCONTRAR ESTAN EN ESTE PORTAL.</p>
    </div>

    <div class="container mt-2">
        <div>
            <h2 class="text-center">LOS LIBROS MAS POPULARES</h2>
            <div class="bg-dark text-white p-3">
                <h3>ROMANCE</h3>
                <p>Los libros de romance se centran en las relaciones amorosas entre los personajes, 
                    explorando emociones, pasiones y desafíos que surgen en el camino del amor.
                     Este género abarca desde historias contemporáneas hasta romances históricos,
                      con tramas que pueden incluir dramas familiares, segundas oportunidades, 
                      amor prohibido o incluso toques de fantasía.</p>
            </div>
            <div class="bg-light text-dark p-3">
                <h3>CIENCIA FICCIÓN</h3>
                <p>Los libros de ciencia ficción exploran mundos imaginarios basados en avances científicos,
                     tecnológicos o futuristas, combinando elementos de la realidad con la especulación. 
                     Suelen abordar temas como inteligencia artificial, 
                     viajes espaciales, realidades virtuales, biotecnología y sociedades distópicas.</p>
            </div>
        </div>

    </div>

    <footer class="mt-3">
        <p>&copy; 2025 LIBRO EXPRESS</p>
    </footer>
</body>
</html>