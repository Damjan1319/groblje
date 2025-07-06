# Groblje - Cemetery Management System

A comprehensive Laravel-based web application for managing cemetery operations, including plot management, payment tracking, and deceased records.

## Features

### 🔐 Authentication & Authorization
- User registration and login
- Role-based access control (User, Admin, Superadmin)
- Password reset functionality
- Email verification

### 🏛️ Cemetery Management
- **Grobna mesta (Cemetery Plots)**: Manage cemetery plots with detailed information
- **Uplatioci (Payers)**: Track individuals responsible for plot payments
- **Preminuli (Deceased)**: Maintain records of deceased individuals
- **Uplate (Payments)**: Comprehensive payment tracking system

### 🔍 Search & Statistics
- Advanced search functionality across all entities
- Statistical overview and reporting
- Filtering and sorting capabilities

### 👥 User Roles & Permissions
- **User**: Basic viewing and search capabilities
- **Admin**: Can add new records (no edit/delete permissions)
- **Superadmin**: Full CRUD operations on all entities

## Technology Stack

- **Backend**: Laravel 11 (PHP 8.2+)
- **Frontend**: Blade templates with Tailwind CSS
- **Database**: MySQL/PostgreSQL
- **Authentication**: Laravel Breeze
- **Build Tool**: Vite

## Installation

### Prerequisites
- PHP 8.2 or higher
- Composer
- Node.js & NPM
- MySQL/PostgreSQL database

### Setup Instructions

1. **Clone the repository**
   ```bash
   git clone <repository-url>
   cd groblje
   ```

2. **Install PHP dependencies**
   ```bash
   composer install
   ```

3. **Install Node.js dependencies**
   ```bash
   npm install
   ```

4. **Environment setup**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. **Configure database**
   - Update `.env` file with your database credentials
   - Run migrations: `php artisan migrate`
   - Seed the database: `php artisan db:seed`

6. **Build assets**
   ```bash
   npm run build
   ```

7. **Start the development server**
   ```bash
   php artisan serve
   ```

## Database Structure

### Core Entities

#### Users
- Authentication and authorization
- Role-based permissions (user, admin, superadmin)

#### GrobnoMesto (Cemetery Plots)
- Plot identification and location
- Status tracking (available, occupied, reserved)
- Associated payer information

#### Uplatilac (Payers)
- Personal information (name, contact details)
- Payment history and obligations
- Relationship to plots

#### Preminuli (Deceased)
- Personal information and dates
- Burial location and plot association
- Family contact information

#### Uplata (Payments)
- Payment amounts and dates
- Payment purpose and recipient
- Associated payer and plot information

## Usage

### For Users
1. Register or login to access the system
2. Use the search functionality to find specific records
3. View statistics and reports

### For Admins
1. Access all user capabilities
2. Add new records (plots, payers, deceased, payments)
3. Cannot edit or delete existing records

### For Superadmins
1. Full access to all features
2. Complete CRUD operations on all entities
3. System administration capabilities

## Contributing

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Submit a pull request

## License

This project is licensed under the MIT License.

## Support

For support and questions, please contact the development team.
