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

2. Import the `employee_management.sql` file to MySQL Server for XAMPP (http://localhost/phpmyadmin/index.php) to create the database and the `employees` and `users` table:

   ```sql
   CREATE DATABASE IF NOT EXISTS employee_management;
   USE employee_management;
   CREATE TABLE IF NOT EXISTS `users` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `username` VARCHAR(50) NOT NULL UNIQUE,
    `password` VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP);

    CREATE TABLE IF NOT EXISTS `employees` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `firstname` VARCHAR(50) NOT NULL,
    `lastname` VARCHAR(50) NOT NULL,
    `email` VARCHAR(100) NOT NULL,
    `phone` VARCHAR(15) NOT NULL,
    `position` VARCHAR(50) NOT NULL,
    `profile_picture` VARCHAR(255) NOT NULL);
    ENGINE=InnoDB DEFAULT CHARSET=utf8;
   ```

3. Update the `config.php` file with your database connection details.

4. Copy the folder in htdocs folder in XAMPP.

5. Start your local server and navigate to the `http://localhost/employee-management/signup.php` page to create user using the application.

6. You will be directed to `http://localhost/employee-management/index.php` page to login.

7. Now you can add, edit and delete data of emplyoees.

## Features

- User Login
- Add, Read, Update, Delete Employees
- Profile Picture Upload

## Additional Features

Any additional features or enhancements can be added here.

## Author

- Ishan Garg
