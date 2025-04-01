<?php
require 'config.php';

// Usuarios de prueba con contraseñas encriptadas
$users = [
    ['admin_user', '123', 'admin'],
    ['client1', 'cliente123', 'client'],
    ['client2', 'cliente456', 'client']
];

foreach ($users as $user) {
    $username = $user[0];
    $password = password_hash($user[1], PASSWORD_DEFAULT); // Encripta la contraseña
    $role = $user[2];

    $stmt = $pdo->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, ?)");
    $stmt->execute([$username, $password, $role]);
}

echo "Usuarios insertados correctamente.";
?>
