# Installation and Setup Instructions

## Quick Start Guide

Follow these steps to get your Employee Management System up and running:

### 1. Prerequisites Check
Make sure you have installed:
- **PHP 8.1+** with extensions: BCMath, Ctype, Fileinfo, JSON, Mbstring, OpenSSL, PDO, Tokenizer, XML
- **Composer** (https://getcomposer.org/)
- **Node.js 16+** and **NPM** (https://nodejs.org/)
- **MySQL 8.0+** or **MariaDB 10.3+**

### 2. Installation Steps

```bash
# 1. Navigate to your project directory
cd /path/to/your/employee-management-system

# 2. Install PHP dependencies
composer install

# 3. Install Node.js dependencies  
npm install

# 4. Create environment file
copy .env.example .env

# 5. Generate application key
php artisan key:generate
```

### 3. Database Setup

#### Create Database
```sql
-- Connect to MySQL
mysql -u root -p

-- Create database
CREATE DATABASE employee_management_system CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Create user (optional, for security)
CREATE USER 'ems_user'@'localhost' IDENTIFIED BY 'your_secure_password';
GRANT ALL PRIVILEGES ON employee_management_system.* TO 'ems_user'@'localhost';
FLUSH PRIVILEGES;
EXIT;
```

#### Configure Environment
Edit your `.env` file:

```env
# Application Settings
APP_NAME="Employee Management System"
APP_ENV=local
APP_KEY=base64:your-generated-key-here
APP_DEBUG=true
APP_URL=http://localhost:8000

# Database Configuration
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=employee_management_system
DB_USERNAME=ems_user
DB_PASSWORD=your_secure_password

# Mail Configuration (Optional)
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your-email@gmail.com
MAIL_FROM_NAME="${APP_NAME}"
```

### 4. Run Database Migrations and Seeders

```bash
# Run database migrations
php artisan migrate

# Seed the database with sample data
php artisan db:seed

# Create storage link for file uploads
php artisan storage:link
```

### 5. Build Frontend Assets

```bash
# For development
npm run dev

# For production
npm run build
```

### 6. Start Development Server

```bash
# Start Laravel development server
php artisan serve

# Your application will be available at:
# http://localhost:8000
```

## Default Login Credentials

After running the database seeder, use these credentials to log in:

### Admin Account
- **Email**: admin@company.com
- **Password**: password123
- **Access**: Full system administration

### HR Account  
- **Email**: hr@company.com
- **Password**: password123
- **Access**: Employee and HR management

### Employee Account
- **Email**: employee@company.com  
- **Password**: password123
- **Access**: Personal dashboard and time tracking

## Troubleshooting

### Common Issues and Solutions

#### 1. "Permission denied" errors
```bash
# Fix Laravel permissions (Linux/Mac)
sudo chown -R $USER:www-data storage bootstrap/cache
sudo chmod -R 775 storage bootstrap/cache

# Windows (Run as Administrator)
icacls storage /grant Users:F /T
icacls bootstrap\cache /grant Users:F /T
```

#### 2. Database connection issues
- Verify MySQL service is running
- Check database credentials in `.env`
- Ensure database exists and user has proper permissions

#### 3. NPM/Node.js issues
```bash
# Clear NPM cache
npm cache clean --force

# Delete node_modules and reinstall
rm -rf node_modules
npm install
```

#### 4. Composer issues
```bash
# Update Composer
composer self-update

# Clear Composer cache
composer clear-cache

# Reinstall dependencies
rm -rf vendor
composer install
```

### 5. Laravel application issues
```bash
# Clear all Laravel caches
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Restart the development server
php artisan serve
```

## Production Deployment

### 1. Environment Configuration
```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://yourdomain.com

# Use production database credentials
DB_HOST=your-production-host
DB_DATABASE=your-production-database
DB_USERNAME=your-production-user
DB_PASSWORD=your-secure-production-password
```

### 2. Optimization Commands
```bash
# Install production dependencies only
composer install --optimize-autoloader --no-dev

# Build production assets
npm run build

# Cache Laravel configurations
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Run migrations in production
php artisan migrate --force
```

### 3. Web Server Setup

#### Apache Virtual Host
```apache
<VirtualHost *:80>
    ServerName yourdomain.com
    DocumentRoot /path/to/employee-management-system/public
    
    <Directory /path/to/employee-management-system/public>
        AllowOverride All
        Require all granted
    </Directory>
    
    ErrorLog ${APACHE_LOG_DIR}/ems_error.log
    CustomLog ${APACHE_LOG_DIR}/ems_access.log combined
</VirtualHost>
```

#### Nginx Server Block
```nginx
server {
    listen 80;
    server_name yourdomain.com;
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

## System Requirements

### Minimum Requirements
- **PHP**: 8.1 or higher
- **Memory**: 512MB RAM
- **Disk Space**: 100MB for application
- **Database**: MySQL 5.7+ or MariaDB 10.3+

### Recommended for Production
- **PHP**: 8.2 or higher  
- **Memory**: 2GB RAM or more
- **Disk Space**: 1GB+ (for file uploads and logs)
- **Database**: MySQL 8.0+ or MariaDB 10.6+
- **Web Server**: Nginx or Apache with SSL
- **Caching**: Redis or Memcached

## Next Steps

1. **Customize Settings**: Update company information and branding
2. **Add Departments**: Create your organization's department structure  
3. **Import Employees**: Add your existing employee data
4. **Configure Email**: Set up SMTP for notifications
5. **Setup Backups**: Implement regular database and file backups
6. **SSL Certificate**: Secure your production site with HTTPS

## Support

If you encounter any issues during installation:

1. Check the Laravel logs: `storage/logs/laravel.log`  
2. Verify all requirements are met
3. Review the troubleshooting section above
4. Check Laravel documentation: https://laravel.com/docs

Your Employee Management System is now ready to use! 🎉