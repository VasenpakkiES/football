const axios = require('axios'); // commom axios import for CommonJS
const inquirer = require('inquirer'); // common inquirer import for CommonJS

// NBP API endpoint to get the latest exchange rates for table A
const NBP_API_URL = 'https://api.nbp.pl/api/exchangerates/tables/a/last/1/?format=json';

// Function to fetch exchange rates from the NBP API
async function fetchExchangeRates() {   //async function to fetch the exchange rates from the API
    try {
        const response = await axios.get(NBP_API_URL); //axios gets the data from the API
        const rates = response.data[0].rates;
        return rates;
    } catch (error) {                               //if there is an error, it will be logged and the process will exit
        console.error('Error fetching exchange rates:', error);
        process.exit(1);
    }
}

// Function to display currency options and perform the conversion
async function currencyConverter() {                //async function to fetch the exchange rates and prompt the user with the questions
    const rates = await fetchExchangeRates();
    
    const currencyOptions = rates.map(rate => ({            //map the rates to a new array of objects with name and value properties
        name: `${rate.currency} (${rate.code})`,
        value: rate.code,
    }));

    const questions = [     //array of questions to prompt the user with
        {
            type: 'list',
            name: 'fromCurrency',
            message: 'Choose the currency you want to convert from:',
            choices: currencyOptions,
        },
        {
            type: 'list',
            name: 'toCurrency',
            message: 'Choose the currency you want to convert to:',
            choices: currencyOptions,
        },
        {
            type: 'input',
            name: 'amount',
            message: 'Enter the amount to convert:',
            validate: function (value) {                                //validate the user input
                const valid = !isNaN(parseFloat(value)) && value > 0;
                return valid || 'Please enter a positive number';
            },
            filter: Number,
        },
    ];

    const { fromCurrency, toCurrency, amount } = await inquirer.prompt(questions); // use inquirer to prompt the user with the questions 

    const fromRate = rates.find(rate => rate.code === fromCurrency).mid; //find the rate of the currency the user wants to convert from
    const toRate = rates.find(rate => rate.code === toCurrency).mid; //find the rate of the currency the user wants to convert to

    const convertedAmount = (amount * fromRate) / toRate; //calculate the converted amount
    console.log(`\n${amount} ${fromCurrency} is approximately ${convertedAmount.toFixed(2)} ${toCurrency}.\n`); //log the result
}

// Start the currency converter
currencyConverter(); //call the currencyConverter function to start the process