# CarRentalClient

A comprehensive web application for managing car rentals, built with Laravel. This front-end interface is one component of a two-part system:
- **CarRentalClient**: Frontend web interface (this repository)
- **CarRentalAPI**: Backend REST API service

## Project Overview
The CarRentalClient application provides a user-friendly interface for managing car rentals, featuring a responsive dashboard, authentication system, and complete car management functionality.

## Production Environment
- **Client URL:** http://74.243.216.220
- **API Endpoint:** http://20.174.18.154/api/*

## Description
CarRentalClient serves as the front-end interface for a car rental system, providing a user-friendly platform for both customers and administrators. The application integrates with CarRentalAPI for data management and authentication services.

## Key Features
- User authentication (login/register)
- Interactive dashboard with car grid display
- Complete CRUD operations for car management
- Search functionality by car ID
- Responsive design with Tailwind CSS
- Real-time loading states and error handling
- Price display in Saudi Riyal (SAR)

## Technology Stack
- **Framework:** Laravel 10.x
- **PHP Version:** 8.4.7
- **Frontend:** 
  - Blade templating
  - JavaScript/Axios
- **Server:** Apache 2.4.58 on Ubuntu 22.04
- **Authentication:** Laravel Sanctum
- **Development Tools:** Composer

## Local Setup

1. Clone the repository:
```bash
git clone [repository-url]
cd CarRentalClient
```

2. Install dependencies:
```bash
composer install
```

3. Configure environment:
```bash
cp .env.example .env
php artisan key:generate
```

4. Update `.env` with API settings:
```
API_BASE_URL=http://20.174.18.154/api
```

## Detailed Project Structure

### Routes Configuration (routes/web.php)
```php
Route::get('/', fn() => redirect('/login'));
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegisterForm']);
Route::post('/register', [AuthController::class, 'register']);

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [CarController::class, 'index'])->name('dashboard');
    Route::resource('cars', CarController::class);
    Route::get('/search', [CarController::class, 'search']);
});
```

### Core Components


#### Views Structure
```
resources/views/
├── layouts/
│   └── app.blade.php       # Base layout template
├── auth/
│   ├── login.blade.php     # Login form
│   └── register.blade.php  # Registration form
├── cars/
│   ├── index.blade.php     # Car listing/grid
│   ├── create.blade.php    # Add new car form
│   └── edit.blade.php      # Edit car form
└── dashboard.blade.php     # Main dashboard
```

## API Integration
```javascript
// Example API call using Axios
const response = await axios.get(`${API_BASE_URL}/cars`, {
    headers: {
        'Authorization': `Bearer ${token}`,
        'Accept': 'application/json'
    }
});
```

## Deployment Configuration
```apache
# Apache Virtual Host Configuration
<VirtualHost *:80>
    ServerName 74.243.216.220
    DocumentRoot /var/www/html/rentals/public
    
    <Directory /var/www/html/rentals/public>
        Options Indexes FollowSymLinks
        AllowOverride All
        Require all granted
    </Directory>

    ErrorLog ${APACHE_LOG_DIR}/carrentalclient_error.log
    CustomLog ${APACHE_LOG_DIR}/carrentalclient_access.log combined
</VirtualHost>
```

## Testing Instructions

### Local Environment
1. Start local server:
```bash
php artisan serve
```
2. Access http://localhost:8000
3. Test features:
   - User registration/login
   - Car management (CRUD)
   - Search functionality
   - Responsive design

### Production Environment
1. Visit http://74.243.216.220
2. Test with provided credentials or register new account
3. Verify all features work with the production API


## License and Academic Context
This project is developed as part of the Web-Based Systems (IS-314) course at KFU. All rights reserved.
- **Course**: IS-314 Web-Based Systems
- **Institution**: King Faisal University
- **Year**: 2025

