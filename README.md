<p align="center">
  <img src="public/images/wis2.png" alt="Project Icon" height="130">
</p>

A **modular web-based information system** built with **Laravel (PHP 8.1)** that provides management of users, courses, scheduling, and academic activities. The system implements role-based access control, a structured modular architecture, and a modern responsive UI built with **Flowbite** and **Tailwind CSS** components.

---

## ▶️ Preview

https://github.com/user-attachments/assets/38b933f7-0991-4e22-8755-7a87a1231775

---

## 👥 Authors

* [Miroslav Bašista](https://github.com/Mirek321) - Team Leader
* [Patrik Procházka](https://github.com/ppatrik-dev) - Contributor
* [Nataliia Solomatina](https://github.com/solomatinanataliia) - Contributor

---

## 🌟 Features

- Authentication (registration, login, logout)
- Role-based access control system
- User management with search and role filtering
- Course management (create, assign, enroll, grade)
- Course news and updates
- Term and schedule management
- Room management for scheduling
- Student enrollment into terms
- Timetable visualization

---

## 🧩 Modules

### 🔐 Authentication

Responsible for user authentication including registration, login, logout, and session management.

<p align="center">
  <img src="docs/screens/register-login-page.png" alt="Home page screenshot" width="900" />
</p>

---

### 👤 User Management

Provides complete user administration with role assignment, permissions, search, filtering, and CRUD operations.

<p align="center">
  <img src="docs/screens/users-page.png" alt="Home page screenshot" width="900" />
</p>

---

### 📚 Course Management

Allows administrators and lecturers to manage courses, assign lecturers, enroll students, publish course news, and evaluate student performance.

<p align="center">
  <img src="docs/screens/courses-page.png" alt="Home page screenshot" width="900" />
</p>

---

### 📅 Term Management

Provides management of teaching terms, classrooms, student registrations, grading, and timetable visualization.

<p align="center">
  <img src="docs/screens/terms-page.png" alt="Home page screenshot" width="900" />
</p>

---

### 🏠 Room Management

Provides management of classrooms including creation, updates, and availability tracking.

<p align="center">
  <img src="docs/screens/rooms-page.png" alt="Home page screenshot" width="900" />
</p>

---

## 🛢️ Database

The system uses **Laravel migrations and seeders** to manage the structure and initial data in **MySQL** database.

[Entity Relation diagram](/docs/wis2-er-diagram.svg) – Shows the database structure and relationships between system entities.

---

## 📄 Documentation

This project uses **PHPDoc annotations** to improve code readability, maintainability, and IDE support.

During the development process, the following documentation artifacts were created:

[Use Case diagram](/docs/wis2-use-case.svg) – Shows the main system interactions between users and the application.

[Wireframe](/docs/wis2-wireframe.svg) – Visual layout representation of the system module interface and structure.

---

## 🧪 Testing

This project does not include automated tests. All functionality was verified through **manual testing** during development.

Manual testing focused on:
- User authentication and authorization flows
- CRUD operations across all modules
- Role-based access control behavior
- Course creation, enrollment, and grading logic
- Term scheduling and timetable correctness
- Search and filtering functionality across the system

---

## 📜 License

This project is licensed under the MIT License. See the `LICENCE` file for details.