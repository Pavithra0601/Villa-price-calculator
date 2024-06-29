# Property Price Calculator

A web-based application to calculate the price of various properties, specifically villas, based on location, project, villa type, plot area, and built-up area.

## Table of Contents

- [Description](#description)
- [Installation](#installation)
- [Usage](#usage)
- [Files](#files)
- [Contributing](#contributing)
- [License](#license)
- [Contact](#contact)

## Description

This project is a web application that allows users to calculate the price of a villa based on specific details such as location, project name, villa type, plot area, and built-up area. The application is built using HTML, CSS, JavaScript, PHP, and Bootstrap for styling.

## Installation

To set up the project locally, follow these steps:

1. Clone the repository:

2. Ensure you have a web server with PHP support (e.g., XAMPP, WAMP, LAMP).

3. Place the project files in the web server's root directory.

4. Create a database and import the provided SQL file to set up the necessary tables and data.

5. Update the `db_connection.php` file with your database credentials.

6. Open your web browser and navigate to `http://localhost/property-price-calculator`.

## Usage

1. Open the application in your web browser.
2. Select the project location from the dropdown menu.
3. Choose the project name (populated based on the selected location).
4. Select the villa type (1BHK, 2BHK, or 3BHK).
5. Enter the plot area and built-up area.
6. Click the "Calculate Cost" button to get the price.
