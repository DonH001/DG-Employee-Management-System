# Laragon Database Setup Guide

## Quick Setup for Employee Management System with Laragon

### Prerequisites
- **Laragon** installed and running
- **MySQL service** started (green indicator in Laragon)
- **Project** located in Laragon's www directory (optional but recommended)

---

## Step-by-Step Database Setup

### 1. **Start Laragon Services**
1. Open **Laragon**
2. Click **Start All** button
3. Verify **MySQL** shows green status
4. Verify **Apache** shows green status

### 2. **Move Project to Laragon Directory (Recommended)**
```bash
# Move your project to Laragon's www directory for easier access
# Default Laragon path: C:\laragon\www\
# Move from: C:\Users\TIFFANY\Documents\DG\employee-management-system\
# To: C:\laragon\www\employee-management-system\
```

### 3. **Configure Environment File**
In your project's `.env` file, use these Laragon-optimized settings:

```env
APP_NAME="Employee Management System"
APP_ENV=local
APP_KEY=base64:your-generated-key-here
APP_DEBUG=true
APP_URL=http://employee-management-system.test

# Laragon MySQL Configuration
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=employee_management_system
DB_USERNAME=root
DB_PASSWORD=

# Laragon defaults - no password for root user
```

### 4. **Create Database - Choose Your Preferred Method**

#### **Method 1: HeidiSQL (Easiest)**
1. In Laragon, click **Database** → **HeidiSQL**
2. HeidiSQL opens automatically connected to MySQL
3. **Right-click** in the left panel (database list)
4. Select **Create new** → **Database**
5. **Database name**: `employee_management_system`
6. **Charset**: `utf8mb4`
7. **Collation**: `utf8mb4_unicode_ci`
8. Click **OK**

#### **Method 2: Laragon Terminal**
1. Click **Terminal** button in Laragon
2. Navigate to your project:
   ```bash
   cd employee-management-system
   ```
3. Connect to MySQL:
   ```bash
   mysql -u root
   ```
4. Create database:
   ```sql
   CREATE DATABASE employee_management_system CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
   SHOW DATABASES;
   EXIT;
   ```

#### **Method 3: phpMyAdmin (if installed)**
1. In Laragon, click **www** → **phpMyAdmin**
2. Click **Databases** tab
3. **Database name**: `employee_management_system`
4. **Collation**: `utf8mb4_unicode_ci`
5. Click **Create**

#### **Method 4: Quick Menu (if available)**
1. Right-click **Laragon tray icon**
2. **Quick app** → **phpMyAdmin** or **Adminer**
3. Follow web interface to create database

### 5. **Install Project Dependencies**
Open **Laragon Terminal** and run:

```bash
# Navigate to your project
cd employee-management-system  # or full path if not in www folder

# Install PHP dependencies
composer install

# Install Node.js dependencies
npm install

# Generate application key
php artisan key:generate

# Create storage link
php artisan storage:link
```

### 6. **Run Database Migrations**
```bash
# Run migrations to create tables
php artisan migrate

# Seed database with sample data
php artisan db:seed
```

### 7. **Build Frontend Assets**
```bash
# For development
npm run dev

# Keep this running for auto-refresh during development
# Or for one-time build:
npm run build
```

### 8. **Start Development Server**

#### **Option A: Laravel Artisan (Recommended)**
```bash
php artisan serve
# Access at: http://localhost:8000
```

#### **Option B: Laragon Pretty URLs (Advanced)**
If project is in `C:\laragon\www\employee-management-system\`:
- Access at: `http://employee-management-system.test`
- Point document root to `/public` folder

---

## Quick Verification Checklist

✅ **Laragon services running** (MySQL + Apache green)  
✅ **Database created** (`employee_management_system`)  
✅ **Environment configured** (`.env` file updated)  
✅ **Dependencies installed** (`composer install` + `npm install`)  
✅ **Migrations run** (`php artisan migrate`)  
✅ **Data seeded** (`php artisan db:seed`)  
✅ **Assets built** (`npm run dev` or `npm run build`)  
✅ **Server started** (`php artisan serve`)  

---

## Default Login Credentials

After running `php artisan db:seed`:

| Role | Email | Password |
|------|-------|----------|
| **Admin** | admin@company.com | password123 |
| **HR** | hr@company.com | password123 |
| **Employee** | employee@company.com | password123 |

---

## Troubleshooting

### **MySQL Connection Issues**
```bash
# Check if MySQL is running in Laragon
# Look for green MySQL indicator

# Test connection
mysql -u root -h 127.0.0.1
```

### **Database Access Issues**
```bash
# Verify database exists
mysql -u root -e "SHOW DATABASES;"

# Check Laravel can connect
php artisan migrate:status
```

### **Permission Issues**
```bash
# Fix Laravel permissions (if needed)
php artisan cache:clear
php artisan config:clear
php artisan route:clear
```

### **Port Conflicts**
- Default MySQL port: `3306`
- Default Apache port: `80`
- Laravel dev server: `8000`

If ports conflict, check Laragon settings or change in `.env`:
```env
DB_PORT=3306  # Change if needed
```

---

## Pro Tips for Laragon Users

1. **Auto-start**: Set Laragon to start with Windows
2. **Quick access**: Use Laragon's **Quick app** menu
3. **Pretty URLs**: Enable for `http://project-name.test` access
4. **Multiple PHP versions**: Switch easily in Laragon
5. **SSL**: Enable SSL for HTTPS development

Your Employee Management System should now be fully functional with Laragon! 🚀