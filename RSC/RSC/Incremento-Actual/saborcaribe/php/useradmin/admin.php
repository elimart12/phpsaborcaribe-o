<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: ../login_form.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrador - Sabor Caribeño</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link rel="stylesheet" href="../css/styles.css" />
</head>
<body>
    <!-- Header con logo y nombre del restaurante -->
    <header id="admin-header" class="bg-primary text-white py-3">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h1 id="admin-brand" class="mb-0"><i class="fas fa-utensils me-2"></i>Sabor Caribeño</h1>
                </div>
                <div class="col-md-6 text-md-end">
                    <div id="admin-user-info">
                        <span class="me-3"><i class="fas fa-user-circle me-1"></i> <?php echo $_SESSION['username']; ?></span>
                        <a href="../php/logout.php" id="admin-logout" class="btn btn-light btn-sm">
                            <i class="fas fa-sign-out-alt me-1"></i>Cerrar sesión
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Navegación principal -->
    <nav id="admin-nav" class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#adminNavbar" aria-controls="adminNavbar" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="adminNavbar">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active" id="admin-nav-dashboard" href="dashboard_url" target="_blank">
                            <i class="fas fa-tachometer-alt me-1"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="admin-nav-platos" href="..\pages\Gestion-de-platos.php" target="_blank">
                            <i class="fas fa-hamburger me-1"></i> Gestión de Platos
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="admin-nav-users" href="..\php\pages\usuarios.php" target="_blank">
                            <i class="fas fa-users me-1"></i> Usuarios
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="admin-nav-settings" href="..\php\pages\configuracion.php" target="_blank">
                            <i class="fas fa-cog me-1"></i> Configuración
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Contenido principal -->
    <main class="container py-4">
        <div class="tab-content" id="admin-content">
            <!-- Dashboard -->
            <div class="tab-pane fade show active" id="dashboard">
                <div class="row">
                    <div class="col-12">
                        <div class="card mb-4" id="admin-welcome-card">
                            <div class="card-body">
                                <h2 id="admin-welcome-title"><i class="fas fa-utensils text-primary me-2"></i>Bienvenido al Panel de Administración</h2>
                                <p>Gestiona todos los aspectos de tu restaurante desde este panel de control centralizado.</p>
                            </div>
                        </div>
                    </div>
                    <!-- Tarjetas de estadísticas -->
                    <div class="col-md-3 mb-4">
                        <div class="card border-primary h-100" id="admin-stats-platos">
                            <div class="card-body text-center">
                                <i class="fas fa-hamburger fa-3x text-primary mb-3"></i>
                                <h3 class="admin-stats-number">10</h3>
                                <p class="admin-stats-title">Platos en Menú</p>
                            </div>
                            <div class="card-footer bg-primary text-white">
                                <small><i class="fas fa-info-circle me-1"></i> Total platos registrados</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-4">
                        <div class="card border-success h-100" id="admin-stats-users">
                            <div class="card-body text-center">
                                <i class="fas fa-users fa-3x text-success mb-3"></i>
                                <h3 class="admin-stats-number">3</h3>
                                <p class="admin-stats-title">Usuarios Registrados</p>
                            </div>
                            <div class="card-footer bg-success text-white">
                                <small><i class="fas fa-info-circle me-1"></i> Clientes y administradores</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-4">
                        <div class="card border-warning h-100" id="admin-stats-categories">
                            <div class="card-body text-center">
                                <i class="fas fa-tags fa-3x text-warning mb-3"></i>
                                <h3 class="admin-stats-number">5</h3>
                                <p class="admin-stats-title">Categorías</p>
                            </div>
                            <div class="card-footer bg-warning text-dark">
                                <small><i class="fas fa-info-circle me-1"></i> Tipos de platos</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-4">
                        <div class="card border-danger h-100" id="admin-stats-unavailable">
                            <div class="card-body text-center">
                                <i class="fas fa-exclamation-triangle fa-3x text-danger mb-3"></i>
                                <h3 class="admin-stats-number">0</h3>
                                <p class="admin-stats-title">Platos No Disponibles</p>
                            </div>
                            <div class="card-footer bg-danger text-white">
                                <small><i class="fas fa-info-circle me-1"></i> Revisar disponibilidad</small>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Acciones rápidas -->
                <div class="row mt-2">
                    <div class="col-12">
                        <div class="card" id="admin-quick-actions">
                            <div class="card-header bg-dark text-white">
                                <h5 id="admin-quick-title"><i class="fas fa-bolt me-2"></i>Acciones Rápidas</h5>
                            </div>
                            <div class="card-body">
                                <div class="row text-center">
                                    <div class="col-md-3 col-6 mb-3">
                                        <a href="../funcions/agregar_plato.php" id="admin-action-add" class="btn btn-outline-primary w-100 py-3" target="_blank">
                                            <i class="fas fa-plus-circle fa-2x mb-2"></i><br>
                                            Agregar Plato
                                        </a>
                                    </div>
                                    <div class="col-md-3 col-6 mb-3">
                                        <a href="..\funcions\modificar_plato.php" id="admin-action-edit" class="btn btn-outline-warning w-100 py-3" target="_blank">
                                            <i class="fas fa-edit fa-2x mb-2"></i><br>
                                            Modificar Plato
                                        </a>
                                    </div>
                                    <div class="col-md-3 col-6 mb-3">
                                        <a href="#" id="admin-action-view" class="btn btn-outline-success w-100 py-3" target="_blank">
                                            <i class="fas fa-eye fa-2x mb-2"></i><br>
                                            Ver Menú
                                        </a>
                                    </div>
                                    <div class="col-md-3 col-6 mb-3">
                                        <a href="#" id="admin-action-user" class="btn btn-outline-info w-100 py-3" target="_blank">
                                            <i class="fas fa-user-plus fa-2x mb-2"></i><br>
                                            Nuevo Usuario
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>

    <!-- Footer -->
    <footer id="admin-footer" class="bg-dark text-white py-3 mt-4">
        <div class="container text-center">
            <p class="mb-0">&copy; 2025 Sabor Caribeño - Panel de Administración</p>
        </div>
    </footer>

    <!-- JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
