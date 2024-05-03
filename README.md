# Laravel Project Setup

### Pre-requisites

Before you begin the installation process, make sure you have the following software installed in your machine:

1. **PHP**: System Requires PHP 8.3 or higher.
2. **Composer**: A PHP dependency management tool. Install latest version from [https://getcomposer.org/download/](https://getcomposer.org/download/).
3. **MySQL**: A relational database management system. You'll need a running MySQL server.
4. **Node.js**: Required for asset compilation, Version 18.17.1 or higher
5. **npm**: Node.js package manager, Version 9.8.1 or higher

### Installation Steps

### Commands
- This commands will only be used if the artisan command that you will execute will have something to do with the database.
- To Run artisan commands
    ```
    php artisan
    ```
- To Create controller 
    ```
    php artisan make:controller
    ```
- To Create model
    ```
    php artisan make:model
    ```
- To Create migrations run
    ```bash
    php artisan make:migration create_merchants_table
    ```
- To Run Migrations run 
    ```bash
    php artisan migrate
    ```
- To Run Seeder
    ```bash
    php artisan db:seed
    ```

- To run Composer
    ```bash
    composer install

    # or 

    composer update

    # or

    composer require <dependency>

    #

    composer dump-autoload
    ```

- To run Application
    ```bash
    php artisan serve

    #or

    php artisan serve --port=5001
    ```
    

### To connect to the database
- Open your Database Management Application
    - **Host**: localhost
    - **Port**: 3306
    - **Username**: root
    - **Password**: root 
- Once connected add this databases
    - **<db_name>**: This is the database that the local application will use

