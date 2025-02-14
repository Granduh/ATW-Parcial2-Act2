# Gestión de Libros con PHP y Sesiones

Este proyecto es una aplicación web en PHP que permite la gestión de libros mediante el uso de sesiones. Permite agregar, editar y eliminar libros de una lista almacenada en la sesión del usuario.

## Requisitos
- Servidor web con soporte para PHP (Apache, Nginx, etc.).
- PHP 7.4 o superior.
- Bootstrap 5 para el diseño de la interfaz.

## Instalación
1. Clona este repositorio en tu servidor web:
   ```sh
   git clone https://github.com/Granduh/ATW-Parcial2-Act2.git
   ```
2. Coloca los archivos en la carpeta pública del servidor (por ejemplo, htdocs en XAMPP).
3. Asegúrate de que el servidor esté corriendo y accede al archivo `index.php` desde el navegador.

## Funcionamiento del Código PHP del archivo 01-formulario.php
El código utiliza sesiones para almacenar la lista de libros. Cada libro tiene los siguientes atributos:
- Nombre
- Autor
- Precio
- Stock

### 1. Inicialización de la sesión
```php
session_start();
if (!isset($_SESSION['libros'])) {
    $_SESSION['libros'] = [];
}
```
Se inicia la sesión y se verifica si existe la variable `$_SESSION['libros']`. Si no existe, se inicializa como un arreglo vacío.

### 2. Funciones principales
#### Obtener la lista de libros
```php
function obtenerLibros() {
    return $_SESSION['libros'];
}
```
Esta función retorna la lista de libros almacenados en la sesión.

#### Agregar un libro
```php
function agregarLibro($nombre, $autor, $precio, $stock) {
    if (validarCampos($nombre, $autor, $precio, $stock)) {
        $_SESSION['libros'][] = [
            'nombre' => htmlspecialchars($nombre),
            'autor' => htmlspecialchars($autor),
            'precio' => (float)$precio,
            'stock' => (int)$stock,
        ];
        return true;
    }
    return false;
}
```
Esta función recibe los datos de un libro, valida los campos y lo agrega a la sesión.

#### Actualizar un libro
```php
function actualizarLibro($index, $nombre, $autor, $precio, $stock) {
    if (isset($_SESSION['libros'][$index]) && validarCampos($nombre, $autor, $precio, $stock)) {
        $_SESSION['libros'][$index] = [
            'nombre' => htmlspecialchars($nombre),
            'autor' => htmlspecialchars($autor),
            'precio' => (float)$precio,
            'stock' => (int)$stock,
        ];
        return true;
    }
    return false;
}
```
Si el índice existe, actualiza los datos del libro en la sesión.

#### Eliminar un libro
```php
function eliminarLibro($index) {
    if (isset($_SESSION['libros'][$index])) {
        array_splice($_SESSION['libros'], $index, 1);
        return true;
    }
    return false;
}
```
Elimina un libro de la lista usando su índice.

#### Validar los campos del formulario
```php
function validarCampos($nombre, $autor, $precio, $stock) {
    return !empty($nombre) && !empty($autor) && $precio > 0 && $stock > 0;
}
```
Verifica que los campos no estén vacíos y que precio y stock sean mayores a 0.

### 3. Procesamiento de formularios
El código maneja tanto solicitudes `POST` (para agregar/actualizar) como `GET` (para eliminar o editar libros).

#### Procesar solicitudes POST
```php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'] ?? '';
    $autor = $_POST['autor'] ?? '';
    $precio = $_POST['precio'] ?? 0;
    $stock = $_POST['stock'] ?? 0;
    $index = $_POST['index'] ?? null;

    if ($index !== null && is_numeric($index)) {
        if (actualizarLibro((int)$index, $nombre, $autor, $precio, $stock)) {
            $alerta = "El libro se ha actualizado exitosamente.";
        } else {
            $alerta = "Error al actualizar el libro.";
        }
    } else {
        if (agregarLibro($nombre, $autor, $precio, $stock)) {
            $alerta = "El libro se ha registrado exitosamente.";
        } else {
            $alerta = "Error al registrar el libro. Verifica los campos.";
        }
    }
}
```
Si se envía un índice, se actualiza el libro; de lo contrario, se agrega uno nuevo.

#### Procesar solicitudes GET
```php
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $action = $_GET['action'] ?? '';
    $index = $_GET['index'] ?? null;

    if ($action === 'delete' && is_numeric($index)) {
        if (eliminarLibro((int)$index)) {
            $alerta = "Libro eliminado correctamente.";
        } else {
            $alerta = "Error al eliminar el libro.";
        }
    } elseif ($action === 'edit' && is_numeric($index)) {
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
```
Maneja la edición y eliminación de libros.

### 4. Renderizar la tabla de libros
```php
function renderizarTabla($libros) {
    if (empty($libros)) {
        echo "<tr><td colspan='5'>No existen libros registrados.</td></tr>";
    } else {
        foreach ($libros as $index => $libro) {
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
```
Genera una tabla HTML con los libros almacenados.

## Funcionamiento del Código PHP del archivo listado.php
#### Obtener la lista de libros
```php
function obtenerLibros() {
    return $_SESSION['libros'];
}
```
Esta función retorna la lista de libros almacenados en la sesión.

#### Renderizar la tabla de libros
```php
function renderizarTabla($libros) {
    if (empty($libros)) {
        echo "<tr><td colspan='5'>No existen libros registrados.</td></tr>";
    } else {
        foreach ($libros as $index => $libro) {
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
```
Genera una tabla HTML con los libros almacenados, la principal diferencia con la tabla de formulario-01.php es que esta únicamente nos muestra los registros de libros, sin ofrecernos las opciones de editar o eliminar el registro.

## Estilos y Bibliotecas
- Bootstrap 5 se usa para mejorar la apariencia de la aplicación.
- Un archivo `style.css` permite personalizar la interfaz.

## Contribuidores 👥

- **Carlos Ramiro Yanez Yazan** - [ramiro3456_@outlook.com](mailto:ramiro3456_@outlook.com)
- **Andrés Alejandro Toledo Rojas** - [andrestoledo587@gmail.com](mailto:andrestoledo587@gmail.com)
- **Luis David Flores Pillajo** - [luis56flores@outlook.com](mailto:luis56flores@outlook.com)
