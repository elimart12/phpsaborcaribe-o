<?php
// Inicia sesión, si es necesario.
session_start();

// Conectar a la base de datos
$servername = "localhost";  // Cambia esto si tu servidor es diferente
$username = "root";         // Cambia este valor si tu usuario es diferente
$password = "";             // Cambia este valor si tu contraseña es diferente
$dbname = "sabor_caribe";  // Cambia este valor por tu base de datos

$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Verificar si el formulario fue enviado
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add'])) {
    // Recoger los datos del formulario
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $precio = $_POST['precio'];
    $categoria = $_POST['categoria'];
    $disponible = $_POST['disponible'];

    // Preparar la consulta SQL para insertar el plato
    $sql = "INSERT INTO platos (nombre, descripcion, precio, categoria, disponible) 
            VALUES ('$nombre', '$descripcion', '$precio', '$categoria', '$disponible')";

    if ($conn->query($sql) === TRUE) {
        // Si la inserción es exitosa, redirigir o mostrar un mensaje de éxito
        echo "<div class='alert alert-success'>Producto agregado exitosamente.</div>";
    } else {
        // Si hay un error, mostrarlo
        echo "<div class='alert alert-danger'>Error: " . $conn->error . "</div>";
    }
}

$conn->close();
?>

<!-- Formulario HTML para agregar el plato -->


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    

    <div class="container mt-5">
    <div class="card mb-4">
    <div class="card-header">Agregar Plato</div>

    <div class="card-body">
        <form method="POST">
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre</label>
                <input type="text" name="nombre" id="nombre" class="form-control" placeholder="Nombre del plato" required>
            </div>
            <div class="mb-3">
                <label for="descripcion" class="form-label">Descripción</label>
                <textarea name="descripcion" id="descripcion" class="form-control" placeholder="Descripción del plato" required></textarea>
            </div>
            <div class="mb-3">
                <label for="precio" class="form-label">Precio</label>
                <input type="text" name="precio" id="precio" class="form-control" placeholder="Precio del plato" required>
            </div>
            <div class="mb-3">
                <label for="categoria" class="form-label">Categoría</label>
                <input type="text" name="categoria" id="categoria" class="form-control" placeholder="Categoría del plato">
            </div>
            <div class="mb-3">
                <label for="disponible" class="form-label">Disponible</label>
                <select name="disponible" id="disponible" class="form-control">
                    <option value="1">Sí</option>
                    <option value="0">No</option>
                </select>
            </div>
            <button type="submit" name="add" class="btn btn-primary">Agregar Plato</button>
        </form>
    </div>
</div>

</div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-vjOlo5CpyG61zlh0OUfbrFEL0HhDVL9rfV9eBoO4BlnmAZzYvn7Vlt/x+JzmFmS1" crossorigin="anonymous"></script>
</body>
</html>

