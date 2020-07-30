# Counter

Counter is a mobile-optimized web application used to track the amount of people that enter & exit your store.

## Features
- Real time updates on store capacity
- Multiple store support
- Page to view & generate graphs of store traffic
- Page to view current capacity of all stores simultaneously

## Installation

Counter requires PHP 7 & MySQL.

Download the zip file and extract it into the webroot of your server. Name it something neat.

Next, open up MySQL and enter the following commands to create the database:
```bash
CREATE DATABASE counter;
USE counter;
CREATE TABLE customers(
     id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
     num INT(2) NOT NULL,
     location INT(6) NOT NULL,
     time TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
```

## Usage
Employees can open up this webpage from a mobile device to track the number of people entering/exiting your store.

Customers can be logged entering/exiting the store from the main page. To access reports and view all store capacities in real time, go to [example-url.com/counter/admin](https://www.youtube.com/watch?v=dQw4w9WgXcQ)