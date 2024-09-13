document.addEventListener('DOMContentLoaded', function() {
    document.querySelector('form').onsubmit = function() {

        const request = new Request(`https://api.nbp.pl/api/exchangerates/rates/a/sek/?format=json`, {
            method: "GET",
          });
        
          fetch(request)
          .then(payload => payload.json())
        .then(data => {
            console.log(`Exchange Rates Table A ${JSON.stringify(data)}`);
        })
          .catch(error => {
            console.log(`Virhe noudettaessa tietoa: ${error}`);  
          })

  const currency = document.querySelector('#currency').value.toUpperCase();

  // Get rate from data
  const rate = data.mid[currency];

  // Check if currency is valid:
  if (rate !== undefined) {
      // Display exchange on the screen
      document.querySelector('#result').innerHTML = `1 USD is equal to ${rate.toFixed(3)} ${currency}.`;
  }
  else {
      // Display error on the screen
      document.querySelector('#result').innerHTML = 'Invalid Currency.';
  }
}
// Catch any errors and log them to the console
/*.catch(error => {
  console.log('Error:', error);
});*/
// Prevent default submission
/*return false;*/
});