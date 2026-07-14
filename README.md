# College Result System (EduPortal)

A secure, high-fidelity, and role-based student result management system built with Vanilla PHP, MySQL, and Bootstrap 5. It features modern UX designs, styling presets, automated role gates, and full cryptographic password hashing.

---

## 🚀 Local Hosting URL
Once running, you can access the system gateway at:
👉 **[http://127.0.0.1:8000/index.php](http://127.0.0.1:8000/index.php)**

---

## ✨ Features

### 👤 Role-Based Access Control (RBAC)
The system supports three user roles with distinct portals, layouts, and access privileges:
1. **Administrators**: 
   - Manage system users and role assignments.
   - Map teachers to classes and subjects.
   - Register and manage student profiles.
   - View grade registries and search comprehensive performance reports.
2. **Teachers**:
   - Manage student details inside their assigned classrooms.
   - Enter and update academic grades (marks, grades, term parameters) for their assigned courses.
   - Access student report cards directly.
3. **Students**:
   - Access a personalized dashboard with their roll number, class, and section.
   - View their term report card with color-coded marks and grade badges.

### 🛡️ Security Hardening
- **Bcrypt Password Storage**: Upgraded database and runtime users to use standard Blowfish cryptography via PHP's `password_hash()` and `password_verify()` API.
- **XSS Mitigation**: Implemented sanitization functions (`esc()`) to prevent Cross-Site Scripting when rendering database records in HTML tables.
- **Role Validation**: Enforced strict backend authorization checks on every action to prevent privilege bypasses.

### 🎨 Modern UI & UX Redesign
- **Google Font Integration**: Embedded the clean, professional **Inter** typography layout.
- **Dynamic Sidebar**: A high-fidelity dark sidebar with **Bootstrap Icons** that highlights active pages automatically.
- **Responsive Components**: Clean rounded card frames, responsive data grids, custom buttons, and color-coded status badges (green for PASS, red for FAIL).

---

## 🛠️ Technology Stack
- **Backend**: PHP 8.x / 7.x
- **Database**: MySQL / MariaDB
- **Frontend**: HTML5, Vanilla CSS, Bootstrap 5.3.2, Bootstrap Icons

---

## 💻 Installation & Setup

### Prerequisites
- **XAMPP** or a local PHP & MySQL environment.

### 1. Database Setup
1. Open the MySQL console or phpMyAdmin.
2. Import the database schema and seeds from the `database.sql` script:
   ```bash
   mysql -u root -p < database.sql
   ```
   *Note: This automatically creates the `college_result` database, creates tables, and populates them with sample records.*

### 2. Run the Local Web Server
Open your terminal in the project directory and run the built-in PHP development server:
```bash
# Using local php command
php -S 127.0.0.1:8000

# Using XAMPP path specifically
E:\xampp\php\php.exe -S 127.0.0.1:8000
```

---

## 🔑 Seeding Credentials (Test Logins)

The following pre-seeded users are available for testing:

| Role | Username / Email | Password |
| :--- | :--- | :--- |
| **Admin** | `admin@gmail.com` | `admin123` |
| **Teacher** | `arunsharma@gmail.com` | `arun123` |
| **Student** | `rahulmehta@gmail.com` | `rahul123` |
| **Student** | `priyasharma@gmail.com` | `priya123` |
| **Student** | `amitsharma@gmail.com` | `amit123` |