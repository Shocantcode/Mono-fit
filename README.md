# MonoFit - Workout Application

MonoFit is a comprehensive workout and fitness tracking application built with Laravel. It helps users manage their fitness journey by tracking workouts, nutrition, progress, and providing personalized reminders.

## Author
| Nama                        | GitHub                                        |
| --------------------------- | --------------------------------------------- |
| Kenzie Rolland Gracia       | [Shocantcode](https://github.com/Shocantcode) |

| Nicholas Febrian Maladi     | [nicfebma](https://github.com/nicfebma)       |
| Maulana Isabril Hafidz      | [maulhafidz](https://github.com/maulhafidz)   |
| Reyven Theo Bastian Pribadi | [mowakino](https://github.com/mowakino)       |
| Ryan Setiadi                | [Insuxed](https://github.com/Ins)             |

## Features

- **User Management**: Secure user authentication and profiles
- **Workout Tracking**: Create and track custom workouts with exercises
- **Nutrition Logging**: Monitor daily nutrition intake and goals
- **Progress Monitoring**: Track fitness progress over time with charts and metrics
- **Reminders**: Set personalized workout and nutrition reminders
- **Onboarding**: Guided onboarding process for new users
- **Responsive Design**: Modern, mobile-friendly interface built with Tailwind CSS

## Requirements

- PHP 8.1 or higher
- Composer
- Node.js and npm
- MySQL or another supported database

## Installation

1. **Clone the repository:**
   ```bash
   git clone https://github.com/your-username/monofit.git
   cd monofit
   ```

2. **Install PHP dependencies:**
   ```bash
   composer install
   ```

3. **Install Node.js dependencies:**
   ```bash
   npm install
   ```

4. **Environment Setup:**
   - Copy `.env.example` to `.env`
   - Configure your database settings in `.env`
   - Generate application key:
     ```bash
     php artisan key:generate
     ```

5. **Database Setup:**
   ```bash
   php artisan migrate
   php artisan db:seed  # Optional: to seed initial data
   ```

6. **Build Assets:**
   ```bash
   npm run build
   # or for development
   npm run dev
   ```

7. **Start the Application:**
   ```bash
   php artisan serve
   ```

   Visit `http://localhost:8000` in your browser.

## Usage

### For Users
- Register/Login to access your dashboard
- Complete the onboarding process
- Create and log your workouts
- Track your nutrition intake
- Monitor your progress with charts
- Set reminders for workouts and meals

### For Developers
- Run tests: `php artisan test`
- Run linter: `./vendor/bin/pint`
- Build assets for production: `npm run build`

## Project Structure

```
MonoFit/
├── app/
│   ├── Http/Controllers/     # Controllers
│   ├── Models/              # Eloquent Models
│   └── Providers/           # Service Providers
├── database/
│   ├── migrations/          # Database migrations
│   └── seeders/            # Database seeders
├── public/                  # Public assets
├── resources/
│   ├── css/                # Stylesheets
│   ├── js/                 # JavaScript files
│   └── views/              # Blade templates
├── routes/                  # Route definitions
└── tests/                   # Test files
```

## Contributing

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add some amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## Support

If you have any questions or need help, please open an issue on GitHub or contact the development team.

---

Built with using Laravel and Tailwind CSS.

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
