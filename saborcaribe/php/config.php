
<!-- anterior -->
<?php
$host = 'localhost';
$dbname = 'sabor_caribeno';
$username = 'root';
$password = '';

try {
    // Conexión con PDO (recomendada)
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
} catch (PDOException $e) {
    die("❌ Error de conexión con PDO: " . $e->getMessage());
}

// Conexión con MySQLi
$conn = new mysqli($host, $username, $password, $dbname);
if ($conn->connect_error) {
    die("❌ Conexión fallida con MySQLi: " . $conn->connect_error);
}

// Configurar MySQLi para usar UTF-8
$conn->set_charset("utf8mb4");

?>
