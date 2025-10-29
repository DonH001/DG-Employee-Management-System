# DG Computer EMS (Employee Management System)

A modern, professional Employee Management System built with Laravel 10, featuring a sleek design with glassmorphism effects, gradient themes, and comprehensive mobile responsiveness.

## Features

### 🔐 Role-Based Authentication
- **Admin**: Full system access, manage all employees, departments, projects
- **HR**: Employee management, leave requests, time entry approvals
- **Employee**: Personal dashboard, time tracking, project view, leave requests

### 👥 Employee Management
- Complete employee profiles with personal and professional information
- Department and position assignments
- Manager-subordinate relationships
- Employee status tracking (active, inactive, terminated, on leave)
- Document management and file uploads

### 🏢 Department & Position Management  
- Hierarchical department structure
- Position definitions with salary ranges
- Manager assignments per department
- Budget tracking

### 📊 Project Management
- Project creation and tracking
- Employee assignment to projects with specific roles
- Project status monitoring (planning, active, on hold, completed, cancelled)
- Budget and timeline management

### ⏱️ Time Tracking
- Daily time entry logging
- Project-specific time tracking
- Approval workflow for time entries
- Overtime and different entry types support

### 🏖️ Leave Management
- Leave request submission
- Approval workflow
- Multiple leave types (vacation, sick, personal, etc.)
- Leave balance tracking

### 📈 Reporting & Analytics
- Employee reports and statistics
- Department overview and metrics
- Project progress and budget utilization
- Time tracking reports

## Technology Stack

- **Backend**: Laravel 10 (PHP 8.1+)
- **Frontend**: Tailwind CSS, Alpine.js
- **Database**: MySQL 8.0+
- **Authentication**: Laravel Breeze with custom role management
- **Build Tools**: Vite
- **Package Manager**: Composer, NPM

## Installation

### Prerequisites
- PHP 8.1 or higher
- Composer
- Node.js & NPM
- MySQL 8.0+
- Web server (Apache/Nginx)

### Step 1: Clone and Install Dependencies

```bash
# Clone the repository
git clone <repository-url> employee-management-system
cd employee-management-system

# Install PHP dependencies
composer install

# Install Node.js dependencies
npm install
```

### Step 2: Environment Configuration

```bash
# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate
```

### Step 3: Database Configuration with Laragon

Since you're using Laragon, the database setup is much simpler:

Edit your `.env` file:

```env
APP_NAME="Employee Management System"
APP_ENV=local
APP_KEY=base64:your-generated-key-here
APP_DEBUG=true
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=employee_management_system
DB_USERNAME=root
DB_PASSWORD=
```

**Note**: Laragon's default MySQL setup uses `root` user with no password.

### Step 4: Database Setup with Laragon

#### Option 1: Using Laragon's HeidiSQL (Recommended)
1. **Start Laragon** and make sure MySQL is running (green light)
2. **Open HeidiSQL** from Laragon menu → Database → HeidiSQL
3. **Connect** (should auto-connect to localhost MySQL)
4. **Right-click** on the left panel → Create new → Database
5. **Name**: `employee_management_system`
6. **Charset**: `utf8mb4`
7. **Collation**: `utf8mb4_unicode_ci`
8. **Click OK**

#### Option 2: Using Laragon Terminal
1. **Open Laragon Terminal** (Terminal button in Laragon)
2. **Connect to MySQL**:
   ```bash
   mysql -u root
   ```
3. **Create Database**:
   ```sql
   CREATE DATABASE employee_management_system CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
   SHOW DATABASES;
   EXIT;
   ```

#### Option 3: Using phpMyAdmin (if installed)
1. **Open phpMyAdmin** from Laragon menu → www → phpMyAdmin
2. **Click "Databases" tab**
3. **Create database**: `employee_management_system`
4. **Choose Collation**: `utf8mb4_unicode_ci`
5. **Click Create**

### Step 5: Run Migrations and Seeders

```bash
# Navigate to your project directory
cd c:\Users\TIFFANY\Documents\DG\employee-management-system

# Run migrations and seeders
php artisan migrate
php artisan db:seed
```

### Step 5: Build Assets and Start Development

```bash
# Build frontend assets
npm run dev

# Start Laravel development server
php artisan serve
```

The application will be available at `http://localhost:8000`

## Default Login Credentials

After running the seeder, you can login with:

- **Admin**: admin@company.com / password123
- **HR**: hr@company.com / password123  
- **Employee**: employee@company.com / password123

## File Structure

```
employee-management-system/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Auth/
│   │   │   ├── DashboardController.php
│   │   │   ├── EmployeeController.php
│   │   │   ├── DepartmentController.php
│   │   │   ├── ProjectController.php
│   │   │   └── TimeEntryController.php
│   │   ├── Middleware/
│   │   │   ├── RoleMiddleware.php
│   │   │   └── CheckMultipleRoles.php
│   │   └── Requests/
│   └── Models/
│       ├── User.php
│       ├── Employee.php
│       ├── Department.php
│       ├── Position.php
│       ├── Project.php
│       ├── TimeEntry.php
│       └── LeaveRequest.php
├── database/
│   ├── migrations/
│   └── seeders/
├── resources/
│   ├── css/
│   │   └── app.css
│   ├── js/
│   │   └── app.js
│   └── views/
│       ├── admin/
│       ├── employee/
│       ├── auth/
│       └── layouts/
└── routes/
    └── web.php
```

## Key Features Implementation

### Role-Based Access Control
The system implements middleware-based role checking:
- `RoleMiddleware`: Single role validation
- `CheckMultipleRoles`: Multiple role validation
- Route protection based on user roles

### Dashboard Analytics
- Real-time statistics and metrics
- Role-specific dashboard content
- Quick action buttons and navigation

### Advanced Search & Filtering
- Employee search by name, ID, email
- Department and status filters
- Date range filtering for reports

### Responsive Design
- Mobile-first approach with Tailwind CSS
- Consistent design system with custom components
- Accessible and user-friendly interface

## Production Deployment

### Environment Setup
```bash
# Set production environment
APP_ENV=production
APP_DEBUG=false

# Configure production database
DB_HOST=your-production-host
DB_DATABASE=your-production-db
DB_USERNAME=your-production-user
DB_PASSWORD=your-production-password

# Set application URL
APP_URL=https://your-domain.com
```

### Build for Production
```bash
# Install production dependencies
composer install --optimize-autoloader --no-dev

# Build production assets
npm run build

# Cache configuration
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Run migrations
php artisan migrate --force
```

### Web Server Configuration

#### Apache (.htaccess)
```apache
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteRule ^(.*)$ public/$1 [L]
</IfModule>
```

#### Nginx
```nginx
server {
    listen 80;
    server_name your-domain.com;
    root /path/to/employee-management-system/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    index index.php;

    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.1-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

## Security Considerations

1. **Authentication**: Laravel Breeze with custom role management
2. **Authorization**: Middleware-based route protection
3. **CSRF Protection**: Built-in Laravel CSRF tokens
4. **SQL Injection**: Eloquent ORM with parameterized queries
5. **XSS Protection**: Blade template engine auto-escaping
6. **Password Hashing**: Laravel's built-in bcrypt hashing

## Support & Maintenance

### Regular Tasks
- Database backups
- Log file rotation
- Security updates
- Performance monitoring

### Monitoring
- Application logs: `storage/logs/laravel.log`
- Performance metrics via built-in analytics
- Error tracking and reporting

## Contributing

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Add tests if applicable
5. Submit a pull request

## License

This project is licensed under the MIT License.

## Contact

For support or questions, please contact the development team.