# Jobseeker Back-End API

Made for Jobseeker.Company Back-End Engineer Assessment Test

## Requirements

-   PHP 8.1
-   Laravel 10
-   MySQL
-   MongoDB

## Installation

1.  **Clone the repository:**

    ```bash
    git clone https://github.com/farfnd/jobseeker-backend
    ```

2.  **Install Composer Dependencies:**

    ```bash
    composer install
    ```

3.  **Create a `.env` File:**

    Duplicate the `.env.example` file and rename it to `.env`.

4.  **Create a database:**

    Create a new MySQL database and update the necessary database credential configurations in the `.env` file.

    ```
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=laravel
    DB_USERNAME=root
    DB_PASSWORD=
    ```

    For data migration purposes, also create a new MongoDB database and update the URL (connection string) and database name variable in the `.env` file.

    ```
    MONGO_DB_URL=
    MONGO_DB_DATABASE=
    ```

5.  **Insert RajaOngkir API key:**

    The province and city data fetching command uses RajaOngkir API as the data source. For this purpose, complete the `RAJAONGKIR_API_KEY` variable in the `.env` file with your API key. You can use the key already provided in the `.env.example` file (also shown below).

    ```
    RAJAONGKIR_API_URL=https://api.rajaongkir.com/starter
    RAJAONGKIR_API_KEY=e270c1d140ea39f7c0e962d9aa278530
    ```

6.  **Install MongoDB PHP Extension:**

    -   For data migration purposes, install the MongoDB PHP extension for PHP 8.1 from [this page](https://github.com/mongodb/mongo-php-driver/releases) (for my case, the [64-bit thread-safe version](https://github.com/mongodb/mongo-php-driver/releases/download/1.17.2/php_mongodb-1.17.2-8.1-ts-x64.zip) is the compatible one).
    -   After finishing downloading the file, extract and place the `php_mongodb.dll` file in the `ext` folder of your PHP installation folder (for example, `C:\laragon\bin\php\php-8.1.4-Win32-vs16-x64\ext`).
    -   Add the following line to your `php.ini` file:

        ```
        extension=mongodb.so
        ```

7.  **Generate an Application Key:**

    ```bash
    php artisan key:generate
    ```

8.  **Run Database Migrations:**

    ```bash
    php artisan migrate
    ```

9.  **Start the Development Server:**

    ```bash
    php artisan serve
    ```

    By default, the application will be available at `http://localhost:8000`.

## Usage

-   Access the application in your web browser at `http://localhost:8000`.
-   Use the provided functionalities according to the application's features.

## Features

-   Store provinces & cities data from RajaOngkir API to the database by running the following command:

    ```
    php artisan fetch:provinces
    php artisan fetch:cities
    ```

    The province data must be fetched before the city data, as city data is dependent to the province data through `province_id` foreign key. This behavior can be modified by removing the foreign key constraint in the `cities` table migration.

    By default, these commands will be run automatically when seeding the database.

-   API endpoints for user authentication (login, logout, user information), and CRUD for education and experience data. Please access [the API documentation](https://documenter.getpostman.com/view/16740385/2s9YsDjETo) for complete details.

-   Data migration from SQL database (default is MySQL) to MongoDB by running the command below.

    -   Migrate all tables:
        ```bash
        php artisan app:migrate-data-to-mongo
        ```
    -   Migrate a specific table:
        ```bash
        php artisan app:migrate-data-to-mongo table_name
        ```

-   Feature tests for the API endpoints.

## Testing

1. **Run PHPUnit Tests:**

    ```bash
    php artisan test
    ```

    This command will run all the tests in the `tests` directory and wipe out all the data stored in the database before running the tests.
