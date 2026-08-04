<div align="center">

# 🎬 CinemaLaravel

**A full-stack cinema ticket booking web application built with Laravel 9**

[![PHP](https://img.shields.io/badge/PHP-8.0+-777BB4?style=flat-square&logo=php)](https://php.net/)
[![Laravel](https://img.shields.io/badge/Laravel-9-FF2D20?style=flat-square&logo=laravel)](https://laravel.com/)
[![MySQL](https://img.shields.io/badge/MySQL-8-4479A1?style=flat-square&logo=mysql)](https://www.mysql.com/)
[![Socialite](https://img.shields.io/badge/OAuth-Google_|_GitHub-4285F4?style=flat-square&logo=google)](https://laravel.com/docs/socialite)

<br/>

> Browse the movie catalog, pick a session, choose your ticket count,
> and complete a booking — all with Google or GitHub OAuth login,
> or a classic email/password account.

</div>

---

## 📋 Table of Contents

- [Features](#-features)
- [How It Works](#-how-it-works)
- [Database Schema](#-database-schema)
- [Routes](#-routes)
- [Tech Stack](#-tech-stack)
- [Getting Started](#-getting-started)
- [Environment Variables](#-environment-variables)
- [Project Structure](#-project-structure)

---

## ✨ Features

### 👤 Authentication
- Email/password registration — password hashed with MD5 + salt
- Login with **Google** OAuth (Laravel Socialite)
- Login with **GitHub** OAuth (Laravel Socialite)
- Cookie-based session token (`tokenU`) for authenticated requests

### 🎥 Movie Catalog
- Browse all movies with poster images and genre labels
- Filter movies by genre/style
- Movie detail page — description, age rating, director, sessions, comments

### 🎟️ Ticket Booking
- Select a session by date and time
- Choose ticket count — availability validated in real time
- Enter credentials → purchase confirmation
- Booked seats deducted from session availability automatically

### 💬 Comments
- Logged-in users can leave comments on any movie
- Rate-limited to **once per 5 minutes** per movie per user

### 🛡️ Admin Panel
- Add new movies with poster upload (auto-resized to 200×250 px)
- Add screening sessions (date, ticket count, price)
- Edit or delete movies (cascades to sessions and reservations)
- User list with search by login
- Toggle admin privileges for any user

---

## 🔬 How It Works

```
User visits /films
        │
        ├── Not logged in → browse only, no booking
        │
        └── Logged in (cookie tokenU) ──────────────────┐
                │                                        │
        Browse movies (/films)                    Admin routes
                │                                 (isAdmin = 1)
        Select movie (/films/{id})                       │
                │                            ┌───────────┼───────────┐
        View sessions + comments        Add movie   Add session  Manage users
                │
        Buy tickets (/films/{id}/tickets)
                │
        Pick session + count
                │
        Check availability
        (CountBilets - count >= 0 ?)
                │
        Enter credentials (/credentials)
                │
        POST /complate
        ┌───────────────────────────────┐
        │ SeatReservation created       │
        │ session.CountBilets -= count  │
        │ movie.CountSoldBilets += count│
        └───────────────────────────────┘
                │
        Redirect to movie page with success message
```

---

## 🗄️ Database Schema

### `clients` — User accounts

| Column | Type | Description |
|---|---|---|
| `Login` | string | Unique username |
| `Name` | string | Display name |
| `PhoneNumber` | string | Phone (or "Dont have" for OAuth users) |
| `Email` | string | Unique email |
| `LoginData` | string | MD5 hash of `login + password + "@#sdf@"` salt |
| `Token` | string | Session token stored in cookie `tokenU` |
| `isAdmin` | boolean | Admin flag |
| `GoogleID` | string | Google OAuth user ID |
| `GitHubID` | string | GitHub OAuth user ID |

### `movies` — Film catalog

| Column | Type | Description |
|---|---|---|
| `Name` | string | Movie title |
| `Description` | text | Synopsis |
| `Age` | string | Age rating |
| `Style` | string | Genre |
| `Director` | string | Director name |
| `CountSoldBilets` | int | Total tickets sold (all time) |
| `ImageID` | FK | References `images.id` |

### `images` — Movie posters

| Column | Description |
|---|---|
| `Name` | Original filename |
| `Path` | Absolute path on disk (`storage/images/`) |

### `movie_sessions` — Screenings

| Column | Description |
|---|---|
| `MovieID` | FK → `movies.id` |
| `DataSee` | Session datetime |
| `CountBilets` | Remaining available tickets |
| `Price` | Ticket price |

### `seat_reservations` — Bookings

| Column | Description |
|---|---|
| `ClientID` | FK → `clients.id` |
| `SessionID` | FK → `movie_sessions.id` |
| `CountBilets` | Number of tickets purchased |

### `clients_commentaries` — Movie comments

| Column | Description |
|---|---|
| `MovieID` | FK → `movies.id` |
| `ClientID` | FK → `clients.id` |
| `comment` | Comment text |
| `Date` | Timestamp (rate-limit check) |

---

## 🗺️ Routes

### Public

| Method | URL | Description |
|---|---|---|
| `GET` | `/` | Home page |
| `GET` | `/registration` | Registration form |
| `POST` | `/rg` | Submit registration |
| `GET` | `/registration/auth/redirect/google` | Redirect to Google OAuth |
| `GET` | `/registration/auth/redirect/git` | Redirect to GitHub OAuth |
| `GET` | `/auth/google/callback` | Google OAuth callback |
| `GET` | `/auth/git/callback` | GitHub OAuth callback |
| `GET` | `/login` | Login form |
| `POST` | `/lg` | Submit login |
| `GET` | `/films` | Movie catalog |
| `GET` | `/films/{id}` | Movie detail + comments |

### Authenticated

| Method | URL | Description |
|---|---|---|
| `GET` | `/profile` | User profile |
| `GET` | `/profile/logout` | Logout (clears cookie) |
| `GET` | `/films/{id}/tickets` | Select session |
| `GET` | `/films/{id}/pay/{sessionID}` | Ticket count form |
| `POST` | `/films/{id}/pay/{sessionID}/checkData` | Validate ticket count |
| `GET` | `/films/{id}/pay/{sessionID}/{count}/credentials` | Enter details |
| `POST` | `/films/{id}/pay/{sessionID}/complate` | Complete booking |
| `POST` | `/films/{id}/comment` | Post a comment |

### Admin only

| Method | URL | Description |
|---|---|---|
| `GET` | `/films/adminAddMovie` | Add movie form |
| `POST` | `/films/adminAddMovie/addM` | Save new movie |
| `GET` | `/films/adminAddSession` | Add session form |
| `POST` | `/films/adminAddMovie/addS` | Save new session |
| `GET` | `/films/adminSeeUsers` | User list + search |
| `GET` | `/films/adminSeeUsers/{userID}` | Toggle admin for user |
| `GET` | `/films/{id}/edit` | Edit movie form |
| `POST` | `/films/{id}/edit/save` | Save changes / delete movie |

---

## 🛠 Tech Stack

| Technology | Purpose |
|---|---|
| PHP 8.0+ | Server-side language |
| Laravel 9 | MVC framework, routing, Blade templating |
| MySQL | Relational database |
| Laravel Socialite 5 | Google + GitHub OAuth |
| Intervention Image 2 | Poster upload & resize (200×250 px) |
| Blade templates | Server-side HTML rendering |
| Bootstrap (CDN) | UI styling |
| Laravel Sanctum | API token package (included, not used for web auth) |

---

## 🚀 Getting Started

### Prerequisites

- PHP 8.0+
- Composer
- MySQL 8
- A web server (Apache / Nginx) or `php artisan serve`
- Google OAuth credentials (optional)
- GitHub OAuth credentials (optional)

### Installation

```bash
# 1. Clone the repository
git clone https://github.com/vladgnedko0x0/CinemaLaravel.git
cd CinemaLaravel

# 2. Install PHP dependencies
composer install

# 3. Copy and configure the environment file
cp .env.example .env

# 4. Generate the application key
php artisan key:generate

# 5. Create the database, then run migrations
php artisan migrate

# 6. Link storage for image uploads
php artisan storage:link

# 7. Start the development server
php artisan serve
```

Open `http://localhost:8000` in your browser.

---

## ⚙️ Environment Variables

Edit `.env` before running:

```env
# Application
APP_NAME=CinemaLaravel
APP_URL=http://localhost:8000

# Database
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=cinema
DB_USERNAME=root
DB_PASSWORD=

# Google OAuth — create at console.cloud.google.com
GOOGLE_CLIENT_ID=
GOOGLE_CLIENT_SECRET=
GOOGLE_REDIRECT_URI=http://localhost:8000/auth/google/callback

# GitHub OAuth — create at github.com/settings/developers
GITHUB_CLIENT_ID=
GITHUB_CLIENT_SECRET=
GITHUB_REDIRECT_URI=http://localhost:8000/auth/git/callback
```

> Google and GitHub OAuth are **optional** — email/password registration works without them.

---

## 📁 Project Structure

```
CinemaLaravel/
├── app/
│   ├── Http/
│   │   └── Controllers/
│   │       ├── HomeController.php          # / and /profile routes
│   │       ├── LoginController.php         # Login + OAuth cookie logic
│   │       ├── RegistrationController.php  # Register + Google/GitHub OAuth
│   │       ├── MoviesController.php        # Full movie CRUD + admin + comments
│   │       └── PayController.php           # Ticket booking flow
│   └── Models/
│       ├── Clients.php                     # Custom user model
│       ├── Movie.php                       # Film
│       ├── MovieSession.php                # Screening session
│       ├── SeatReservation.php             # Booking record
│       ├── Images.php                      # Poster image
│       └── ClientsCommentaries.php         # Movie comment
│
├── database/migrations/                    # All table definitions
├── resources/views/
│   ├── layouts/default.blade.php           # Base layout (nav, Bootstrap)
│   ├── Home/                               # Home + Profile views
│   ├── Login/                              # Login view
│   ├── Registartion/                       # Registration view
│   ├── Movies/                             # Catalog, detail, admin views
│   └── Pay/                               # Booking flow views
│
├── routes/web.php                          # All web routes
├── .env.example                            # Environment template
└── composer.json                           # PHP dependencies
```

---

<div align="center">

Made with PHP · Laravel 9 · MySQL · Laravel Socialite

</div>
