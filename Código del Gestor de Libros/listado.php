<?php
// Iniciar la sesión para acceder a los datos de libros
session_start();

// Función para obtener la lista de libros almacenados
function obtenerLibros() {
    return $_SESSION['libros'] ?? [];
}

// Obtener la lista de libros
$libros = obtenerLibros();

// Función para renderizar la tabla de libros
function renderizarTabla($libros) {
    if (empty($libros)) {
        // Mostrar mensaje si no hay libros
        echo "<tr><td colspan='5'>No existen libros registrados. </td></tr>";
    } else {
        foreach ($libros as $index => $libro) {
            // Renderizar cada libro como una fila de la tabla
            echo "
                <tr>
                    <td>" . ($index + 1) . "</td>
                    <td>" . $libro['nombre'] . "</td>
                    <td>" . $libro['autor'] . "</td>
                    <td>" . $libro['precio'] . "</td>
                    <td>" . $libro['stock'] . "</td>
                </tr>
            ";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de Libros</title>
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
    <h1 class="mt-3">Listado de Libros</h1>
    <div class="container mt-4">
        <div class="rounded-3 table-responsive mx-auto" style="max-width: 80%;">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Nombre</th>
                        <th>Autor</th>
                        <th>Precio</th>
                        <th>Stock</th>
                    </tr>
                </thead>
                <tbody>
                    <?php renderizarTabla($libros); ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>