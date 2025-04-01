<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: ../login_form.php");
    exit();
}

// Conectar a la base de datos
$servername = "localhost";
$username = "root"; 
$password = ""; 
$dbname = "sabor_caribe";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Función para obtener un plato por ID
function obtenerPlatoPorId($conn, $id) {
    $sql = "SELECT * FROM platos WHERE id = $id";
    $result = $conn->query($sql);
    return $result->fetch_assoc();
}

// Función para actualizar un plato
function actualizarPlato($conn, $id, $nombre, $descripcion, $precio, $categoria, $disponible) {
    $sql = "UPDATE platos SET nombre='$nombre', descripcion='$descripcion', precio='$precio', categoria='$categoria', disponible='$disponible' WHERE id=$id";
    $conn->query($sql);
}

// Verificar si el formulario de actualización fue enviado
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['actualizar'])) {
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $precio = $_POST['precio'];
    $categoria = $_POST['categoria'];
    $disponible = $_POST['disponible'];

    actualizarPlato($conn, $id, $nombre, $descripcion, $precio, $categoria, $disponible);
    header("Location: Gestion-de-platos.php"); // Redirigir después de actualizar
    exit();
}

// Si se pasa un ID a través de GET, obtener los datos del plato a modificar
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $plato = obtenerPlatoPorId($conn, $id);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrador - Modificar Plato</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link rel="stylesheet" href="../css/styles.css" />
</head>
<body>
    <header id="admin-header" class="bg-primary text-white py-3">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h1 id="admin-brand" class="mb-0"><i class="fas fa-utensils me-2"></i>Sabor Caribeño</h1>
                </div>
                <div class="col-md-6 text-md-end">
                    <div id="admin-user-info">
                        <span class="me-3"><i class="fas fa-user-circle me-1"></i> <?php echo $_SESSION['username']; ?></span>
                        <a href="../php/logout.php" id="admin-logout" class="btn btn-light btn-sm">
                            <i class="fas fa-sign-out-alt me-1"></i>Cerrar sesión
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Formulario para Modificar Plato -->
    <div class="container my-5">
        <h2>Modificar Plato</h2>
        <?php if ($plato): ?>
        <form method="POST">
            <input type="hidden" name="id" value="<?= $plato['id']; ?>">
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre</label>
                <input type="text" class="form-control" name="nombre" value="<?= $plato['nombre']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="descripcion" class="form-label">Descripción</label>
                <textarea class="form-control" name="descripcion" required><?= $plato['descripcion']; ?></textarea>
            </div>
            <div class="mb-3">
                <label for="precio" class="form-label">Precio</label>
                <input type="number" class="form-control" name="precio" value="<?= $plato['precio']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="categoria" class="form-label">Categoría</label>
                <select class="form-select" name="categoria">
                    <option value="Principal" <?= $plato['categoria'] == 'Principal' ? 'selected' : ''; ?>>Principal</option>
                    <option value="Entrada" <?= $plato['categoria'] == 'Entrada' ? 'selected' : ''; ?>>Entrada</option>
                    <option value="Acompañante" <?= $plato['categoria'] == 'Acompañante' ? 'selected' : ''; ?>>Acompañante</option>
                    <option value="Postre" <?= $plato['categoria'] == 'Postre' ? 'selected' : ''; ?>>Postre</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="disponible" class="form-label">Disponible</label>
                <select class="form-select" name="disponible">
                    <option value="1" <?= $plato['disponible'] == 1 ? 'selected' : ''; ?>>Sí</option>
                    <option value="0" <?= $plato['disponible'] == 0 ? 'selected' : ''; ?>>No</option>
                </select>
            </div>
            <button type="submit" name="actualizar" class="btn btn-primary">Actualizar Plato</button>
        </form>
        <?php else: ?>
            <p>El plato no existe.</p>
        <?php endif; ?>
    </div>

    <!-- Footer -->
    <footer id="admin-footer" class="bg-dark text-white py-3 mt-4">
        <div class="container text-center">
            <p class="mb-0">&copy; 2025 Sabor Caribeño - Panel de Administración</p>
        </div>
    </footer>

    <!-- JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
