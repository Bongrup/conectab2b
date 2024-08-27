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
            responseDiv.innerHTML = '<p>' + JSON.stringify(data) + '</p>';
        })
        .catch(error => {
            console.error('Error:', error);
            responseDiv.innerHTML = '<p>Error al conectar con la API: ' + error.message + '</p>';
        });
});

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