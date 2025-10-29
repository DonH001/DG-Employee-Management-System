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

