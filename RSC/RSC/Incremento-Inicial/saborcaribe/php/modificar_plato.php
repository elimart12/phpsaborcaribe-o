<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: ../login_form.php");
    exit();
}

// Conexión a la base de datos
$conn = new mysqli("localhost", "usuario", "contraseña", "sabor_caribeno");

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Inicializar variables
$id = $nombre = $descripcion = $precio = $categoria = $disponible = "";
$mensaje = "";

// Si se envía el formulario de búsqueda
if (isset($_POST['buscar'])) {
    $id = $_POST['id'];
    
    // Consulta para obtener los datos del plato
    $sql = "SELECT * FROM platos WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $nombre = $row['nombre'];
        $descripcion = $row['descripcion'];
        $precio = $row['precio'];
        $categoria = $row['categoria'];
        $disponible = $row['disponible'];
    } else {
        $mensaje = "No se encontró un plato con ese ID.";
    }
}

// Si se envía el formulario de actualización
if (isset($_POST['actualizar'])) {
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $precio = $_POST['precio'];
    $categoria = $_POST['categoria'];
    $disponible = $_POST['disponible'];
    
    // Actualizar los datos del plato
    $sql = "UPDATE platos SET nombre = ?, descripcion = ?, precio = ?, categoria = ?, disponible = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssdsii", $nombre, $descripcion, $precio, $categoria, $disponible, $id);
    
    if ($stmt->execute()) {
        $mensaje = "Plato actualizado correctamente.";
    } else {
        $mensaje = "Error al actualizar el plato: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar Plato - Sabor Caribeño</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
          <a class="navbar-brand" href="../admin.php">Sabor Caribeño</a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
              <li class="nav-item">
                <a class="nav-link" href="agregar_plato.php">Agregar Plato</a>
              </li>
              <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="modificar_plato.php">Modificar Plato</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="visualizar_platos.php">Visualizar Platos</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="eliminar_plato.php">Eliminar Plato</a>
              </li>
            </ul>
            <ul class="navbar-nav ms-auto">
              <li class="nav-item">
                <a href="../login/logout.php" class="btn btn-danger">Cerrar sesión</a>
              </li>
            </ul>
          </div>
        </div>
    </nav>
    
    <div class="container mt-5">
        <h1>Modificar Plato</h1>
        
        <?php if (!empty($mensaje)): ?>
            <div class="alert <?php echo strpos($mensaje, 'Error') !== false ? 'alert-danger' : 'alert-success'; ?>" role="alert">
                <?php echo $mensaje; ?>
            </div>
        <?php endif; ?>
        
        <!-- Formulario de búsqueda -->
        <div class="card mb-4">
            <div class="card-header">Buscar Plato por ID</div>
            <div class="card-body">
                <form method="POST">
                    <div class="mb-3">
                        <label for="id" class="form-label">ID del Plato</label>
                        <input type="number" name="id" id="id" class="form-control" placeholder="Ingrese el ID del plato" required value="<?php echo $id; ?>">
                    </div>
                    <button type="submit" name="buscar" class="btn btn-primary">Buscar</button>
                </form>
            </div>
        </div>
        
        <!-- Formulario de actualización -->
        <?php if (!empty($nombre)): ?>
            <div class="card mb-4">
                <div class="card-header">Actualizar Plato</div>
                <div class="card-body">
                    <form method="POST">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre</label>
                            <input type="text" name="nombre" id="nombre" class="form-control" value="<?php echo $nombre; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="descripcion" class="form-label">Descripción</label>
                            <textarea name="descripcion" id="descripcion" class="form-control" required><?php echo $descripcion; ?></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="precio" class="form-label">Precio</label>
                            <input type="text" name="precio" id="precio" class="form-control" value="<?php echo $precio; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="categoria" class="form-label">Categoría</label>
                            <input type="text" name="categoria" id="categoria" class="form-control" value="<?php echo $categoria; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="disponible" class="form-label">Disponible</label>
                            <select name="disponible" id="disponible" class="form-control">
                                <option value="1" <?php echo $disponible == 1 ? 'selected' : ''; ?>>Sí</option>
                                <option value="0" <?php echo $disponible == 0 ? 'selected' : ''; ?>>No</option>
                            </select>
                        </div>
                        <button type="submit" name="actualizar" class="btn btn-warning">Actualizar Plato</button>
                    </form>
                </div>
            </div>
        <?php endif; ?>
        
        <!-- Lista de platos disponibles -->
        <div class="card">
            <div class="card-header">Platos Disponibles</div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Categoría</th>
                                <th>Precio</th>
                                <th>Disponible</th>
                                <th>Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql = "SELECT id, nombre, categoria, precio, disponible FROM platos ORDER BY id";
                            $result = $conn->query($sql);
                            
                            if ($result->num_rows > 0) {
                                while($row = $result->fetch_assoc()) {
                                    echo "<tr>";
                                    echo "<td>" . $row["id"] . "</td>";
                                    echo "<td>" . $row["nombre"] . "</td>";
                                    echo "<td>" . $row["categoria"] . "</td>";
                                    echo "<td>$" . $row["precio"] . "</td>";
                                    echo "<td>" . ($row["disponible"] ? 'Sí' : 'No') . "</td>";
                                    echo "<td><form method='post'><input type='hidden' name='id' value='" . $row["id"] . "'><button type='submit' name='buscar' class='btn btn-sm btn-info'>Seleccionar</button></form></td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='6' class='text-center'>No hay platos registrados</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-vjOlo5CpyG61zlh0OUfbrFEL0HhDVL9rfV9eBoO4BlnmAZzYvn7Vlt/x+JzmFmS1" crossorigin="anonymous"></script>
</body>
</html>