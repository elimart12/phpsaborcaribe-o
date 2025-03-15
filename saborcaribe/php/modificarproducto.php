<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $precio = $_POST['precio'];
    $descripcion = $_POST['descripcion'];

    $sql = "UPDATE productos SET nombre='$nombre', precio='$precio', descripcion='$descripcion' WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        echo "Producto actualizado con éxito";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>
<form method="POST">
    <input type="hidden" name="id" value="<?php echo $id; ?>">
    <input type="text" name="nombre" value="<?php echo $nombre; ?>" required>
    <input type="text" name="precio" value="<?php echo $precio; ?>" required>
    <textarea name="descripcion"><?php echo $descripcion; ?></textarea>
    <button type="submit" name="update">Actualizar Producto</button>
</form>
