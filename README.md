# Job Application Tracker

A Laravel-based application for tracking job applications, interviews, and follow-ups during your job search.

## Features

- **User Authentication:** Secure login and registration system
- **Job Application Management:** Track details of each job application
- **Status Tracking:** Monitor the progress of your applications (Applied, Interview, Offer, etc.)
- **Reminders:** Set follow-up reminders for interviews and other important events
- **Dashboard:** Get an overview of your job search progress

## Requirements

- PHP 8.1+
- Composer
- Node.js & NPM
- Laravel 12+

## Installation

1. Clone the repository
```
git clone <repository-url>
```

2. Install PHP dependencies
```
composer install
```

3. Install JavaScript dependencies
```
npm install
```

4. Create environment file
```
cp .env.example .env
```

5. Generate application key
```
php artisan key:generate
```

6. Configure your database in the `.env` file
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=job_tracker
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

7. Run migrations
```
php artisan migrate
```

8. Compile assets
```
npm run dev
```

9. Start the local development server
```
php artisan serve
```

## Usage

1. Register a new account or login with existing credentials
2. Add new job applications from the dashboard
3. Update the status of applications as you progress
4. Create reminders for follow-up actions
5. Track your job search progress through the dashboard

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
