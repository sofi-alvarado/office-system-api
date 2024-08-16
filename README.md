# Office System API

A PHP-based REST API for managing users, employees, and roles in an office management system.

The API is deployed on DigitalOcean and accessible at:

URL: https://office-management.nubitlan.com

Hosting Provider: DigitalOcean


## Table of Contents

- [Features](#features)
- [Technologies](#technologies)
- [Setup](#setup)
- [API Endpoints](#api-endpoints)
- [Database](#database)

## Features

- JWT-based user authentication
- Role-based access control (Admin/User)
- CRUD operations for employees and users
- MySQL database integration

## Technologies

- **Backend**: PHP
- **Database**: MySQL
- **Authentication**: JWT (JSON Web Token)
- **Other**: Composer for dependency management

## Setup

### Prerequisites

- PHP (>= 7.x)
- MySQL
- Composer

### Installation

 Clone the repository:
   ```bash
   git clone https://github.com/sofi-alvarado/office-system-api.git

```
```bash
   cd office-system-api
```
Install dependencies

```bash
  composer install
```

Set up environment variables:
Create a .env file in the root of your project and configure the following:

```bash
   DB_HOST=your-database-host
   DB_PORT=your-database-port
   DB_NAME=office_system
   DB_USER=your-database-username
   DB_PASS=your-database-password
   SECRET_SECRET=your-jwt-secret-key
```

## API Endpoints
**Authentication**

- **POST**  ?action=authenticate: Authenticate a user and receive a JWT token.

**Users**

- **POST** ?action=createUser: Create a new user.

**Employees**

- **GET** action=getEmployees: Get all employees.
- **POST** '?action=createEmployee', employeeData: Add a new employee.
- **PUT** ?action=updateEmployee&id=${employeeId}: Update employee details.
- **DELETE** ?action=deleteEmployee&id=${employeeId}: Delete an employee.

## Database
Create the office_system database and tables using the following SQL script:

```bash
-- CREATE DATABASE `office_system`

CREATE TABLE `employees` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `lastname` varchar(100) NOT NULL,
  `genre` varchar(10) NOT NULL,
  `employment_area` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
);

CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user` varchar(100) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
);

```
