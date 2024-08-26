document.addEventListener('DOMContentLoaded', function () {
    // Mostrar la tabla al hacer clic en el botón "Actualizar"
    document.querySelector('button[name="actualizar"]').addEventListener('click', function (event) {
        event.preventDefault();
        document.getElementById('facturas-table-wrapper').style.display = 'block';
        document.getElementById('facturas-action-buttons').style.display = 'block';
    });

    // Seleccionar o deseleccionar todos los checkboxes
    document.getElementById('select-all').addEventListener('click', function (event) {
        const checkboxes = document.querySelectorAll('input[name="select_factura[]"]');
        checkboxes.forEach(function (checkbox) {
            checkbox.checked = event.target.checked;
        });
    });
});
