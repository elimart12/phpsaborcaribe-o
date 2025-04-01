<?php
// Inicia sesión, si es necesario.
session_start();

// Conectar a la base de datos
$servername = "localhost";  
$username = "root";         
$password = "";            
$dbname = "sabor_caribe";  

$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Verificar si el formulario fue enviado para agregar un plato
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add'])) {
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $precio = $_POST['precio'];
    $categoria = $_POST['categoria'];
    $disponible = $_POST['disponible'];

    $sql = "INSERT INTO platos (nombre, descripcion, precio, categoria, disponible) 
            VALUES ('$nombre', '$descripcion', '$precio', '$categoria', '$disponible')";

    if ($conn->query($sql) === TRUE) {
        echo "<div class='alert alert-success'>Producto agregado exitosamente.</div>";
    } else {
        echo "<div class='alert alert-danger'>Error: " . $conn->error . "</div>";
    }
}

// Verificar si el formulario fue enviado para modificar un plato
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['modify'])) {
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $precio = $_POST['precio'];
    $categoria = $_POST['categoria'];
    $disponible = $_POST['disponible'];

    $sql = "UPDATE platos SET nombre='$nombre', descripcion='$descripcion', precio='$precio', categoria='$categoria', disponible='$disponible' WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        echo "<div class='alert alert-success'>Producto modificado exitosamente.</div>";
    } else {
        echo "<div class='alert alert-danger'>Error: " . $conn->error . "</div>";
    }
}

// Verificar si el formulario fue enviado para eliminar un plato
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete'])) {
    $id = $_POST['id'];

    $sql = "DELETE FROM platos WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        echo "<div class='alert alert-success'>Producto eliminado exitosamente.</div>";
    } else {
        echo "<div class='alert alert-danger'>Error: " . $conn->error . "</div>";
    }
}

// Visualizar los platos
$platos = $conn->query("SELECT * FROM platos");

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrador - Sabor Caribeño</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script>
        function mostrarSeccion(seccion) {
            var secciones = document.querySelectorAll('.contenido');
            secciones.forEach(function(seccion) {
                seccion.style.display = 'none';
            });
            document.getElementById(seccion).style.display = 'block';
        }
    </script>
    <style>
        /* Añadir margen para que los formularios no estén pegados a los bordes */
        .contenido {
            margin-left: 15px;
            margin-right: 15px;
        }
        .form-control {
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Sabor Caribeño</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="#" onclick="mostrarSeccion('agregarPlato')">Agregar Plato</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" onclick="mostrarSeccion('modificarPlato')">Modificar Plato</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" onclick="mostrarSeccion('visualizarPlatos')">Visualizar Platos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" onclick="mostrarSeccion('eliminarPlato')">Eliminar Plato</a>
                    </li>
                </ul>
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a href="../login/login.html" class="btn btn-danger">Cerrar sesión</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    
    <div class="container mt-5">
        <h1>Bienvenido, Administrador</h1>
        <p class="lead">Panel de administración de Sabor Caribeño</p>
    </div>

    <!-- Sección de agregar plato -->
    <div id="agregarPlato" class="contenido" style="display:none;">
        <h2>Agregar Plato</h2>
        <form method="POST" class="mb-4">
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

    <!-- Sección de modificar plato -->
    <div id="modificarPlato" class="contenido" style="display:none;">
        <h2>Modificar Plato</h2>
        <form method="POST" class="mb-4">
            <div class="mb-3">
                <label for="id" class="form-label">ID del Plato</label>
                <input type="text" name="id" id="id" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre</label>
                <input type="text" name="nombre" id="nombre" class="form-control" placeholder="Nuevo nombre del plato" required>
            </div>
            <div class="mb-3">
                <label for="descripcion" class="form-label">Descripción</label>
                <textarea name="descripcion" id="descripcion" class="form-control" placeholder="Nueva descripción" required></textarea>
            </div>
            <div class="mb-3">
                <label for="precio" class="form-label">Precio</label>
                <input type="text" name="precio" id="precio" class="form-control" placeholder="Nuevo precio" required>
            </div>
            <div class="mb-3">
                <label for="categoria" class="form-label">Categoría</label>
                <input type="text" name="categoria" id="categoria" class="form-control" placeholder="Nueva categoría">
            </div>
            <div class="mb-3">
                <label for="disponible" class="form-label">Disponible</label>
                <select name="disponible" id="disponible" class="form-control">
                    <option value="1">Sí</option>
                    <option value="0">No</option>
                </select>
            </div>
            <button type="submit" name="modify" class="btn btn-primary">Modificar Plato</button>
        </form>
    </div>

    <!-- Sección de visualizar platos -->
    <div id="visualizarPlatos" class="contenido" style="display:none;">
        <h2>Visualizar Platos</h2>
        <table class="table table-bordered">
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
                <?php while($plato = $platos->fetch_assoc()): ?>
                    <tr>
                        <td><?= $plato['id'] ?></td>
                        <td><?= $plato['nombre'] ?></td>
                        <td><?= $plato['descripcion'] ?></td>
                        <td><?= $plato['precio'] ?></td>
                        <td><?= $plato['categoria'] ?></td>
                        <td><?= $plato['disponible'] == 1 ? 'Sí' : 'No' ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <!-- Sección de eliminar plato -->
    <div id="eliminarPlato" class="contenido" style="display:none;">
        <h2>Eliminar Plato</h2>
        <form method="POST" class="mb-4">
            <div class="mb-3">
                <label for="id" class="form-label">ID del Plato</label>
                <input type="text" name="id" id="id" class="form-control" required>
            </div>
            <button type="submit" name="delete" class="btn btn-danger">Eliminar Plato</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-vjOlo5CpyG61zlh0OUfbrFEL0HhDVL9rfV9eBoO4BlnmAZzYvn7Vlt/x+JzmFmS1" crossorigin="anonymous"></script>
</body>
</html>
