# NBP Exchange Rates app

This is a simple web application that allows users to convert currencies using exchange rates retrieved from an external API (NBP). The application is built using PHP and follows the MVC (Model-View-Controller) architectural pattern.

## Features

* **Current exchange rates**: The application fetches the latest exchange rates from an external API (NBP) and stores them in a local database. These exchange rates are also used for currency conversion.
* **Currency conversion**: Users can enter an amount, select a source currency and a target currency, and the application will calculate the converted amount based on the exchange rates.
* **Conversion results**: The application keeps a record of the latest conversion results, allowing users to view their conversion history.

## Installation

To run the NBP Exchange Rates app, follow these steps:

1. Clone the repository to your local machine.
2. Set up a web server (e.g., Apache) and configure it to serve the application's files.
3. Create a MySQL database.
4. Update the database connection settings in the *database.php* file located in the *config* directory.
5. Open console and run *run_migrations.php* file to set up the required tables.
6. Access the application through the configured web server.

## Usage

* **Home page**: Upon accessing the application, you will see the home page with a navigation menu and a welcome message.
* **Current exchange rates**: Click on this link in the navigation menu to view the current exchange rates. Before displaying data, the application will retrieve them from the external API and store them in the database.
* **Convert currency**: Click on this link in the navigation menu to access the currency conversion form. Select the source currency, target currency, and enter the amount to convert. Submit the form, and the converted amount will be displayed. The application will also add your currency conversion to the database.
* **Latest conversion results**: Click on this link in the navigation menu to view the latest currency conversion results retrieved from the database.
* **Language swtiches**: You can view the application in English or in Polish and switch between these languages anytime.

## Dependencies

The NBP Exchange Rates app uses the following dependencies:

* PHP: The application is written in PHP 8.2.0.
* MySQL: The application uses a MySQL database to store exchange rates and conversion results.
