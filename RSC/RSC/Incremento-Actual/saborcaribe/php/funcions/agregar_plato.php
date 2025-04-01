<?php
session_start();

// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sabor_caribe";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$mensaje = "";
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add'])) {
    $nombre = trim($_POST['nombre']);
    $descripcion = trim($_POST['descripcion']);
    $precio = floatval($_POST['precio']);
    $categoria = trim($_POST['categoria']);
    $disponible = intval($_POST['disponible']);

    $stmt = $conn->prepare("INSERT INTO platos (nombre, descripcion, precio, categoria, disponible) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssdsi", $nombre, $descripcion, $precio, $categoria, $disponible);
    
    if ($stmt->execute()) {
        $mensaje = "<div class='alert alert-success'>Producto agregado exitosamente.</div>";
    } else {
        $mensaje = "<div class='alert alert-danger'>Error al agregar producto.</div>";
    }
    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Producto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/styles.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            max-width: 600px;
            margin-top: 50px;
        }
        .card {
            border-radius: 15px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <div class="card-header bg-primary text-white text-center">Agregar Plato</div>
            <div class="card-body">
                <?php echo $mensaje; ?>
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
                        <input type="number" step="0.01" name="precio" id="precio" class="form-control" placeholder="Precio del plato" required>
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
                    <button type="submit" name="add" class="btn btn-success w-100">Agregar Plato</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Editar Plato -->
    <div class="modal fade" id="editarPlatoModal" tabindex="-1" aria-labelledby="editarPlatoModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editarPlatoModalLabel">Editar Plato</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST">
                        <input type="hidden" name="id" id="edit-id">
                        <div class="mb-3">
                            <label for="edit-nombre" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="edit-nombre" name="nombre" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit-descripcion" class="form-label">Descripción</label>
                            <textarea class="form-control" id="edit-descripcion" name="descripcion" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="edit-precio" class="form-label">Precio</label>
                            <input type="number" class="form-control" id="edit-precio" name="precio" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit-categoria" class="form-label">Categoría</label>
                            <select class="form-select" id="edit-categoria" name="categoria">
                                <option value="Principal">Principal</option>
                                <option value="Entrada">Entrada</option>
                                <option value="Acompañante">Acompañante</option>
                                <option value="Postre">Postre</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="edit-disponible" class="form-label">Disponible</label>
                            <select class="form-select" id="edit-disponible" name="disponible">
                                <option value="1">Sí</option>
                                <option value="0">No</option>
                            </select>
                        </div>
                        <button type="submit" name="actualizar" class="btn btn-warning">Actualizar Plato</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>