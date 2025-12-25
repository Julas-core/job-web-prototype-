# JOBLaunch Prototype

A student-built job portal prototype created by Computer Science students at Mekelle University. The app is transitioning from static HTML to a dynamic Core PHP + MySQL site.

## Overview

JOBLaunch enables two user roles:
- Job seekers: browse jobs and apply.
- Employers: post jobs and review applications.

## Prototype Status & Final Submission
- This repository is a prototype running on Core PHP + MySQL for quick iteration.
- The final submission will migrate backend services to Supabase (PostgreSQL + auth + storage) to deliver a managed BaaS deployment.
- Expect changes to connection/config, auth flows, and data models when the Supabase version is prepared for submission.

## Tech Stack
- Core PHP (no framework)
- MySQL (`mysqli` with prepared statements)
- HTML/CSS (static pages progressively upgraded to PHP)

## Project Structure
- Root public pages: `index.php`, `index.html`, `login.html`, `register.html`, `about.html`, `contact.html`, `catagories.html`, `jobs_list.html`
- Dashboards and views (prototype): `Users/`
	- `employer_dashboard.html`, `seeker_dashboard.html`, `post_job.html`, `job_detail.html`, `my_posting.html|.php`, `view_applications.html`, etc.
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
4. Place the project under your web root (e.g., `C:\xampp\htdocs\job-web`if you're using xampp, `C:\wamp64\www\job-web` if you're using wamp) or run the PHP built-in server:
	 ```
	 php -S localhost:8000 -t path\to\job-web(prototype)
	 ```

## Database Notes
- Ensure the following tables exist and align with the code references:
	- `users`: `user_id` (PK), `email` (unique), `password_hash`, `roles` (values like `job_seeker` or `company`).
	- `company`: includes `company_id`, `user_id`, `company_name`, etc.
	- `job_seeker`: includes `user_id`, `fullname`, `profession_title`, etc.
	- `jobs`: includes `job_id`, `company_id`, `title`, `location`, `type`, `salary`, `created_at`.
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


**JOBLaunch**
This is a prototype version of JOBLaunch site that is being developed by Computer Science Students of Mekelle University, it has some basic features that are listed below:

**features**
*Authentication* : users can sign in as either job seekers or employers.
*Job-posting* : company's / employers can post jobs that job seekers can then click apply to.
*Job-Application* : job seekers can click apply to the jobs that are posted by employers.
