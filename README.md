# Task Manager App

## Project Description
A simple task management application which allows users to perform CURD operarions on tasks. 

 ### Project features
- Task creation
- Task update
- Task deletion
- Category creation
- Category deletion
- User Registration & User Login

## Setup Instructions
1. Clone
git clone https://github.com/pamodya-piyamini/task-manager-app
cd task-manager

2. Install backend dependencies
composer install

3. install frontend
npm install

4. Setup environment 
cp .env.example .env
php artisan key:generate

(Assign an un unused port to "APP_URL" Ex: APP_URL=http://localhost:8000)

5. Configure database
- Edit your .env file and update these values:
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=task_manager
DB_USERNAME=root
DB_PASSWORD=

6. Execute migrations and seed database
php artisan migrate --seed

7. Start the application
composer run dev

8. Access the application
Open your browser and go to: 
[APP_URL]
Ex: http://localhost:8000

- Default login Credentials
Email: test@example.com
Password: password

## Technologies Used 
- Backend - Laravel 12+, Composer 8+
- Frontend - Vue 3, Inertia.js
- Database - MySQL
- Axios
- Build Tool - Vite
- Tailwind CSS, Bootstrap Icon
- XAMPP

## Assumptions & Decisions 
- A task can be created without a category.
- MySQL was chosen as the database for better backend support.
- Tasks table have the following fields: title, description, category_id, user_id, is_completed.
- The app assumes one to many relationship between user and categories, user and task, category and task.
- User session is handled using cookie-based authentication via Sanctum.
- Sample database is populated during the project setup.