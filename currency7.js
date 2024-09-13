document.addEventListener('DOMContentLoaded', function() {
    document.querySelector('form').onsubmit = function() {

        const url = 'https://api.apilayer.com/exchangerates_data/latest?' + params;
          
        fetch(url,requestOptions)
        .then(response => response.json())
        .then(data => {
            // Get currency from user input and convert to upper case
            const currency = document.querySelector('#currency').value.toUpperCase();
            console.log("rates,NOK:",data.rates['NOK']);
            /* check undefined, raise error if undefined */
            if (typeof data.rates == 'undefined') {
                throw new Error('Undefined rates');
                }
            let valuutat = Object.entries(data.rates);
            console.log("valuutat:",valuutat);

            /* TEHTÄVÄ: Listaa valuuttakurssit ul elementtiin result
            Object.entries(obj).forEach(([key, value]) => ..
            */
           
            if (valuutat.length > 0) {
                let list = document.createElement('ul');
                list.style.listStyleType = "none";
                list.style.paddingLeft = "0px";

                /* Display list of currencies on the screen, huom.
                   myös data.rates toimisi suoraan. */
                valuutat.forEach(currency => {
                    let listItem = document.createElement('li');
                    listItem.innerHTML = `${currency[0]} ${currency[1]}`;
                    console.log("listItem:",listItem);
                    list.appendChild(listItem);
                    })

                result.innerHTML = "List of currencies:";
                result.appendChild(list);    
                }

            else {
                // Get rate from data
                const rate = data.rates[currency];

                // Check if currency is valid:
                if (rate !== undefined) {
                // Get number of rates in data.rates object
                                  
                // Display exchange on the screen
                document.querySelector('#result').innerHTML = `1 EURO is equal to ${rate.toFixed(3)} ${currency}.`;
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






const url = 'https://api.apilayer.com/exchangerates_data/latest?' + params;
          
        fetch(url,requestOptions)
        .then(response => response.json())
        .then(data => {
            // Get currency from user input and convert to upper case
            const currency = document.querySelector('#currency').value.toUpperCase();
            console.log("rates,NOK:",data.rates['NOK']);
            /* check undefined, raise error if undefined */
            if (typeof data.rates == 'undefined') {
                throw new Error('Undefined rates');
                }
            let valuutat = Object.entries(data.rates);
            console.log("valuutat:",valuutat);

            /* TEHTÄVÄ: Listaa valuuttakurssit ul elementtiin result
            Object.entries(obj).forEach(([key, value]) => ..
            */
           
            if (valuutat.length > 0) {
                let list = document.createElement('ul');
                list.style.listStyleType = "none";
                list.style.paddingLeft = "0px";

                /* Display list of currencies on the screen, huom.
                   myös data.rates toimisi suoraan. */
                valuutat.forEach(currency => {
                    let listItem = document.createElement('li');
                    listItem.innerHTML = `${currency[0]} ${currency[1]}`;
                    console.log("listItem:",listItem);
                    list.appendChild(listItem);
                    })

                result.innerHTML = "List of currencies:";
                result.appendChild(list);    
                }

            else {
                // Get rate from data
                const rate = data.rates[currency];

                // Check if currency is valid:
                if (rate !== undefined) {
                // Get number of rates in data.rates object
                                  
                    // Display exchange on the screen
                    document.querySelector('#result').innerHTML = `1 ${dataObj.base} is equal to ${rate.toFixed(3)} ${currency}.`;
                    }

                else {
                    // Display error on the screen
                    document.querySelector('#result').innerHTML = 'Invalid Currency.';
                    }
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