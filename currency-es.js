document.addEventListener('DOMContentLoaded', function() {
    document.querySelector('form').onsubmit = function() {
        // Put response into json form
        fetch('https://api.boffsaopendata.fi/referencerates/api/ExchangeRate', {
            method: 'GET',
            // Request headers
            headers: {
                'Cache-Control': 'no-cache',}
        })
        .then(response => {
            console.log(response.status);
            console.log(response.text());
        })
        .catch(err => console.error(err));
    }});