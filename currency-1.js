document.addEventListener('DOMContentLoaded', function() {
    document.querySelector('form').onsubmit = function() {

        fetch('https://api.boffsaopendata.fi/referencerates/api/ExchangeRate?eur', {
            method: 'GET',
            // Request headers
             mode: 'no-cors',
            headers: {
                'Cache-Control': 'no-cache',
                'Ocp-Apim-Subscription-Key': 'password',}
        })
        .then(response => response.json())
        /* .then(response => {
            console.log(response.status);
            console.log(response.text()); */
        
        .then(data => {
            // Get currency from user input and convert to upper case
            const currency = document.querySelector('#Currency').Value.toUpperCase();

            // Get rate from data
            const rate = data.rates[currency];

            // Check if currency is valid:
            if (rate !== undefined) {
                // Display exchange on the screen
                document.querySelector('#result').innerHTML = `1 EUR is equal to ${rate.toFixed(3)} ${currency}.`;
            }
            else {
                // Display error on the screen
                document.querySelector('#result').innerHTML = 'Invalid Currency.';
            }
        })
        // Catch any errors and log them to the console
        .catch(err => console.error(err));}});