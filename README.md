# **TSB Car Share Scheme**
## PP-1-S2-2021-FRI1030PM-Group1

## About
This program was made by RMIT students for a Further Programming Capstone project, and is based on a car sharing app like Go-Get

The contributors were:
- Sulaiman Dayoub
- Taylor Franklin
- Cass Ilangantileke
- Luke Kampen
- Michael Vella

### Frameworks
The frameworks and APIs that we used were:

- MySQL for database management
- Stripe for payments
- PHPMailer for emails
- Google Maps for map functions
- Composer for controlling libraries

## Accessing the _Online Version_
The TSB Car Share Scheme web-application can be accessed from [this website](https://tsb-carshare.herokuapp.com/)


## Running TSB on a _Local Machine_
In order to run the program on a local machine, a user will need to download and use XAMPP, download composer and add:
```
{
    
    "require": {
        "phpmailer/phpmailer": "^6.5",
        "stripe/stripe-php": "^7.97"
    }
}
```
to the composer.json file, and run the command
```
composer update
```
The user will also need to add a carshare databse into their PHPMyAdmin when XAMPP is running, and change into development variables, which are found in
```
model/coordinates.php
model/database.php
payment/stripe.php
```
and update them to the correct local variables and URLs

## Use
In order to use the program, the user needs to be logged in, with either a pre-existing account or by creating one, and then by clicking on the relevant headings in order to achieve the desired outcome.
