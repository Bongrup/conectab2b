document.getElementById('test-facturas-api').addEventListener('click', function (event) {
    event.preventDefault();

    var responseDiv = document.getElementById('facturas-api-response');
    responseDiv.innerHTML = '<p>Conectando a la API...</p>';

    fetch(facturasApiUrl, {
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
