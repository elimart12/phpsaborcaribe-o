<?php
// Inicia sesión si es necesario
session_start();

// Conectar a la base de datos
$servername = "localhost";  // Cambia esto si tu servidor es diferente
$username = "root";         // Cambia este valor si tu usuario es diferente
$password = "";             // Cambia este valor si tu contraseña es diferente
$dbname = "sabor_caribe";  // Nombre corregido de la base de datos

$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Verificar si se envió el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
    // Recoger los datos del formulario
    $id = intval($_POST['id']);  // Conversión a entero
    $nombre = $conn->real_escape_string($_POST['nombre']);
    $descripcion = $conn->real_escape_string($_POST['descripcion']);
    $precio = floatval($_POST['precio']);
    $categoria = $conn->real_escape_string($_POST['categoria']);
    $disponible = intval($_POST['disponible']);

    // Preparar la consulta SQL para actualizar el plato
    $sql = "UPDATE platos SET 
            nombre='$nombre', 
            descripcion='$descripcion', 
            precio='$precio', 
            categoria='$categoria', 
            disponible='$disponible' 
            WHERE id='$id'";

    if ($conn->query($sql) === TRUE) {
        echo "<div class='alert alert-success'>Plato actualizado exitosamente.</div>";
    } else {
        echo "<div class='alert alert-danger'>Error: " . $conn->error . "</div>";
    }
}

// Verificar si el id del plato está presente en la URL para editar
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // Buscar el plato en la base de datos por id
    $sql = "SELECT * FROM platos WHERE id='$id'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Obtener los datos del plato para mostrar en el formulario
        $row = $result->fetch_assoc();
        $nombre = $row['nombre'];
        $descripcion = $row['descripcion'];
        $precio = $row['precio'];
        $categoria = $row['categoria'];
        $disponible = $row['disponible'];
    } else {
        echo "No se encontró el plato.";
    }
} else {
    echo "No se especificó el ID del plato.";
}

$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar Plato</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <div class="card mb-4">
            <div class="card-header">Modificar Plato</div>
            <div class="card-body">
                <form method="POST">
                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>">

                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre</label>
                        <input type="text" name="nombre" id="nombre" class="form-control" value="<?php echo htmlspecialchars($nombre); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="descripcion" class="form-label">Descripción</label>
                        <textarea name="descripcion" id="descripcion" class="form-control" required><?php echo htmlspecialchars($descripcion); ?></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="precio" class="form-label">Precio</label>
                        <input type="text" name="precio" id="precio" class="form-control" value="<?php echo htmlspecialchars($precio); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="categoria" class="form-label">Categoría</label>
                        <input type="text" name="categoria" id="categoria" class="form-control" value="<?php echo htmlspecialchars($categoria); ?>">
                    </div>
                    <div class="mb-3">
                        <label for="disponible" class="form-label">Disponible</label>
                        <select name="disponible" id="disponible" class="form-control">
                            <option value="1" <?php echo ($disponible == 1) ? 'selected' : ''; ?>>Sí</option>
                            <option value="0" <?php echo ($disponible == 0) ? 'selected' : ''; ?>>No</option>
                        </select>
                    </div>
                    <button type="submit" name="update" class="btn btn-warning">Actualizar Plato</button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>