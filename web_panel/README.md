# Running Symfony Website Locally

## Prerequisites

Before you start, ensure you have the following installed on your machine:

- PHP (version 7.4 or higher)
- Composer

## Installation

1. Clone the repository of your Symfony website:
   ```bash
   git clone https://github.com/your_username/your_project.git
   cd your_project

2. Install dependencies using Composer:
    ```bash
    composer install

3. Starting the PHP Built-in Web Server
To run the Symfony website locally, you can use the PHP built-in web server.
Navigate to the root directory of your Symfony project in the terminal, and run the following command:
    ```bash
    php -S localhost:8000 -t public

This command starts the PHP built-in web server and sets the document root to the public directory of your Symfony project.

Accessing the Website
Once the server is running, you can access your Symfony website in a web browser by visiting:

    http://localhost:8000