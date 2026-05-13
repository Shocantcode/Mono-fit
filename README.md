# MonoFit - Fitness & Wellness Application

A comprehensive fitness tracking and workout management application built with Laravel. MonoFit helps users achieve their fitness goals through workout planning, nutrition tracking, progress monitoring, and personalized reminders.

## Author
| Nama                        | GitHub                                        |
| --------------------------- | --------------------------------------------- |
| Kenzie Rolland Gracia       | [Shocantcode](https://github.com/Shocantcode) |
| Nicholas Febrian Maladi     | [nicfebma](https://github.com/nicfebma)       |
| Maulana Isabril Hafidz      | [maulhafidz](https://github.com/maulhafidz)   |
| Reyven Theo Bastian Pribadi | [mowakino](https://github.com/mowakino)       |
| Ryan Setiadi                | [Insuxed](https://github.com/Ins)             |

## Features

### 🏋️ Workout Management
- Create and manage personalized workout routines
- Track exercises with detailed sets and reps
- View and schedule workouts

### 🥗 Nutrition Tracking
- Log daily nutrition intake
- Monitor nutritional values and goals
- Track calorie consumption

### 📊 Progress Tracking
- Monitor fitness progress over time
- Track body metrics and performance improvements
- Visual progress dashboards

### ⏰ Reminders & Notifications
- Set personalized workout reminders
- Schedule nutrition check-ins
- Stay on top of fitness goals

### 👤 User Management
- Secure authentication and authorization
- User profiles and settings
- Personalized user experience

### 🎯 Onboarding
- Guided setup for new users
- Initial fitness assessment
- Goal setting during onboarding

## Tech Stack

- **Backend**: Laravel (PHP)
- **Frontend**: Blade templating, Tailwind CSS
- **Database**: MySQL/SQLite
- **Build Tool**: Vite
- **Package Management**: Composer, npm

## Requirements

- PHP 8.1+
- Composer
- Node.js & npm
- SQLite or MySQL database

## Installation

### 1. Clone the repository
```bash
git clone <repository-url>
cd MonoFit
```

### 2. Install PHP dependencies
```bash
composer install
```

### 3. Install JavaScript dependencies
```bash
npm install
```

### 4. Environment setup
```bash
cp .env.example .env
php artisan key:generate
```

Update your `.env` file with database credentials and other configuration settings.

### 5. Database setup
```bash
php artisan migrate
php artisan db:seed
```

### 6. Build assets
```bash
npm run build
```

For development with hot reload:
```bash
npm run dev
```

## Running the Application

### Start the development server
```bash
php artisan serve
```

The application will be available at `http://localhost:8000`

## Project Structure

```
app/
├── Http/
│   ├── Controllers/      # Route handlers
│   └── Requests/         # Form validation
├── Models/               # Database models
│   ├── User.php
│   ├── Workout.php
│   ├── Nutrition.php
│   ├── Progress.php
│   ├── Reminder.php
│   └── Onboarding.php
└── Providers/            # Service providers

database/
├── migrations/           # Database schema
├── factories/            # Model factories for testing
└── seeders/              # Database seeders

routes/
├── web.php               # Web routes
├── auth.php              # Authentication routes
└── console.php           # Console commands

resources/
├── css/                  # Stylesheets
├── js/                   # JavaScript
└── views/                # Blade templates
    ├── auth/             # Authentication pages
    ├── workout/          # Workout management
    ├── nutrition/        # Nutrition tracking
    ├── progress/         # Progress dashboards
    ├── schedule/         # Schedule views
    └── profile/          # User profile
```

## Configuration

### Database
Update database settings in `.env`:
```
DB_CONNECTION=sqlite
DB_DATABASE=database/database.sqlite
```

### Mail & Notifications
Configure mail driver in `.env` for sending reminders and notifications.

### Cache & Sessions
Default cache and session drivers can be configured in `.env`.

## Testing

Run tests with PHPUnit:
```bash
php artisan test
```

Run specific test file:
```bash
php artisan test --filter ProfileTest
```

## Artisan Commands

Common Laravel artisan commands for this project:

```bash
# Create new model with migration
php artisan make:model ModelName -m

# Create new controller
php artisan make:controller ControllerName

# Run migrations
php artisan migrate

# Rollback migrations
php artisan migrate:rollback

# Clear application cache
php artisan cache:clear
```

## API Routes

The application includes RESTful routes for managing:
- Users (authentication & profile)
- Workouts (CRUD operations)
- Nutrition (logging & tracking)
- Progress (metrics & stats)
- Reminders (scheduling & management)

## Deployment

1. Update `.env` for production environment
2. Set `APP_DEBUG=false`
3. Run migrations: `php artisan migrate --force`
4. Optimize for production:
   ```bash
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   ```
5. Build frontend assets: `npm run build`

## Contributing

Contributions are welcome! Please follow the existing code style and include tests for new features.

## License

This project is open source software licensed under the MIT license.

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
