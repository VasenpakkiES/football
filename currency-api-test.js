document.addEventListener('DOMContentLoaded', function() {
    document.querySelector('form').onsubmit = function() {
      
        var myHeaders = new Headers();
        myHeaders.append("apikey", "h1jbhi9qo1ztK6KzIS9aJGrYUCT6nI23");

        var requestOptions = {
            method: 'GET',
            redirect: 'follow',
            headers: myHeaders
        };

        const request = new Request(`https://api.nbp.pl/api/exchangerates/rates/a/sek/?format=json`, {
            method: "GET",
          });
          fetch(request)
          .then(payload => payload.text())
          .then(data => {
            console.log(` ${JSON.stringify(data)}`);
          })
        

        fetch("https://api.apilayer.com/exchangerates_data/latest?symbols=&base=EUR", requestOptions)
            .then(response => response.text())
            .then(result => console.log(result))
            .then(data => {
                // Get currency from user input and convert to upper case
                const currency = document.querySelector('#currency').value.toUpperCase();

                // Get rate from data
                const rate = data.rates[currency];

                // Check if currency is valid:
                if (rate !== undefined) {
                    // Display exchange on the screen
                    document.querySelector('#result').innerHTML = `1 EUR is equal to ${rate.toFixed(3)} ${currency}.`;
                } else {
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
