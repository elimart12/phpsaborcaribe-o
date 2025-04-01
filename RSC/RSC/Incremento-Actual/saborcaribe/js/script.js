// Script para activar las pestañas
document.addEventListener('DOMContentLoaded', function() {
    const navLinks = document.querySelectorAll('.nav-link');
    navLinks.forEach(link => {
        link.addEventListener('click', function() {
            navLinks.forEach(l => l.classList.remove('active'));
            this.classList.add('active');
        });
    });
    
    // Conectar botones rápidos a sus pestañas
    document.getElementById('admin-action-add').addEventListener('click', function(e) {
        e.preventDefault();
        document.getElementById('admin-nav-platos').click();
        // Aquí podrías activar un modal o alguna otra acción
    });
    
    document.getElementById('admin-action-edit').addEventListener('click', function(e) {
        e.preventDefault();
        document.getElementById('admin-nav-platos').click();
    });
    
    document.getElementById('admin-action-user').addEventListener('click', function(e) {
        e.preventDefault();
        document.getElementById('admin-nav-users').click();
    });
});

        // Rellenar los campos del modal de edición
        var editarPlatoModal = document.getElementById('editarPlatoModal');
        editarPlatoModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget;
            var id = button.getAttribute('data-id');
            var nombre = button.getAttribute('data-nombre');
            var descripcion = button.getAttribute('data-descripcion');
            var precio = button.getAttribute('data-precio');
            var categoria = button.getAttribute('data-categoria');
            var disponible = button.getAttribute('data-disponible');

            document.getElementById('edit-id').value = id;
            document.getElementById('edit-nombre').value = nombre;
            document.getElementById('edit-descripcion').value = descripcion;
            document.getElementById('edit-precio').value = precio;
            document.getElementById('edit-categoria').value = categoria;
            document.getElementById('edit-disponible').value = disponible;
        });