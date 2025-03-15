<?php
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['search'])) {
    $search = $_GET['search'];

    $sql = "SELECT * FROM productos WHERE nombre LIKE '%$search%' OR descripcion LIKE '%$search%'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo "ID: " . $row["id"]. " - Nombre: " . $row["nombre"]. " - Precio: " . $row["precio"]. " - Descripción: " . $row["descripcion"]. "<br>";
        }
    } else {
        echo "No se encontraron productos.";
    }
}
?>
<form method="GET">
    <input type="text" name="search" placeholder="Buscar producto..." required>
    <button type="submit">Buscar</button>
</form>
