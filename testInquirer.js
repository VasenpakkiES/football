const inquirer = require('inquirer'); // CommonJS import

async function askQuestion() {
    const answers = await inquirer.prompt([
        {
            type: 'input',
            name: 'name',
            message: 'What is your name?',
        }
    ]);

    console.log(`Hello, ${answers.name}!`);
}

askQuestion();