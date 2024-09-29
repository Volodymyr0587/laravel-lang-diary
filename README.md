# Language Diary App

## Overview

The Language Diary App is a web application built using Laravel that allows users to create, view, and manage words and their translations in multiple languages. Authenticated users can add new words, provide translations in various languages, and view all translations for a word.

## Features

- Authenticate with a Google account or email and password.
- Language Management: Create, view, and manage languages.
- Word Management: Create, view, and manage words.
- Phrase Management: Create, view, and manage phrases.
- Translation Management: Add translations for words and phrases in different languages.
- Language Selection: Choose from available languages for translations.
- Pagination: Words are paginated for easier navigation.
- Authenticated Actions: Only authenticated users can manage words and translations.

## Installation

### Prerequisites

Before you begin, ensure you have the following installed on your machine:

- PHP >= 8.2
- Composer
- Node.js and npm
- Laravel
- A database (MySQL, PostgreSQL, etc.)

### Steps

1. Clone the repository

    ```sh
    git clone https://github.com/Volodymyr0587/laravel-lang-diary
    cd laravel-lang-diary
    ```

2. Install dependencies

    ```sh
    composer install
    npm install
    ```

3. Set up environment variables

    ```sh
    cp .env.example .env
    ```

    Update the `.env` file with your database credentials and other necessary configurations.

4. Generate Application Key

    ```sh
    php artisan key:generate
    ```

5. Run Migrations and Seeders

    Set up the database by running migrations and seeders:

    ```sh
    php artisan migrate --seed
    ```

6. Link Storage

    Create a symbolic link from `public/storage` to `storage/app/public`:

    ```sh
    php artisan storage:link
    ```

7. Build Assets

    Build the frontend assets:

    ```sh
    npm run dev
    ```

8. Serve the Application

    ```sh
    php artisan serve
    ```

    The application should now be running at http://localhost:8000.

### Usage

**Authentication**

Register a new user or log in with existing credentials. Only authenticated users can create, view, and manage words, phrases and translations.

**Word Management**

- **Create a Word:** Navigate to the "Create Word" page, fill out the form, and submit.
- **View Words:** Browse through the list of words on the homepage.

**Translation Management**

- **Add Translation:** On the word details page, add translations in various languages.
- **View Translations:** View all translations for a word on its details page.

### Additional Notes

Use the `.env` file to configure the application settings, such as the database connection and other environment-specific configurations.

## License

This project is licensed under the MIT License.
