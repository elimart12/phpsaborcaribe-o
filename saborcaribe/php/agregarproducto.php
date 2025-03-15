<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add'])) {
    $nombre = $_POST['nombre'];
    $precio = $_POST['precio'];
    $descripcion = $_POST['descripcion'];

    $sql = "INSERT INTO productos (nombre, precio, descripcion) VALUES ('$nombre', '$precio', '$descripcion')";

    if ($conn->query($sql) === TRUE) {
        echo "Producto agregado con éxito";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>
<form method="POST">
    <input type="text" name="nombre" placeholder="Nombre" required>
    <input type="text" name="precio" placeholder="Precio" required>
    <textarea name="descripcion" placeholder="Descripción"></textarea>
    <button type="submit" name="add">Agregar Producto</button>
</form>
