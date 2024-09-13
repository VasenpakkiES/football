document.addEventListener('DOMContentLoaded', function() {
    document.querySelector('form').onsubmit = function() {
        fetch('https://api.boffsaopendata.fi/referencerates/api/ExchangeRate', {
            method: 'GET',
            // Request headers
            headers: {
                'Cache-Control': 'no-cache',
                'Ocp-Apim-Subscription-Key': 'password',}
        })
        /* Send a GET request to the URL
       fetch('https://api.boffsaopendata.fi/referencerates/api/ExchangeRate?eur', {
        method: 'GET',
        // Request headers
        headers: {
            'Cache-Control': 'no-cache',
            'Ocp-Apim-Subscription-Key': '',}
    }) */
        // Put response into json form
        .then(response => response.json())
        .then(data => {
            // Get currency from user input and convert to upper case
            const currency = document.querySelector('#Currency').value.toUpperCase();

            // Get rate from data
            const rate = data.Value[currency];

            // Check if currency is valid:
            if (rate !== undefined) {
                // Display exchange on the screen
                document.querySelector('#result').innerHTML = `1 USD is equal to ${rate.toFixed(3)} ${currency}.`;
            }
            else {
                // Display error on the screen
                document.querySelector('#result').innerHTML = 'Invalid Currency.';
            }
        })
        // Catch any errors and log them to the console
        .catch(error => {
            console.log('Error:', error);
        });
        // Prevent default submission
        return false;
    }
});
