<?php
$sql = "SELECT * FROM productos";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "ID: " . $row["id"] . " - Nombre: " . $row["nombre"] . " - Precio: " . $row["precio"] . " - Descripción: " . $row["descripcion"] . "<br>";
        echo "<a href='?edit=".$row["id"]."'>Modificar</a> | <a href='?delete=".$row["id"]."'>Eliminar</a><br>";
    }
} else {
    echo "No hay productos disponibles.";
}
?>
