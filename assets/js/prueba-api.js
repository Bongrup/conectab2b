document.getElementById('test-magicloops').addEventListener('click', function (event) {
    event.preventDefault();

    var responseDiv = document.getElementById('mockapi-response');
    responseDiv.innerHTML = '<p>Conectando a la API...</p>';

    fetch(apiUrl, {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json'
        }
    })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            // Limpiar la tabla antes de llenarla
            const tableBody = document.querySelector('#facturas-table tbody');
            tableBody.innerHTML = ''; // Asegurarnos de que la tabla esté vacía antes de agregar nuevas filas

            // Crear filas de la tabla con los datos del JSON
            data.forEach(item => {
                const row = document.createElement('tr');

                // Checkbox
                const checkboxCell = document.createElement('td');
                const checkbox = document.createElement('input');
                checkbox.type = 'checkbox';
                checkbox.addEventListener('change', function () {
                    if (this.checked) {
                        row.classList.add('selected');
                    } else {
                        row.classList.remove('selected');
                    }
                });
                checkboxCell.appendChild(checkbox);
                row.appendChild(checkboxCell);

                // Botón IMP con icono
                const impCell = document.createElement('td'); // Asegúrate de definir `impCell` antes de usarlo
                const impButton = document.createElement('button');
                impButton.className = 'button-imp';
                impButton.innerHTML = '<i class="fas fa-print"></i>'; // Aquí se utiliza el icono de Font Awesome
                impCell.appendChild(impButton);
                row.appendChild(impCell); // `impCell` se añade a la fila aquí

                // Botón EMAIL con icono
                const emailCell = document.createElement('td'); // Asegúrate de definir `emailCell` antes de usarlo
                const emailButton = document.createElement('button');
                emailButton.className = 'button-email';
                emailButton.innerHTML = '<i class="fas fa-envelope"></i>'; // Aquí se utiliza el icono de Font Awesome
                emailCell.appendChild(emailButton);
                row.appendChild(emailCell); // `emailCell` se añade a la fila aquí

                // Factura
                const facturaCell = document.createElement('td');
                facturaCell.innerText = item.factura;
                row.appendChild(facturaCell);

                // Fecha (solo los primeros 10 caracteres)
                const fechaCell = document.createElement('td');
                fechaCell.innerText = item.fecha.substring(0, 10);
                row.appendChild(fechaCell);

                // Obra
                const obraCell = document.createElement('td');
                obraCell.innerText = `${item.obra} - ${item.nombre}`;
                row.appendChild(obraCell);

                // Total
                const totalCell = document.createElement('td');
                totalCell.innerText = item.total + '€';
                row.appendChild(totalCell);

                // Estado
                const estadoCell = document.createElement('td');
                estadoCell.innerText = item.estado;
                row.appendChild(estadoCell);

                // Añadir la fila al cuerpo de la tabla
                tableBody.appendChild(row);
            });

            // Implementar la paginación si hay más de 50 filas
            const rows = document.querySelectorAll('#facturas-table tbody tr');
            if (rows.length > 50) {
                paginateTable(rows);
            }

            // Mostrar el número de datos recibidos y líneas generadas en el contenedor de respuesta
            responseDiv.innerHTML = `<p>Se han recibido ${data.length} datos y se han generado ${rows.length} líneas.</p>`;
        })
        .catch(error => {
            console.error('Error:', error);
            responseDiv.innerHTML = '<p>Error al conectar con la API: ' + error.message + '</p>';
        });
});

// Función para manejar la selección/deselección de todos los checkboxes
document.getElementById('select-all').addEventListener('change', function () {
    const checkboxes = document.querySelectorAll('#facturas-table tbody input[type="checkbox"]');
    checkboxes.forEach(checkbox => {
        checkbox.checked = this.checked;
        const row = checkbox.closest('tr');
        if (this.checked) {
            row.classList.add('selected');
        } else {
            row.classList.remove('selected');
        }
    });
});

// Función para paginar la tabla
function paginateTable(rows) {
    const paginationDiv = document.getElementById('pagination');
    const rowsPerPage = 50;
    const pageCount = Math.ceil(rows.length / rowsPerPage);
    let currentPage = 1;

    function displayRows(page) {
        const start = (page - 1) * rowsPerPage;
        const end = start + rowsPerPage;
        rows.forEach((row, index) => {
            if (index >= start && index < end) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }

    function createPaginationButtons() {
        paginationDiv.innerHTML = '';
        for (let i = 1; i <= pageCount; i++) {
            const button = document.createElement('button');
            button.innerText = i;
            if (i === currentPage) {
                button.style.backgroundColor = 'darkgreen';
            }
            button.addEventListener('click', function () {
                currentPage = i;
                displayRows(currentPage);
                createPaginationButtons();
            });
            paginationDiv.appendChild(button);
        }
    }

    displayRows(currentPage);
    createPaginationButtons();
}

// Inicializar Pikaday con configuración en español
document.addEventListener('DOMContentLoaded', function () {
    const dateInputs = document.querySelectorAll('input[type="text"][id^="factura_fecha"]');
    dateInputs.forEach(function (input) {
        new Pikaday({
            field: input,
            format: 'DD/MM/YYYY',
            i18n: {
                previousMonth: 'Mes anterior',
                nextMonth: 'Próximo mes',
                months: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
                weekdays: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
                weekdaysShort: ['Dom', 'Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb']
            },
            firstDay: 1 // Comenzar la semana en lunes
        });
    });
});
