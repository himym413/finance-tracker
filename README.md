# Personal Finance Tracker

A personal finance management application built with **vanilla PHP** following MVC principles.

This project was created as a learning exercise before moving to Laravel. Instead of relying on a framework, the goal was to understand how common backend concepts work under the hood by implementing them from scratch.

## Features

- User registration and authentication
- Secure password hashing
- Session-based authentication
- Route protection for guests and authenticated users
- CSRF protection
- Create, edit and delete transactions
- Personal dashboard with income, expenses and balance overview
- Search, filtering and sorting
- Pagination
- Flash messages
- Custom error pages (404, 419 and 500)
- Responsive interface built with Tailwind CSS

## Built With

- PHP 8
- MySQL
- PDO
- Composer
- Tailwind CSS
- HyperUI
- Laragon
- Git & GitHub

## Project Structure

```
app/
├── Controllers
├── Core
├── Database
├── Repositories
└── Validation

config/
public/
resources/
routes/
```

## Installation

Clone the repository:

```bash
git clone https://github.com/himym413/finance-tracker.git
```

Install dependencies:

```bash
composer install
```

Create a MySQL database and configure your credentials inside:

```
config/database.php
```

Start your local server and open:

```
http://localhost/finance-tracker/public
```

## Security

The application includes several common security practices:

- Password hashing using `password_hash()`
- Password verification using `password_verify()`
- Session regeneration after login
- CSRF protection on all POST requests
- Route authorization
- User ownership checks for transactions
- Escaped output using `htmlspecialchars()`

## What I Learned

This project helped me understand how modern PHP frameworks work internally by implementing many of their core features manually, including:

- Routing
- Dependency Injection
- MVC architecture
- Repository pattern
- Form validation
- Authentication
- Authorization
- Sessions
- CRUD operations
- Pagination
- Error handling
- Git workflow

## Future Improvements

- Remember me
- Password reset
- User profile
- Charts and analytics
- Export transactions
- REST API

## License

This project was created for educational purposes.
