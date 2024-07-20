# Employee Management Web Application

## Description

This is a simple web application for managing a list of employees, allowing the user to perform CRUD (Create, Read, Update, Delete) operations, manage user sessions for login functionality, and upload profile pictures for employees.

## Technologies Used

- Frontend: HTML, CSS, JavaScript (jQuery), Bootstrap
- Backend: PHP
- Database: MySQL

## Setup Instructions

1. Clone the repository:

   ```bash
   git clone https://github.com/yourusername/employee-management.git
   ```

2. Import the `employee_management.sql` file to create the database and the `employees` table:

   ```sql
   CREATE DATABASE IF NOT EXISTS employee_management;
   USE employee_management;
   CREATE TABLE `employees` (
     `id` int(11) NOT NULL AUTO_INCREMENT,
     `firstname` varchar(50) NOT NULL,
     `lastname` varchar(50) NOT NULL,
     `email` varchar(100) NOT NULL,
     `phone` varchar(15) NOT NULL,
     `position` varchar(50) NOT NULL,
     `profile_picture` varchar(255) NOT NULL,
     PRIMARY KEY (`id`)
   ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
   ```

3. Update the `config.php` file with your database connection details.

4. Start your local server and navigate to the `login.php` page to start using the application.

## Features

- User Login
- Add, Read, Update, Delete Employees
- Profile Picture Upload

## Additional Features

Any additional features or enhancements can be added here.

## Author

- Ishan Garg
