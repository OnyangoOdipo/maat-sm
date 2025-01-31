```markdown:README.md
# School Management System

A comprehensive school management system built with Laravel, designed to help schools manage their administrative tasks efficiently.


## Requirements

- PHP >= 8.1
- Composer
- MySQL/PostgreSQL
- Node.js & NPM
- Laravel 10.x

## Installation

1. Clone the repository
```bash
git remote add origin https://github.com/OnyangoOdipo/maat-sm.git
cd maat-sm
```

2. Install dependencies
```bash
composer install
npm install
```

3. Set up environment file
```bash
cp .env.example .env
php artisan key:generate
```

4. Configure your database in `.env`
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=school_management
DB_USERNAME=root
DB_PASSWORD=
```

5. Run migrations and seeders
```bash
php artisan migrate --seed
```

6. Start the development server
```bash
php artisan serve
npm run dev
```

## Initial Setup

After installation, you can log in with these default credentials:

### Super Admin
- Email: `superadmin@example.com`
- Password: `password`

### School Admin
- Email: `schooladmin@example.com`
- Password: `password`

### Teacher
- Email: `teacher@example.com`
- Password: `password`

## Quick Start Guide

1. **School Configuration**
   - Log in as School Admin
   - Go to Settings to configure:
     - School details
     - Academic year
     - Terms/Semesters

2. **Curriculum Setup**
   - Navigate to Curriculum Management
   - Add curriculum types (8-4-4, CBC, IGCSE)
   - Configure subjects for each curriculum

3. **Class Setup**
   - Create class levels
   - Add streams/sections
   - Assign teachers to classes

4. **User Management**
   - Add teachers
   - Register students
   - Create parent accounts

## Key Features Guide

### School Types Management
```bash
# Access school types management
URL: /school-types

# Available categories:
- Boarding School
- Day School
```

### Teacher Management
```bash
# Access teacher management
URL: /teachers

# Features:
- Add/Edit teachers
- Assign subjects
- Set schedules
- Track performance
```

### Student Management
```bash
# Access student management
URL: /students

# Features:
- Registration
- Class assignment
- Attendance tracking
- Grade management
```

## Development

### Running Tests
```bash
php artisan test
```

## Troubleshooting

Common issues and solutions:

1. **Database Connection Error**
   ```bash
   php artisan config:clear
   php artisan cache:clear
   ```

2. **Migration Issues**
   ```bash
   php artisan migrate:fresh --seed
   ```

3. **Permission Issues**
   ```bash
   chmod -R 777 storage bootstrap/cache
   ```

## Contributing

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request