# SIS — Student Information System

A Laravel-based **Student Information System (SIS)** for managing students, enrollments, grades, admissions requirements, interview scheduling, and Certificate of Registration (COR) PDF generation. The application provides separate experiences for **administrators** (staff users) and **students**, using dual authentication guards on a single login page.

---

## Features

| Area | Description |
|------|-------------|
| **Admin portal** | Dashboard, student/subject/grade/enrollment management |
| **Interview calendar** | Schedule and manage first-year student interviews (`/admin/interviews`) |
| **Requirements review** | Review and approve student document submissions (`/admin/requirements`) |
| **SIS modules** | Student profiles, academic history, admissions, scheduling, attendance, billing, reports |
| **Student portal** | View grades, submit enrollment requirements, download COR (PDF) |
| **COR PDF** | Auto-generated Certificate of Registration with tuition and fee breakdown (DomPDF) |

---

## Tech Stack

- **Backend:** PHP 8.2+, Laravel 11
- **Database:** MySQL / MariaDB
- **Frontend:** Bootstrap 5 (admin/student portals), Tailwind CSS + Vite (auth/welcome pages)
- **PDF:** [barryvdh/laravel-dompdf](https://github.com/barryvdh/laravel-dompdf)
- **Auth:** Laravel Breeze (session-based), dual guards (`web` for admins, `student` for students)

---

## Prerequisites

Install the following before setting up the project:

| Requirement | Version / Notes |
|-------------|-----------------|
| **PHP** | 8.2 or higher |
| **Composer** | Latest stable |
| **Node.js & npm** | Required for Vite asset build (login/register pages) |
| **MySQL or MariaDB** | 5.7+ / 10.3+ |
| **PHP extensions** | `openssl`, `pdo`, `pdo_mysql`, `mbstring`, `tokenizer`, `xml`, `ctype`, `json`, `bcmath`, `fileinfo`, `dom` |

### Optional: XAMPP (Windows)

[XAMPP](https://www.apachefriends.org/) is a convenient way to get PHP, MySQL, and phpMyAdmin on Windows:

1. Install XAMPP and start **Apache** and **MySQL** from the XAMPP Control Panel.
2. Add PHP to your system `PATH` (e.g. `C:\xampp\php`) so `php` and `composer` work in PowerShell.
3. Use **phpMyAdmin** (`http://localhost/phpmyadmin`) to create the database.
4. Default XAMPP MySQL credentials: username `root`, empty password.

---

## Installation

Follow these steps after cloning the repository from GitHub.

### 1. Clone the repository

**PowerShell (Windows):**

```powershell
git clone https://github.com/YOUR_USERNAME/SIS-main.git
cd SIS-main
```

**Bash (Linux / macOS):**

```bash
git clone https://github.com/YOUR_USERNAME/SIS-main.git
cd SIS-main
```

> Replace `YOUR_USERNAME/SIS-main` with the actual GitHub repository URL.

### 2. Install PHP dependencies

```powershell
composer install
```

### 3. Create environment file

**PowerShell (Windows):**

```powershell
Copy-Item .env.example .env
```

**Bash:**

```bash
cp .env.example .env
```

### 4. Generate application key

```powershell
php artisan key:generate
```

### 5. Configure `.env`

Open `.env` and set at minimum:

```env
APP_NAME="Student Information System"
APP_URL=http://127.0.0.1:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=sis
DB_USERNAME=root
DB_PASSWORD=

# Optional — used on COR PDF output (defaults shown if omitted)
SCHOOL_NAME="Your School Name"
SCHOOL_LOCATION="City, Province"
COR_TUITION_RATE_PER_UNIT=350
```

| Variable | Purpose |
|----------|---------|
| `APP_URL` | Base URL of the app (must match how you access it in the browser) |
| `DB_*` | MySQL connection settings |
| `SCHOOL_NAME` | School name printed on COR PDF (default: `BUKIDNON STATE UNIVERSITY`) |
| `SCHOOL_LOCATION` | Campus location on COR PDF (default: `Malaybalay City, Bukidnon`) |
| `COR_TUITION_RATE_PER_UNIT` | Per-unit tuition rate for COR calculations (default: `350`) |

> **Note:** `.env.example` uses `DB_DATABASE=Dagooc-SIS`. You may keep that name or choose your own — just create the matching database in MySQL.

### 6. Create the MySQL database

**Option A — phpMyAdmin (XAMPP):**

1. Open `http://localhost/phpmyadmin`
2. Click **New** and create a database (e.g. `sis` or `Dagooc-SIS`)
3. Collation: `utf8mb4_unicode_ci`

**Option B — MySQL CLI:**

```sql
CREATE DATABASE sis CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

**PowerShell (if `mysql` is in PATH):**

```powershell
mysql -u root -e "CREATE DATABASE sis CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
```

### 7. Run migrations

```powershell
php artisan migrate
```

This creates all tables including:

- `users` — admin/staff accounts
- `students` — student accounts (separate auth guard)
- `subjects`, `grades`, `enrollments`
- `requirement_submissions`, `interview_schedules`
- `academic_records`, `class_schedules`, `attendance_records`, `billing_records`
- `sessions`, `cache`, `jobs` (used by session/cache/queue drivers)

### 8. Seed the database

#### Default seeder (admin user)

```powershell
php artisan db:seed
```

Creates one **admin user** and one **demo student**:

| Role | Email | Password |
|------|-------|----------|
| Admin | `admin@example.com` | `password` |
| Student | `student@example.com` | `password` |

> Public admin registration is disabled. New admin accounts must be created via the database seeder or directly in the database.

#### Optional seeders (sample data)

`DatabaseSeeder` does **not** call the other seeders automatically. Run them separately in this order:

```powershell
php artisan db:seed --class=SubjectSeeder
php artisan db:seed --class=GradeSeeder
php artisan db:seed --class=StudentSeeder
php artisan db:seed --class=EnrollmentSeeder
```

| Seeder | Creates |
|--------|---------|
| `SubjectSeeder` | 20 sample subjects |
| `GradeSeeder` | 10 sample grade records |
| `StudentSeeder` | 50 sample students (password: `password`) |
| `EnrollmentSeeder` | 100 sample enrollments (defaults: school year `2025-2026`, semester `1st Semester`) |

To find a seeded student email for login:

```powershell
php artisan tinker --execute="echo App\Models\Student::first()->email;"
```

All factory-generated students use the password **`password`**.

### 9. Link storage (required for requirement uploads)

```powershell
php artisan storage:link
```

Student requirement documents are stored on the `public` disk under `storage/app/public/requirements/`.

### 10. Install and build frontend assets

Required for the **login** and **welcome** pages (Vite + Tailwind). Admin and student portals use Bootstrap via CDN and work without a build, but auth pages need compiled assets.

```powershell
npm install
npm run build
```

For active frontend development with hot reload:

```powershell
npm run dev
```

Or run the full dev stack (server + queue + Vite) via Composer:

```powershell
composer dev
```

### 11. Start the application

```powershell
php artisan serve
```

Open [http://127.0.0.1:8000](http://127.0.0.1:8000) in your browser.

---

## Accessing Admin vs Student Portals

Both roles use the **same login page**: [http://127.0.0.1:8000/login](http://127.0.0.1:8000/login)

The system tries the `web` guard (admin) first, then the `student` guard. You are redirected automatically based on account type.

### Admin portal

| Item | Value |
|------|-------|
| Login | `admin@example.com` / `password` (after `db:seed`) |
| Dashboard | `/dashboard` |
| Student list | `/students` |
| Subject list | `/subjects` |
| Interview calendar | `/admin/interviews` |
| Requirements review | `/admin/requirements` |
| Modules | `/modules/students`, `/modules/academic-history`, `/modules/admissions`, etc. |
| Profile | `/profile` |

Admin accounts cannot be created via a public registration page.

### Student portal

| Item | Value |
|------|-------|
| Login | `student@example.com` / `password` (after `db:seed`), or any student email from the `students` table |
| Dashboard (grades) | `/student/dashboard` |
| Requirements | `/student/requirements` |
| COR download | `/student/cor/download` |
| Profile (edit name, email, password) | `/student/profile` |

> Use an email that exists in the `students` table, not `users`. Admin credentials will not log into the student portal.

---

## Testing Key Features

### COR (Certificate of Registration) PDF

1. Seed students and enrollments (see step 8).
2. Log in as a student who has enrollments for **2025-2026** / **1st Semester** (factory defaults).
3. Go to **Student Dashboard** → use the school year/semester dropdowns → **Download COR (PDF)**.
4. Or visit `/student/cor/download?school_year=2025-2026&semester=1st%20Semester`.

Customize school branding via `SCHOOL_NAME`, `SCHOOL_LOCATION`, and `COR_TUITION_RATE_PER_UNIT` in `.env`.

### Requirements submission

**Student side:**

1. Log in as a student → **Requirements** (`/student/requirements`).
2. Upload documents (PDF, JPG, PNG; max 5 MB) for items such as Form 138, Good Moral, Birth Certificate, etc.

**Admin side:**

1. Log in as admin → **Requirements Review** (`/admin/requirements`).
2. Approve or reject submissions and add remarks.

> `php artisan storage:link` must be run or uploads will fail.

### Interview calendar

1. Log in as admin → **Interview Calendar** (`/admin/interviews`).
2. Select a first-year or pending-enrollment student.
3. Create, edit, or delete interview events on the calendar.

---

## Project Structure (high level)

```
app/
  Http/Controllers/     # COR, enrollments, interviews, requirements, modules
  Models/               # User, Student, Enrollment, RequirementSubmission, etc.
database/
  migrations/           # Schema for students, enrollments, interviews, billing, etc.
  seeders/              # DatabaseSeeder, StudentSeeder, SubjectSeeder, etc.
resources/views/
  layouts/              # mainlayout (admin), studentlayout (student)
  cor/                  # COR PDF Blade template
  requirements/         # Admin and student requirement views
  interviews/           # Interview calendar
routes/
  web.php               # Admin, student, and module routes
  auth.php              # Login, register, password reset (Breeze)
```

---

## Troubleshooting

### `MissingAppKeyException` / "No application encryption key"

```powershell
php artisan key:generate
```

Ensure `APP_KEY` is set in `.env`.

### `SQLSTATE[HY000] [2002] Connection refused`

- MySQL/MariaDB is not running. Start it (XAMPP Control Panel → **Start** MySQL, or your system service).
- Check `DB_HOST`, `DB_PORT`, `DB_USERNAME`, and `DB_PASSWORD` in `.env`.

### `SQLSTATE[HY000] [1045] Access denied for user`

- Wrong `DB_USERNAME` or `DB_PASSWORD` in `.env`.
- On XAMPP, the default user is `root` with an empty password.

### `SQLSTATE[HY000] [1049] Unknown database`

Create the database (see step 6) and confirm `DB_DATABASE` matches the name you created.

### `Base table or view not found`

```powershell
php artisan migrate
```

### `Vite manifest not found` / unstyled login page

```powershell
npm install
npm run build
```

For development, run `npm run dev` in a separate terminal while `php artisan serve` is running.

### Requirement uploads fail or files not visible

```powershell
php artisan storage:link
```

Confirm `FILESYSTEM_DISK=local` and that `storage/app/public` is writable.

### COR download shows "No enrollment records found"

- The logged-in student has no enrollments for the selected school year and semester.
- Seed enrollments or create them via the admin **Enrollment** module (`/student/enroll`).
- Default COR filters: `school_year=2025-2026`, `semester=1st Semester`.

### Admin routes redirect to email verification

The default seeded admin has `email_verified_at` set. New admin users must be added via seeder or database — there is no public registration.

### `Class "DOMDocument" not found` (PDF errors)

Enable the PHP `dom` extension. On XAMPP, uncomment `extension=dom` in `php.ini` and restart Apache.

### Permission errors on `storage/` or `bootstrap/cache/`

**Linux / macOS:**

```bash
chmod -R 775 storage bootstrap/cache
```

**Windows:** Ensure your user account has write access to those folders.

---

## Development commands (reference)

| Command | Purpose |
|---------|---------|
| `php artisan serve` | Start local dev server |
| `php artisan migrate` | Run database migrations |
| `php artisan migrate:fresh --seed` | Drop all tables, re-migrate, run `DatabaseSeeder` only |
| `php artisan db:seed --class=StudentSeeder` | Run a specific seeder |
| `php artisan storage:link` | Create `public/storage` symlink |
| `npm run dev` | Vite dev server with HMR |
| `npm run build` | Production frontend build |
| `composer dev` | Serve + queue listener + Vite concurrently |
| `php artisan test` | Run PHPUnit tests |

---

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).


## Security & Accounts
- Public self-registration is disabled. No /register route or controller exists.
- Admin accounts are created only via php artisan db:seed (ADMIN_EMAIL/ADMIN_PASSWORD env overrides) or the DB directly. The dmin middleware gates all admin routes behind users.is_admin = true.
- Students log in from the same /login page; they are redirected to the student portal and can edit their name, email, and password at /student/profile.
- Debug is off, HTTPS is forced in production, session data is per-user, and all admin mutations require the admin middleware.



## Deploying to Vercel + Supabase

1. Create a Supabase project, then grab the Postgres connection details (Database ? Settings ? Connection string, use the 'Session pooler' or direct host).
2. In Vercel, import the Git repo. Set these Environment Variables:
   - APP_NAME, APP_ENV=production, APP_KEY (run php artisan key:generate --show locally), APP_DEBUG=false`n   - APP_URL=https://your-app.vercel.app`n   - DB_CONNECTION=pgsql, DB_HOST, DB_PORT=5432, DB_DATABASE=postgres, DB_USERNAME, DB_PASSWORD, DB_SSLMODE=require (from Supabase)
   - SESSION_SECURE_COOKIE=true, CACHE_STORE=database, QUEUE_CONNECTION=database, SESSION_DRIVER=database`n   - ADMIN_EMAIL, ADMIN_PASSWORD (used when seeding)
3. The ercel composer script runs config:cache, oute:cache, iew:cache, and migrate --force during build. After the first deploy, seed once with: php artisan db:seed --force run via a one-off command (e.g. ercel env pull + local run against Supabase).
4. Static files under public/ are served directly; everything else routes through pi/index.php (the PHP serverless handler). Writable storage is redirected to /tmp for serverless compatibility.

