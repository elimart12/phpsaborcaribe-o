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
$mensaje = "";

// Si se envía el formulario de eliminación
if (isset($_POST['eliminar'])) {
    $id = $_POST['id'];
    
    // Eliminar el plato
    $sql = "DELETE FROM platos WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        $mensaje = "Plato eliminado correctamente.";
    } else {
        $mensaje = "Error al eliminar el plato: " . $conn->error;
    }
}

// Si se solicita confirmar la eliminación
if (isset($_POST['confirmar'])) {
    $id = $_POST['id'];
    
    // Obtener información del plato para mostrar en confirmación
    $sql = "SELECT * FROM platos WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $plato = $result->fetch_assoc();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eliminar Plato - Sabor Caribeño</title>
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
                <a class="nav-link" href="visualizar_platos.php">Visualizar Platos</a>
              </li>
              <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="eliminar_plato.php">Eliminar Plato</a>
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
        <h1>Eliminar Plato</h1>
        
        <?php if (!empty($mensaje)): ?>
            <div class="alert <?php echo strpos($mensaje, 'Error') !== false ? 'alert-danger' : 'alert-success'; ?>" role="alert">
                <?php echo $mensaje; ?>
            </div>
        <?php endif; ?>
        
        <?php if (isset($plato)): ?>
            <!-- Confirmación de eliminación -->
            <div class="card mb-4">
                <div class="card-header bg-danger text-white">Confirmar Eliminación</div>
                <div class="card-body">
                    <h5>¿Está seguro que desea eliminar el siguiente plato?</h5>
                    <p><strong>ID:</strong> <?php echo $plato['id']; ?></p>
                    <p><strong>Nombre:</strong> <?php echo htmlspecialchars($plato['nombre']); ?></p>
                    <p><strong>Categoría:</strong> <?php echo htmlspecialchars($plato['categoria']); ?></p>
                    <p><strong>Precio:</strong>