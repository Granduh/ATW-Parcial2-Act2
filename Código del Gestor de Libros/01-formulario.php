<?php
// Iniciar la sesión para almacenar datos de libros
session_start();

// Inicializar la variable de sesión 'libros' si no existe
if (!isset($_SESSION['libros'])) {
    $_SESSION['libros'] = [];
}

// Función para obtener la lista de libros almacenados
function obtenerLibros() {
    return $_SESSION['libros'];
}

// Función para agregar un libro a la lista de libros
function agregarLibro($nombre, $autor, $precio, $stock) {
    // Validar los campos antes de agregar
    if (validarCampos($nombre, $autor, $precio, $stock)) {
        // Agregar el libro a la sesión
        $_SESSION['libros'][] = [
            'nombre' => htmlspecialchars($nombre), // Sanitizar el nombre
            'autor' => htmlspecialchars($autor),   // Sanitizar el autor
            'precio' => (float)$precio,           // Convertir precio a número flotante
            'stock' => (int)$stock,               // Convertir stock a número entero
        ];
        return true; // Indicar éxito
    }
    return false; // Indicar fallo
}

// Función para actualizar un libro existente
function actualizarLibro($index, $nombre, $autor, $precio, $stock) {
    // Verificar que el libro existe y los campos son válidos
    if (isset($_SESSION['libros'][$index]) && validarCampos($nombre, $autor, $precio, $stock)) {
        // Actualizar los valores del libro en la sesión
        $_SESSION['libros'][$index] = [
            'nombre' => htmlspecialchars($nombre), // Sanitizar el nombre
            'autor' => htmlspecialchars($autor),   // Sanitizar el autor
            'precio' => (float)$precio,           // Convertir precio a número flotante
            'stock' => (int)$stock,               // Convertir stock a número entero
        ];
        return true; // Indicar éxito
    }
    return false; // Indicar fallo
}

// Función para eliminar un libro por su índice
function eliminarLibro($index) {
    // Verificar que el índice existe en la lista
    if (isset($_SESSION['libros'][$index])) {
        // Eliminar el libro usando array_splice
        array_splice($_SESSION['libros'], $index, 1);
        return true; // Indicar éxito
    }
    return false; // Indicar fallo
}

// Función para validar los campos del formulario
function validarCampos($nombre, $autor, $precio, $stock) {
    // Verificar que el nombre no está vacío y que precio y stock son mayores a 0
    return !empty($nombre) && !empty($autor) && $precio > 0 && $stock > 0;
}

// Variables para manejar mensajes y valores del formulario
$alerta = ''; // Mensaje para alertar al usuario
$nombre = ''; // Nombre del Libro (vacío por defecto)
$autor = ''; // Autor del Libro (vacío por defecto)
$precio = ''; // Precio del libro (vacío por defecto)
$stock = ''; // Stock del libro (vacío por defecto)
$index = null; // Índice del libro para edición

// Procesar solicitudes POST (para agregar o actualizar libros)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener valores del formulario
    $nombre = $_POST['nombre'] ?? '';
    $autor = $_POST['autor'] ?? '';
    $precio = $_POST['precio'] ?? 0;
    $stock = $_POST['stock'] ?? 0;
    $index = $_POST['index'] ?? null;

    if ($index !== null && is_numeric($index)) {
        // Actualizar libro si se proporciona un índice válido
        if (actualizarLibro((int)$index, $nombre, $autor, $precio, $stock)) {
            $alerta = "El libro se ha actualizado exitosamente.";
            // Limpiar los valores del formulario después de actualizar
            $nombre = $autor = $precio = $stock = '';
        } else {
            $alerta = "Error al actualizar el libro.";
        }
    } else {
        // Agregar Libro si no se proporciona un índice
        if (agregarLibro($nombre, $autor, $precio, $stock)) {
            $alerta = "El libro se ha registrado exitosamente.";
            // Limpiar los valores del formulario después de agregar
            $nombre = $autor = $precio = $stock = '';
        } else {
            $alerta = "Error al registrar el libro. Verifica los campos.";
        }
    }
}

