<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administración - Sabor Caribeño</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="styles.css" rel="stylesheet"> <!-- Aquí se enlaza el archivo CSS -->
</head>
<body>

    <main id="admin-main" class="container mt-5">
        <div class="row">
            <!-- Información del Restaurante -->
            <div class="col-md-6">
                <div class="card" id="admin-card-restaurant-info">
                    <div class="card-header bg-dark text-white">
                        <h5><i class="fas fa-store me-1"></i> Información del Restaurante</h5>
                    </div>
                    <div class="card-body">
                        <form id="admin-form-restaurant">
                            <div class="mb-3">
                                <label for="admin-restaurant-name" class="form-label">Nombre del Restaurante</label>
                                <input type="text" id="admin-restaurant-name" class="form-control" value="Sabor Caribeño">
                            </div>
                            <div class="mb-3">
                                <label for="admin-restaurant-description" class="form-label">Descripción</label>
                                <textarea id="admin-restaurant-description" class="form-control" rows="3">Auténtica cocina del Caribe con los mejores sabores tropicales.</textarea>
                            </div>
                            <div class="mb-3">
                                <label for="admin-restaurant-address" class="form-label">Dirección</label>
                                <input type="text" id="admin-restaurant-address" class="form-control" value="Calle Principal #123, Ciudad">
                            </div>
                            <div class="mb-3">
                                <label for="admin-restaurant-phone" class="form-label">Teléfono</label>
                                <input type="text" id="admin-restaurant-phone" class="form-control" value="+1 234 567 8900">
                            </div>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i>Guardar Cambios
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Configuración de Apariencia -->
            <div class="col-md-6">
                <div class="card" id="admin-card-appearance">
                    <div class="card-header bg-dark text-white">
                        <h5><i class="fas fa-palette me-1"></i> Apariencia</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">Tema del Sistema</label>
                            <div class="d-flex gap-2">
                                <button id="admin-theme-light" class="btn btn-outline-primary active">
                                    <i class="fas fa-sun me-1"></i>Claro
                                </button>
                                <button id="admin-theme-dark" class="btn btn-outline-dark">
                                    <i class="fas fa-moon me-1"></i>Oscuro
                                </button>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="admin-primary-color" class="form-label">Color Principal</label>
                            <input type="color" id="admin-primary-color" class="form-control form-control-color" value="#e67e22">
                        </div>
                        <hr>
                        <div class="mb-3">
                            <label class="form-label">Logo del Restaurante</label>
                            <div class="input-group mb-3">
                                <input type="file" class="form-control" id="admin-logo-upload">
                                <button class="btn btn-outline-secondary" type="button">
                                    <i class="fas fa-upload me-1"></i>Subir
                                </button>
                            </div>
                        </div>
                        <button type="button" id="admin-save-appearance" class="btn btn-dark">
                            <i class="fas fa-save me-1"></i>Aplicar Cambios
                        </button>
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
