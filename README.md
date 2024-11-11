# Indenting House CRM

This Laravel-based application serves as a CRM system, featuring comprehensive client, invoicing, and payment management functionalities. It is designed to enhance customer relationship handling through structured data management and personalized communications.

## Features

-   **Customer and Invoice Management**: Tracks customer details, invoices, and payments through structured database tables.
-   **Role-Based Access Control**: Supports multiple user roles with permissions for viewing, creating, updating, and deleting records.
-   **Dynamic Navigation**: Uses dynamic relationships to customize navigation based on user roles.
-   **Cross-Platform Compatibility**: Integration with React Native WebView for seamless mobile access.

## Prerequisites

-   PHP >= 8.x
-   Composer
-   MySQL or other supported database
-   Node.js & NPM

## Installation

1. Clone the repository:

    ```bash
    git clone https://github.com/Usman-Khan11/indenting-house-crm.git
    ```

2. Navigate to the project folder:

    ```bash
    cd indenting-house-crm
    ```

3. Install dependencies:

    ```bash
    composer install
    npm install && npm run dev
    ```

4. Copy the `.env.example` file to `.env`:

    ```bash
    cp .env.example .env
    ```

5. Generate the application key:

    ```bash
    php artisan key:generate
    ```

6. Configure the `.env` file with your database credentials and other settings.

7. Run migrations to set up the database:

    ```bash
    php artisan migrate
    ```

8. Seed the database (optional):

    ```bash
    php artisan db:seed
    ```

9. Start the development server:
    ```bash
    php artisan serve
    ```

## Contributing

Feel free to contribute to this project by submitting pull requests or reporting issues.

## License

This project is licensed under the MIT License.
