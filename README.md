# Resto App

A restaurant reservation application built with Laravel.

## Features

- User registration & authentication
- Browse restaurants and menus
- Make, view, and manage reservations
- Admin dashboard for managing restaurants, tables, and bookings
- Email notifications for reservations

## Installation

1. Clone the repository:
    ```bash
    git clone https://github.com/ahmedaq20/resto-app.git
    cd resto-app
    ```

2. Install dependencies:
    ```bash
    composer install
    npm install && npm run dev
    ```

3. Configure environment:
    - Copy `.env.example` to `.env`
    - Set your database credentials

4. Run migrations and seeders:
    ```bash
    php artisan migrate --seed
    ```

5. Start the development server:
    ```bash
    php artisan serve
    ```

## Usage

- Register as a user to make reservations.
- Admins can manage restaurants, tables, and view all bookings.

## License

MIT
