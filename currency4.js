{
    "openapi": "3.0.1",
    "info": {
        "title": "Reference Rates",
        "description": "The exchange rates are euro reference rates published by the European central bank. The reference rates are published daily at about 5 PM Finnish time, when the TARGET system is open. The reference rates are published for the information of the public and different institutions but not as a basis for trade.",
        "version": ""
    },
    "servers": [
        {
            "url": "https://api.boffsaopendata.fi/referencerates"
        }
    ],
    "paths": {
        "/api/ExchangeRate": {
            "get": {
                "tags": [
                    "ExchangeRate"
                ],
                "summary": "Get exchange rates.",
                "description": "Get exchange rates.",
                "operationId": "ExchangeRate_Get",
                "parameters": [
                    {
                        "name": "type",
                        "in": "query",
                        "description": "",
                        "schema": {
                            "type": "string"
                        }
                    },
                    {
                        "name": "startDate",
                        "in": "query",
                        "description": "",
                        "schema": {
                            "type": "string"
                        }
                    },
                    {
                        "name": "endDate",
                        "in": "query",
                        "description": "",
                        "schema": {
                            "type": "string"
                        }
                    },
                    {
                        "name": "currencies",
                        "in": "query",
                        "description": "Currencies to return (e.g. \"GBP,JPY,SEK\"). Leave empty to return all.",
                        "schema": {
                            "type": "string"
                        }
                    },
                    {
                        "name": "includeNonECBPublCur",
                        "in": "query",
                        "description": "",
                        "schema": {
                            "type": "boolean"
                        }
                    },
                    {
                        "name": "asXml",
                        "in": "query",
                        "description": "True = Return results as xml. False = return results as json.",
                        "schema": {
                            "type": "boolean"
                        }
                    }
                ],
                "responses": {
                    "200": {
                        "description": "OK",
                        "content": {
                            "application/json": {
                                "schema": {
                                    "$ref": "#/components/schemas/ExchangeRateInfoArray"
                                },
                                "example": [
                                    {
                                        "ExchangeRates": [
                                            {
                                                "ObservationDate": "string",
                                                "Value": 0
                                            }
                                        ],
                                        "Currency": "string",
                                        "CurrencyDenom": "string",
                                        "CurrencyNameFi": "string",
                                        "CurrencyNameSe": "string",
                                        "CurrencyNameEn": "string",
                                        "ECBPublished": "string"
                                    }
                                ]
                            },
                            "text/json": {
                                "schema": {
                                    "$ref": "#/components/schemas/ExchangeRateInfoArray"
                                },
                                "example": [
                                    {
                                        "ExchangeRates": [
                                            {
                                                "ObservationDate": "string",
                                                "Value": 0
                                            }
                                        ],
                                        "Currency": "string",
                                        "CurrencyDenom": "string",
                                        "CurrencyNameFi": "string",
                                        "CurrencyNameSe": "string",
                                        "CurrencyNameEn": "string",
                                        "ECBPublished": "string"
                                    }
                                ]
                            },
                            "text/html": {
                                "schema": {
                                    "$ref": "#/components/schemas/ExchangeRateInfoArray"
                                },
                                "example": "<ExchangeRateInfoArray> <ExchangeRates> <ObservationDate>string</ObservationDate> <Value>0</Value> </ExchangeRates> <Currency>string</Currency> <CurrencyDenom>string</CurrencyDenom> <CurrencyNameFi>string</CurrencyNameFi> <CurrencyNameSe>string</CurrencyNameSe> <CurrencyNameEn>string</CurrencyNameEn> <ECBPublished>string</ECBPublished> </ExchangeRateInfoArray>"
                            },
                            "application/xml": {
                                "schema": {
                                    "$ref": "#/components/schemas/ExchangeRateInfoArray"
                                },
                                "example": "<ExchangeRateInfoArray> <ExchangeRates> <ObservationDate>string</ObservationDate> <Value>0</Value> </ExchangeRates> <Currency>string</Currency> <CurrencyDenom>string</CurrencyDenom> <CurrencyNameFi>string</CurrencyNameFi> <CurrencyNameSe>string</CurrencyNameSe> <CurrencyNameEn>string</CurrencyNameEn> <ECBPublished>string</ECBPublished> </ExchangeRateInfoArray>"
                            },
                            "text/xml": {
                                "schema": {
                                    "$ref": "#/components/schemas/ExchangeRateInfoArray"
                                },
                                "example": "<ExchangeRateInfoArray> <ExchangeRates> <ObservationDate>string</ObservationDate> <Value>0</Value> </ExchangeRates> <Currency>string</Currency> <CurrencyDenom>string</CurrencyDenom> <CurrencyNameFi>string</CurrencyNameFi> <CurrencyNameSe>string</CurrencyNameSe> <CurrencyNameEn>string</CurrencyNameEn> <ECBPublished>string</ECBPublished> </ExchangeRateInfoArray>"
                            }
                        }
                    },
                    "404": {
                        "description": "NotFound",
                        "content": {
                            "application/json": {
                                "schema": {
                                    "$ref": "#/components/schemas/ApiExchangeRateGet404ApplicationJsonResponse"
                                },
                                "example": "string"
                            },
                            "text/json": {
                                "schema": {
                                    "$ref": "#/components/schemas/ApiExchangeRateGet404TextJsonResponse"
                                },
                                "example": "string"
                            },
                            "text/html": {
                                "schema": {
                                    "$ref": "#/components/schemas/ApiExchangeRateGet404TextHtmlResponse"
                                },
                                "example": "<ApiExchangeRateGet404TextHtmlResponse>string</ApiExchangeRateGet404TextHtmlResponse>"
                            },
                            "application/xml": {
                                "schema": {
                                    "$ref": "#/components/schemas/ApiExchangeRateGet404ApplicationXmlResponse"
                                },
                                "example": "<ApiExchangeRateGet404ApplicationXmlResponse>string</ApiExchangeRateGet404ApplicationXmlResponse>"
                            },
                            "text/xml": {
                                "schema": {
                                    "$ref": "#/components/schemas/ApiExchangeRateGet404TextXmlResponse"
                                },
                                "example": "<ApiExchangeRateGet404TextXmlResponse>string</ApiExchangeRateGet404TextXmlResponse>"
                            }
                        }
                    }
                }
            }
        }
    },
    "components": {
        "schemas": {
            "ExchangeRateInfo": {
                "type": "object",
                "properties": {
                    "ExchangeRates": {
                        "type": "array",
                        "items": {
                            "$ref": "#/components/schemas/ObservationRate"
                        }
                    },
                    "Currency": {
                        "type": "string"
                    },
                    "CurrencyDenom": {
                        "type": "string"
                    },
                    "CurrencyNameFi": {
                        "type": "string"
                    },
                    "CurrencyNameSe": {
                        "type": "string"
                    },
                    "CurrencyNameEn": {
                        "type": "string"
                    },
                    "ECBPublished": {
                        "type": "string"
                    }
                }
            },
            "ObservationRate": {
                "type": "object",
                "properties": {
                    "ObservationDate": {
                        "type": "string"
                    },
                    "Value": {
                        "type": "number",
                        "format": "double"
                    }
                }
            },
            "ExchangeRateInfoArray": {
                "type": "array",
                "items": {
                    "$ref": "#/components/schemas/ExchangeRateInfo"
                }
            },
            "ApiExchangeRateGet404ApplicationJsonResponse": {
                "type": "string"
            },
            "ApiExchangeRateGet404TextJsonResponse": {
                "type": "string"
            },
            "ApiExchangeRateGet404TextHtmlResponse": {
                "type": "string"
            },
            "ApiExchangeRateGet404ApplicationXmlResponse": {
                "type": "string"
            },
            "ApiExchangeRateGet404TextXmlResponse": {
                "type": "string"
            }
        }
    }
}


document.addEventListener('DOMContentLoaded', function() {
    document.querySelector('form').onsubmit = function() {

        // Send a GET request to the URL
        fetch('https://api.exchangeratesapi.io/latest?base=USD')
              // Put response into json form
        .then(response => response.json())
        .then(data => {
            // Get currency from user input and convert to upper case
            const currency = document.querySelector('#currency').value.toUpperCase();

            // Get rate from data
            const rate = data.rates[currency];

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