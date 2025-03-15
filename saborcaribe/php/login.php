<?php
session_start();
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();
    
    if ($user && $password == $user['password']) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['role'] = $user['role'];
        if ($user['role'] == 'admin') {
            header("Location: ../useradmin/admi.html");
        } else {
            header("Location: ../cliente/indexCliente.html");
        }
    } else {
        echo "<script>alert('Usuario o contraseña incorrectos'); window.location='../login/login.html';</script>";
        exit();
    }
}