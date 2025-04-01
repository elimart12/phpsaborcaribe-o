<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: ../login_form.php");
    exit();
}

// Conexión a la base de datos - CREDENCIALES CORREGIDAS
$conn = new mysqli("localhost", "root", "", "sabor_caribeno");
// Alternativa: Puede que necesites usar estos valores según tu configuración de Laragon
// $conn = new mysqli("localhost", "root", "", "sabor_caribeno");

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Procesamiento de búsqueda
$searchTerm = '';
$categoriaFilter = '';

if (isset($_GET['search'])) {
    $searchTerm = $_GET['search'];
}

if (isset($_GET['categoria'])) {
    $categoriaFilter = $_GET['categoria'];
}

// Obtener categorías para el filtro
$categorias = [];
$sqlCategorias = "SELECT DISTINCT categoria FROM platos ORDER BY categoria";
$resultCategorias = $conn->query($sqlCategorias);
if ($resultCategorias->num_rows > 0) {
    while($row = $resultCategorias->fetch_assoc()) {
        $categorias[] = $row['categoria'];
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visualizar Platos - Sabor Caribeño</title>
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
                <a class="nav-link" href="modificar_plato.php">Modificar Plato</a>
              </li>
              <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="visualizar_platos.php">Visualizar Platos</a>
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
        <h1>Visualizar Platos</h1>
        
        <!-- Filtros y búsqueda -->
        <div class="card mb-4">
            <div class="card-header">Buscar y Filtrar Platos</div>
            <div class="card-body">
                <form method="GET" class="row g-3">
                    <div class="col-md-6">
                        <label for="search" class="form-label">Buscar por nombre o descripción</label>
                        <input type="text" class="form-control" id="search" name="search" value="<?php echo htmlspecialchars($searchTerm); ?>">
                    </div>
                    <div class="col-md-4">
                        <label for="categoria" class="form-label">Filtrar por categoría</label>
                        <select class="form-select" id="categoria" name="categoria">
                            <option value="">Todas las categorías</option>
                            <?php foreach($categorias as $cat): ?>
                                <option value="<?php echo htmlspecialchars($cat); ?>" <?php echo $categoriaFilter == $cat ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($cat); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary w-100">Filtrar</button>
                    </div>
                </form>
            </div>
        </div>
        
        <!-- Lista de platos -->
        <div class="card">
            <div class="card-header">Lista de Platos</div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Descripción</th>
                                <th>Precio</th>
                                <th>Categoría</th>
                                <th>Disponible</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Construir la consulta SQL con filtros
                            $sql = "SELECT * FROM platos WHERE 1=1";
                            
                            if (!empty($searchTerm)) {
                                $searchTerm = "%$searchTerm%";
                                $sql .= " AND (nombre LIKE ? OR descripcion LIKE ?)";
                            }
                            
                            if (!empty($categoriaFilter)) {
                                $sql .= " AND categoria = ?";
                            }
                            
                            $sql .= " ORDER BY categoria, nombre";
                            
                            $stmt = $conn->prepare($sql);
                            
                            // Bind parameters
                            if (!empty($searchTerm) && !empty($categoriaFilter)) {
                                $stmt->bind_param("sss", $searchTerm, $searchTerm, $categoriaFilter);
                            } elseif (!empty($searchTerm)) {
                                $stmt->bind_param("ss", $searchTerm, $searchTerm);
                            } elseif (!empty($categoriaFilter)) {
                                $stmt->bind_param("s", $categoriaFilter);
                            }
                            
                            $stmt->execute();
                            $result = $stmt->get_result();
                            
                            if ($result->num_rows > 0) {
                                while($row = $result->fetch_assoc()) {
                                    echo "<tr>";
                                    echo "<td>" . $row["id"] . "</td>";
                                    echo "<td>" . htmlspecialchars($row["nombre"]) . "</td>";
                                    echo "<td>" . htmlspecialchars($row["descripcion"]) . "</td>";
                                    echo "<td>$" . number_format($row["precio"], 2) . "</td>";
                                    echo "<td>" . htmlspecialchars($row["categoria"]) . "</td>";
                                    echo "<td>" . ($row["disponible"] ? '<span class="badge bg-success">Sí</span>' : '<span class="badge bg-danger">No</span>') . "</td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='6' class='text-center'>No se encontraron platos</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        
        <!-- Resumen estadístico -->
        <div class="row mt-4">
            <div class="col-md-4 mb-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Total de Platos</h5>
                        <?php
                        $sql = "SELECT COUNT(*) as total FROM platos";
                        $result = $conn->query($sql);
                        $row = $result->fetch_assoc();
                        echo "<h2 class='text-center'>" . $row['total'] . "</h2>";
                        ?>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Platos Disponibles</h5>
                        <?php
                        $sql = "SELECT COUNT(*) as total FROM platos WHERE disponible = 1";
                        $result = $conn->query($sql);
                        $row = $result->fetch_assoc();
                        echo "<h2 class='text-center'>" . $row['total'] . "</h2>";
                        ?>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Precio Promedio</h5>
                        <?php
                        $sql = "SELECT AVG(precio) as promedio FROM platos";
                        $result = $conn->query($sql);
                        $row = $result->fetch_assoc();
                        echo "<h2 class='text-center'>$" . number_format($row['promedio'], 2) . "</h2>";
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-vjOlo5CpyG61zlh0OUfbrFEL0HhDVL9rfV9eBoO4BlnmAZzYvn7Vlt/x+JzmFmS1" crossorigin="anonymous"></script>
</body>
</html>