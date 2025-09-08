# Task Manager (Laravel)

A simple **Task Manager** application built with **Laravel**.  
It supports creating, updating, deleting, searching, paginating, and reordering tasks.  
The UI is mobile-responsive with rounded borders and clean styling.

---

## 🚀 Features
- Add, edit, and delete tasks
- Mark tasks as complete/incomplete
- Search tasks by title or status
- Pagination for better task browsing
- Drag-and-drop task reordering (persistent)
- Mobile responsive design

---

## ⚙️ Installation & Setup

1. Clone the repository:
   ```bash
   git clone https://github.com/your-username/task-manager.git
   cd task-manager

2. Install dependencies:
   composer install
   npm install && npm run dev

3. Copy .env file and configure your database:
   cp .env.example .env
   php artisan key:generate

4. Run migrations:
   php artisan migrate
   
5. Start the development server:
   php artisan serve  

## 🛠️ Tech Stack
- Laravel 11
- Blade Templates (Bootstrap/Tailwind mix)
- MySQL (or any database supported by Laravel)
- Pagination for better task browsing
- Drag-and-drop task reordering (persistent)