// Procesar solicitudes GET (para eliminar o editar libros)
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $action = $_GET['action'] ?? ''; // Obtener acción (edit o delete)
    $index = $_GET['index'] ?? null; // Obtener índice del producto

    if ($action === 'delete' && is_numeric($index)) {
        // Eliminar producto si la acción es delete y el índice es válido
        if (eliminarLibro((int)$index)) {
            $alerta = "Libro eliminado correctamente.";
        } else {
            $alerta = "Error al eliminar el libro.";
        }
    } elseif ($action === 'edit' && is_numeric($index)) {
        // Cargar datos del libro para edición
        $libro = $_SESSION['libros'][$index] ?? null;
        if ($libro) {
            $nombre = $libro['nombre'];
            $autor = $libro['autor'];
            $precio = $libro['precio'];
            $stock = $libro['stock'];
            $index = (int)$index;
        }
    }
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
                    <td>
                        <a class='btn btn-warning' href='?action=edit&index=$index'>Editar</a>
                        <a class='btn btn-danger' href='?action=delete&index=$index'>Eliminar</a>
                    </td>
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
    <title>Gestión de Productos</title>
    <script>
        // Función para validar el formulario antes de enviarlo
        function validarFormulario() {
            const nombre = document.getElementById('nombre').value.trim();
            const autor = document.getElementById('autor').value.trim();
            const precio = parseFloat(document.getElementById('precio').value);
            const stock = parseInt(document.getElementById('stock').value);

            // Validar que el nombre no esté vacío
            if (nombre === '') {
                alert('El nombre no puede estar vacío.');
                return false;
            }

            //validar que el autor no este vacio
            if (autor === '') {
                alert('El autor no puede estar vacío.');
                return false;
            }

            // Validar que el precio sea un número positivo
            if (isNaN(precio) || precio <= 0) {
                alert('El precio debe ser un número mayor a 0.');
                return false;
            }

            // Validar que el stock sea un número positivo
            if (isNaN(stock) || stock <= 0) {
                alert('El stock debe ser un número mayor a 0.');
                return false;
            }

            return true; // Formulario válido
        }

        // Mostrar alerta en pantalla después de una acción
        <?php if (!empty($alerta)) : ?>
            alert('<?php echo $alerta; ?>');
        <?php endif; ?>
    </script>
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
    <h1 class="mt-3">Registro de Libro</h1>
    <div class="form-container mx-auto ">
        <!-- Formulario para agregar o actualizar productos -->
        <form id="form-producto" method="POST" onsubmit="return validarFormulario();">
            <input type="hidden" name="index" value="<?php echo htmlspecialchars($index ?? ''); ?>">
            <label class="mt-3" for="nombre">Nombre del libro:</label><br>
            <input class="form-control" placeholder="Nombre del Libro" type="text" id="nombre" name="nombre" value="<?php echo htmlspecialchars($nombre ?? ''); ?>"><br>
            <label for="autor">Autor:</label><br>
            <input class="form-control" placeholder="Autor del Libro" type="text" id="autor" name="autor" value="<?php echo htmlspecialchars($autor ?? ''); ?>"><br>
            <label for="precio">Precio:</label><br>
            <input class="form-control" placeholder="$0.00" type="number" id="precio" name="precio" value="<?php echo htmlspecialchars($precio ?? ''); ?>"><br>
            <label for="stock">Unidades disponibles:</label><br>
            <input class="form-control" placeholder="Stock" type="number" id="stock" name="stock" value="<?php echo htmlspecialchars($stock ?? ''); ?>"><br>
            <div class="d-flex justify-content-center mt-3">
            <button type="submit" class="btn btn-success me-2"><?php echo isset($index) ? 'Actualizar' : 'Registrar'; ?></button>
            <button type="button" class="btn btn-primary" onclick="location.href='?';">Limpiar</button>
            </div>
            
        </form>
    </div>

    <div class="container mt-4">
        <h3 class="text-center">Lista de Libros</h3>
        <div class="table-responsive mx-auto" style="max-width: 80%;">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Nombre</th>
                        <th>Autor</th>
                        <th>Precio</th>
                        <th>Stock</th>
                        <th>Acciones</th>
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
