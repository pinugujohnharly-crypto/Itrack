# Itrack – Capstone Tracker

Interactive platform for the College of Computer Studies to organize, track, and manage capstone projects from proposal to final submission. The landing page now uses Bootstrap 5 for a clean, responsive experience.

## Quick Start

- Requirements: XAMPP/LAMP/WAMP (Apache + PHP + MySQL)
- Clone/copy this repo into your web root (e.g., `htdocs/Itrack`).
- Import the database: `sql/capstone_tracker.sql` (or `capstone_tracker.sql` in the project root).
- Configure credentials in `database.php`.
- Start Apache and MySQL, then open `http://localhost/Itrack/Homescreen.php`.

## Key Pages

- `Homescreen.php`: Bootstrap 5 landing page with About and Objectives
- `Signup.php`: Registration page
- `dashboard.php`: App dashboard after login

## Project Context

The main goal of the College of Computer Studies’ Interactive Digital Platform for Tracking Capstone Projects is to make it easier for students, teachers, and staff to keep track of capstone projects and how far along each one is. More specifically, the platform aims to create one system where everyone involved can easily manage and follow each project’s progress. It also helps make the process of submitting project ideas and final outputs more organized and smoother, reducing confusion or delays. Lastly, it gives faculty advisers better tools to monitor student progress, provide feedback, and approve work, making it easier for them to guide students through their capstone journey.

### General Objective

Create an uncomplicated platform enabling students, staff, and teachers to track capstone projects for each project.

### Specific Objectives

1. Develop a centralized system that allows students and faculty to efficiently organize, track, and manage capstone projects.
2. Provide a systematic procedure for project ideas and final submissions to improve the submission and approval process.
3. Create better monitoring and collaboration through simpler tools for advisers to analyze, advise on, and approve capstone work.

## Tech Notes

- UI: Bootstrap 5 (CDN) + Font Awesome
- Backend: PHP + MySQL (see `database.php` and `api/` endpoints)
- Optional: Webpack bundling is available for `/src` assets (see `package.json` and `webpack.config.js`). T
## Authors

- Kyle Austin Nagares
- John Harly Pinugu
