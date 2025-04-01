<?php
// Conectar a la base de datos
$servername = "localhost";
$username = "root"; 
$password = ""; 
$dbname = "sabor_caribe";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Funciones para el CRUD
function obtenerPlatos($conn) {
    $sql = "SELECT * FROM platos";
    $result = $conn->query($sql);
    return $result;
}

function agregarPlato($conn, $nombre, $descripcion, $precio, $categoria, $disponible) {
    $sql = "INSERT INTO platos (nombre, descripcion, precio, categoria, disponible) VALUES ('$nombre', '$descripcion', '$precio', '$categoria', '$disponible')";
    $conn->query($sql);
}

function eliminarPlato($conn, $id) {
    $sql = "DELETE FROM platos WHERE id = $id";
    $conn->query($sql);
}

function actualizarPlato($conn, $id, $nombre, $descripcion, $precio, $categoria, $disponible) {
    $sql = "UPDATE platos SET nombre='$nombre', descripcion='$descripcion', precio='$precio', categoria='$categoria', disponible='$disponible' WHERE id=$id";
    $conn->query($sql);
}

// Lógica para agregar, eliminar o actualizar un plato
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['agregar'])) {
        agregarPlato($conn, $_POST['nombre'], $_POST['descripcion'], $_POST['precio'], $_POST['categoria'], $_POST['disponible']);
    }

    if (isset($_POST['eliminar'])) {
        eliminarPlato($conn, $_POST['id']);
    }

    if (isset($_POST['actualizar'])) {
        actualizarPlato($conn, $_POST['id'], $_POST['nombre'], $_POST['descripcion'], $_POST['precio'], $_POST['categoria'], $_POST['disponible']);
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Platos</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .table-responsive {
            max-height: 500px;
            overflow-y: auto;
        }
    </style>
</head>
<body>
    <div class="container my-4">
        <!-- Título y botón para agregar nuevo plato -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2><i class="fas fa-utensils text-primary me-2"></i>Gestión de Platos</h2>
            <button data-bs-toggle="modal" data-bs-target="#agregarPlatoModal" class="btn btn-primary">
                <i class="fas fa-plus-circle me-1"></i>Agregar Nuevo Plato
            </button>
        </div>

        <!-- Filtro y búsqueda -->
        <div class="card mb-4" id="admin-platos-search">
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="input-group">
                            <span class="input-group-text bg-primary text-white">
                                <i class="fas fa-search"></i>
                            </span>
                            <input type="text" id="admin-search-plato" class="form-control" placeholder="Buscar plato...">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <select id="admin-filter-categoria" class="form-select">
                            <option value="">Todas las categorías</option>
                            <option value="Principal">Principal</option>
                            <option value="Entrada">Entrada</option>
                            <option value="Acompañante">Acompañante</option>
                            <option value="Postre">Postre</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select id="admin-filter-disponible" class="form-select">
                            <option value="">Disponibilidad</option>
                            <option value="1">Disponible</option>
                            <option value="0">No disponible</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabla de platos -->
        <div class="card" id="admin-platos-table-card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover" id="admin-platos-table">
                        <thead class="table-dark">
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Descripción</th>
                                <th>Precio</th>
                                <th>Categoría</th>
                                <th>Disponible</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Obtener platos de la base de datos
                            $platos = obtenerPlatos($conn);
                            while ($plato = $platos->fetch_assoc()) {
                            ?>
                                <tr>
                                    <td><?= $plato['id']; ?></td>
                                    <td><?= $plato['nombre']; ?></td>
                                    <td><?= $plato['descripcion']; ?></td>
                                    <td>$<?= number_format($plato['precio'], 2); ?></td>
                                    <td><span class="badge bg-primary"><?= $plato['categoria']; ?></span></td>
                                    <td><span class="badge <?= $plato['disponible'] ? 'bg-success' : 'bg-danger'; ?>"><?= $plato['disponible'] ? 'Sí' : 'No'; ?></span></td>
                                    <td>
                                        <button class="btn btn-sm btn-warning me-1" data-bs-toggle="modal" data-bs-target="#editarPlatoModal" data-id="<?= $plato['id']; ?>" data-nombre="<?= $plato['nombre']; ?>" data-descripcion="<?= $plato['descripcion']; ?>" data-precio="<?= $plato['precio']; ?>" data-categoria="<?= $plato['categoria']; ?>" data-disponible="<?= $plato['disponible']; ?>">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <form method="POST" style="display:inline;">
                                            <input type="hidden" name="id" value="<?= $plato['id']; ?>">
                                            <button type="submit" name="eliminar" class="btn btn-sm btn-danger">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Agregar Plato -->
    <div class="modal fade" id="agregarPlatoModal" tabindex="-1" aria-labelledby="agregarPlatoModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="agregarPlatoModalLabel">Agregar Nuevo Plato</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST">
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre</label>
                            <input type="text" class="form-control" name="nombre" required>
                        </div>
                        <div class="mb-3">
                            <label for="descripcion" class="form-label">Descripción</label>
                            <textarea class="form-control" name="descripcion" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="precio" class="form-label">Precio</label>
                            <input type="number" class="form-control" name="precio" required>
                        </div>
                        <div class="mb-3">
                            <label for="categoria" class="form-label">Categoría</label>
                            <select class="form-select" name="categoria">
                                <option value="Principal">Principal</option>
                                <option value="Entrada">Entrada</option>
                                <option value="Acompañante">Acompañante</option>
                                <option value="Postre">Postre</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="disponible" class="form-label">Disponible</label>
                            <select class="form-select" name="disponible">
                                <option value="1">Sí</option>
                                <option value="0">No</option>
                            </select>
                        </div>
                        <button type="submit" name="agregar" class="btn btn-primary">Guardar Plato</button>
                    </form>
                </div>
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

    <!-- Agregar archivos de JS (Bootstrap y FontAwesome) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../js/script.js">
</body>
</html>
