# JobLaunch Prototype

A student-built job portal prototype created by Computer Science students at Mekelle University. The app is transitioning from static HTML to a dynamic Core PHP + MySQL site.

## Overview

JOBLaunch enables two user roles:
- Job seekers: browse jobs and apply.
- Employers: post jobs and review applications.

## Prototype Status & Final Submission
- This repository is a prototype running on Core PHP + MySQL for quick iteration.
- The final submission will migrate backend services to Supabase (PostgreSQL + auth + storage) to deliver a managed BaaS deployment.
- Expect changes to connection/config, auth flows, and data models when the Supabase version is prepared for submission.

## Technology Stack
- Core PHP (no framework)
- MySQL (`mysqli` with prepared statements)
- HTML/CSS (static pages progressively upgraded to PHP)

## Project Structure
- Root public pages: `index.php`, `index.html`, `login.php`, `register.php`, `about.php`, `contact.php`, `catagories.php`, `jobs_list.php`
- Dashboards and views (prototype): `Users/`
	- `employer_dashboard.php`, `seeker_dashboard.html`, `post_job.php`, `job_detail.php`, `my_posting.php|.php`, `view_applications.php`, etc.
- Backend logic: `backendwithphp/`
	- `db_conection.php` (MySQL connection; DB name: `job_launch`)
	- `register.php`, `login.php`, `logout.php` (auth + sessions)
	- Feature scripts: `new_jobs.php`, `application.php`, `apply.php`, `company_dashboard.php`, `personal_info.php`, `skill.php`, reporting (`total_*`).

## Key Flows
- Authentication
	- Login form: `login.html` → `backendwithphp/login.php`
	- Register form: `register.html` → `backendwithphp/register.php`
	- On success, users are redirected to `Users/` dashboards.
- Dashboards
	- Employers: `Users/employer_dashboard.html`, posting via `Users/post_job.html` and `backendwithphp/new_jobs.php`.
	- Seekers: `Users/seeker_dashboard.html`, apply via `Users/apply_form.html` and `backendwithphp/apply.php`.
- Home page
	- `index.php` shows latest jobs by joining `jobs` and `company` tables.

## Setup (Windows-friendly)
1. Install a PHP runtime:
	 - Option A: XAMPP/WAMP (recommended for MySQL + PHP).
	 - Option B: PHP CLI + MySQL locally.
2. Create a MySQL database named `job_launch`.
3. Configure credentials in `backendwithphp/db_conection.php`:
	 ```php
	 $servername = "localhost";
	 $username = "root";
	 $password = "";
	 $dbname = "job_launch";
	 ```
4. Run the database schema: Import `backendwithphp/databasescema.sql` into your MySQL database.
5. Start the PHP server: `php -S localhost:8000 -t .`
6. Open http://localhost:8000 in your browser.

## Quick Demo
- The PHP development server is now running at http://localhost:8000
- Static pages (HTML) are accessible.
- For full functionality (login, register, post jobs, apply), set up MySQL as above.
- Core features demonstrated: Navigation, static job listings (once DB is set up).

## Database Notes
- Ensure the following tables exist and align with the code references:
	- `users`: `id` (PK), `email` (unique), `password`, `role` (values like `job_seeker` or `company`), `created_at`.
	- `company`: `id` (PK), `user_id`, `company_name`, `contact_name`, `description`, `representative`, `location`.
	- `job_seeker`: `id` (PK), `user_id`, `fullname`, `profession_title`, `skill_level`, `city`, `primary_interest`, `bio`, `portofilio_link`.
	- `jobs`: `id` (PK), `company_id`, `title`, `description`, `location`, `type`, `requirements`, `salary`, `created_at`.
	- `applications`: `id` (PK), `job_id`, `user_id`, `seeker_id`, `fullname`, `skill_level`, `expected_salary`, `resumee`, `cover`, `telegram`, `portfolio`, `created_at`.
- `index.php` queries: latest jobs via `LEFT JOIN` `jobs` → `company`.

## Security & Coding Patterns
- Use prepared statements for all SQL (see `backendwithphp/register.php`).
- Sessions: `session_start()` used to track `user_id` and `role`.
- Refactor note: `backendwithphp/login.php` currently interpolates variables in SQL; switch to prepared statements for the login query.

## Development Workflow
- Converting prototypes to dynamic pages:
	- When adding functionality to a `Users/*.html` page, convert it to `.php`, add `session_start()`, and fetch data using the `user_id` from the session.
	- Alternatively, keep `.html` and fetch data via AJAX to `backendwithphp/*.php` endpoints.

## Quick Start
1. Register a user via `register.html`.
2. Login via `login.html`.
3. If employer: go to `Users/post_job.html` and create a job.
4. If seeker: browse jobs from `index.php` and apply.

## Roadmap
- Migrate backend to Supabase BaaS (PostgreSQL, Auth, Storage) for the final submission package.
- Convert dashboards in `Users/` from `.html` to `.php`.
- Standardize roles to `job_seeker` and `company` across forms and database.
- Harden authentication with prepared statements in `login.php`.
- Add validation and CSRF protections on forms.
- Add pagination and search for job listings.
