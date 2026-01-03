# Security Monetize Challenge (Laravel)

## Project Overview
This project is a Capture The Flag (CTF) platform built with **Laravel** and **Filament** and **Livewire**. 
The frontend components have been ported from a previous React-based project (`vite_react_shadcn_ts`) to integrate directly with this Laravel application.

**Current Focus:** This Laravel application is the main project. The root `src` and `server` directories are from the old React implementation and are reference/deprecated.

### Tech Stack
- **Framework:** Laravel 11.x
- **Frontend:** Blade Templates + Tailwind CSS + Livewire
- **Database:** SQLite (Default)
- **Authentication:** Laravel Breeze / Sanctum (Planned)
- **Styling:** Tailwind CSS (via Vite)

## Current Status
- [x] Project Structure Exploration
- [x] Initial README update with project focus
- [ ] Verify Frontend Integration in Laravel
- [ ] Database Setup

## Getting Started
*(Instructions to be added as we configure the environment)*

1.  Clone the repository.
2.  Install dependencies: `composer install` & `npm install`.
3.  Copy `.env.example` to `.env` and configure.
4.  Run migrations: `php artisan migrate`.
5.  Start development server: `php artisan serve`.
