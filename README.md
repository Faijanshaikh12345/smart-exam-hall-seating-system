# 🎓 Smart Exam Hall Seating System (Laravel)

A web-based Smart Exam Hall Seating System built with Laravel to manage academic departments, students, subjects, examinations, exam halls, and seating arrangements. The system provides Admin, Staff, and Student portals to simplify examination management, generate seating arrangements, identify seating conflicts, and organize exam hall allocation efficiently through a centralized dashboard.

## 🚀 Features

- Role-Based Access Control (Admin / Staff / Student)
- Dashboard with Examination Management Overview
- Department Management
- Student Management
- Staff Management
- Subject Management
- Examination Management
- Exam Registration Management
- Exam Hall Management
- Hall Seat Management
- Automated Exam Hall Seating Arrangement
- Student Seat Allocation
- Seating Arrangement Management
- Seating Conflict Detection
- Examination Reports
- Hall Seating Reports
- Student Seating Reports
- User Management
- Account Settings
- Secure Authentication and Authorization

## 🛠️ Tech Stack

- PHP
- Laravel
- MySQL
- Blade Template Engine
- HTML5
- CSS3
- JavaScript
- Bootstrap / AdminLTE Dashboard
- Git and GitHub

## ⚙️ Project Setup (After Downloading from GitHub)

Follow these steps to run the project on your local computer.

### ✅ Step 1 — Clone the Repository

```bash
git clone https://github.com/Faijanshaikh12345/smart-exam-hall-seating-system.git
```

Open the project folder in VS Code.

```bash
cd smart-exam-hall-seating-system
```

### ✅ Step 2 — Install PHP Dependencies

```bash
composer install
```

### ✅ Step 3 — Create the Environment File

Copy the example environment file.

For Windows PowerShell:

```powershell
Copy-Item .env.example .env
```

### ✅ Step 4 — Generate the Application Key

```bash
php artisan key:generate
```

### ✅ Step 5 — Configure the Database

1. Start Apache and MySQL from XAMPP.
2. Open phpMyAdmin at `http://localhost/phpmyadmin`.
3. Create a database named `smart_exam_seating`.
4. Open the `.env` file and update the database configuration.

```env
APP_NAME="Smart Exam Hall Seating System"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://127.0.0.1:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=smart_exam_seating
DB_USERNAME=root
DB_PASSWORD=
```

Update the database username and password if your MySQL configuration is different.

### ✅ Step 6 — Run Database Migrations and Seeders

```bash
php artisan migrate --seed
```

This command creates the database tables and inserts the demo data configured in the project's seeders.

### ✅ Step 7 — Start the Laravel Development Server

```bash
php artisan serve
```

### ✅ Step 8 — Open the Application

Visit the following URL in your browser:

http://127.0.0.1:8000

## 📂 Project Modules

- Dashboard
- Departments
- Students
- Subjects
- Exams
- Exam Registrations
- Exam Halls
- Hall Seats
- Generate Seating
- Seating Arrangements
- Seating Conflicts
- Exam Reports
- Hall Seating Reports
- Student Seating Reports
- Users
- Settings
- Authentication and Authorization

## 👥 User Roles

**Admin:** Manages users, academic information, examinations, exam halls, seating arrangements, and reports.

**Staff:** Accesses examination-related functionality according to assigned permissions.

**Student:** Accesses student-related functionality according to assigned permissions.

## 🔐 Default Login Credentials

Use the demo credentials configured in the project's database seeders.

If no default user is created automatically, configure an administrator account before logging in.

## 👨‍💻 Author

**Faijan Shaikh**

GitHub: https://github.com/Faijanshaikh12345

## 📌 Note

This project was developed for learning, practical implementation, and portfolio purposes using Laravel and MySQL.

The system aims to simplify examination management and make student seating allocation more organized and efficient.

For installation issues or suggestions, please create an issue in the GitHub repository.
