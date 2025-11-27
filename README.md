<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

#  Contact Management Project (Full CRUD)

This is a web application project implementing a **Contact Management System (CRUD)** built on Laravel. It includes features such as user authentication, soft deletes, search and data validation.

---

## Stack

### Frontend / UI
* **Blade Templates:** Used for server-side rendering of all views.
* **Laravel Breeze:** Used for authentication scaffolding (Login, Registration, etc.).
* **Tailwind CSS:** Utility-first CSS framework for fast and responsive styling.

### Backend / Core
* **Laravel Framework:** The application's main foundation, providing the MVC structure using version 10.
* **PHP:** The primary server-side language (Version: **8.1+**).
* **Composer:** PHP dependency management.

### Database / Storage
* **MariaDB:** Primary database (configurable via `.env`).
* **Eloquent ORM:** Used for database interaction.

---

## System Overview and Architecture

This project is a dedicated Contact Management Web Application developed as a solution for an Alfasoft Technical Challenge. It implements a complete CRUD (Create, Read, Update, Delete) system for contact entities, strictly adhering to the specified requirements: ensuring data integrity through unique validation for both email and contact number (9 digits), and utilizing Laravel's native features like Soft Deletes for logical removal. It also contains features such as authenticated access control for all management operations and corresponding PHPUnit tests covering form validation and functionality.

### 1. Key Features
The system's core features revolve around the **`ContactController`** and the **`Contact` Model**:

| Feature | Endpoint | Description |
| :--- | :--- | :--- |
| **Authentication** | `/login`, `/register` | Access to contact management is protected by the `auth` middleware. |
| **Listing & Search** | `/contacts` | Displays paginated list of **active** contacts and supports filtering by Name, Email, or Contact number. |
| **Soft Delete** | `DELETE /contacts/{id}` | Marks the contact as deleted (`deleted_at` timestamp) but keeps the record in the database. |
| **Trash Management** | `/contacts/trashed` | Dedicated view listing **only** soft-deleted contacts. |
| **Restore** | `PATCH /contacts/{id}/restore` | Restores a soft-deleted contact, making it active again. |
| **Permanent Delete** | `DELETE /contacts/{id}/wipe` | **Permanently removes** the record from the database (`forceDelete`). |

### 2. Data Integrity and Testing
* **Business Logic:** Critical business rules (like uniqueness checks) are enforced using **Form Requests**.
* **Transactions:** All critical write operations (`store`, `update`, `destroy`, `restore`, `wipe`) should be wrapped in **database transactions** to ensure data consistency upon failure.
* **PHPUnit Tests:** Feature tests (`ContactFeatureTest.php`) ensure the entire CRUD lifecycle, validation, and authentication work as expected by simulating a logged-in user (`actingAs()`).

---

## Business Rules and Validation

Strict validation rules are applied to contact data to ensure quality and prevent duplicates:

| Field | Rule | Detail |
| :--- | :--- | :--- |
| **name** | `required`, `string`, `min:5` | The contact's full name. |
| **email** | `required`, `email`, `unique` | Must be a valid format and unique across the contacts table (excluding the current record on update). |
| **contact** | `required`, `digits:9`, `unique` | Must be exactly 9 digits long and unique. |

---

## Installation and Setup

To get this Laravel project running locally, follow these steps:

### Requirements

Ensure your environment meets the following minimum requirements:

* **PHP** (Version 8.1 or higher).
* **Composer**.
* PHP Extensions: `OpenSSL`, `PDO`, `Mbstring`, `Tokenizer`, `XML`.
* A database system (**MySQL, PostgreSQL, or SQLite**).

### Steps

1.  **Clone the repository:**
    ```bash
    git clone [YOUR-REPO-URL] project-name
    cd project-name
    ```

2.  **Install PHP dependencies via Composer:**
    ```bash
    composer install
    ```

3.  **Create the environment configuration file:**
    ```bash
    cp .env.example .env
    ```

4.  **Generate the application key:**
    ```bash
    php artisan key:generate
    ```

5.  **Configure the database** settings in the `.env` file (e.g., `DB_DATABASE`, `DB_USERNAME`).

6.  **Run Migrations and Seeders** (optional):
    ```bash
    php artisan migrate --seed
    ```

7.  **Start the development server:**
    ```bash
    php artisan serve
    ```

The application will be accessible at `http://127.0.0.1:8000`.

---

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

* [Simple, fast routing engine](https://laravel.com/docs/routing).
* [Powerful dependency injection container](https://laravel.com/docs/container).
* Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
* Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
* Database agnostic [schema migrations](https://laravel.com/docs/migrations).
* [Robust background job processing](https://laravel.com/docs/queues).
* [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

---

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains over 2000 video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

---

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

* **[Vehikl](https://vehikl.com/)**
* **[Tighten Co.](https://tighten.co)**
* **[WebReinvent](https://webreinvent.com/)**
* **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
* **[64 Robots](https://64robots.com)**
* **[Curotec](https://www.curotec.com/services/technologies/laravel/)**
* **[Cyber-Duck](https://cyber-duck.co.uk)**
* **[DevSquad](https://devsquad.com/hire-laravel-developers)**
* **[Jump24](https://jump24.co.uk)**
* **[Redberry](https://redberry.international/laravel/)**
* **[Active Logic](https://activelogic.com)**
* **[byte5](https://byte5.de)**
* **[OP.GG](https://op.gg)**

---

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

---

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

---

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

---

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).