# ST Event Management System

A comprehensive web-based application designed to streamline the process of scheduling events, managing venues, and handling client bookings. This system is built using **PHP** and **MySQL** to provide a seamless experience for event management companies.

## 🚀 Key Features

### 👤 User Roles & Access Control
* **Admin:** Full control over the system, including managing staff and client accounts.
* **Manager:** Can manage events, venues, and bookings but has restricted access to user accounts.
* **Staff:** View-only access to event schedules and bookings.
* **Client:** Self-service portal to request bookings, view booking history, and manage their profile.

### 📅 Event & Venue Management
* **Create Events:** Schedule new events with details like date, time, venue, and capacity.
* **Manage Venues:** Add and update venue details including contact info and capacity.
* **Track Availability:** Prevent double bookings and manage event status (Scheduled/Pending).

### 📝 Booking System
* **Client Requests:** Clients can submit booking requests with specific requirements.
* **Booking Status:** Track bookings as 'Waitlist', 'Confirmed', or 'Cancelled'.
* **My Bookings:** Clients can view the status and details of their own bookings.

## 🛠️ Technologies Used

* **Backend:** PHP (Object-Oriented & Procedural)
* **Database:** MySQL
* **Frontend:** HTML, CSS (Responsive Design)
* **Server:** Apache (XAMPP/WAMP)

## 📦 Installation & Setup

1.  **Clone or Download** this repository to your local server directory (e.g., `htdocs` or `www`).
2.  **Database Setup:**
    * Open `phpMyAdmin` and create a new database named `event_management`.
    * Import the `event_management.sql` file provided in the project root.
3.  **Configuration:**
    * Open `includes/dbconnection.php`.
    * Check if the `$username`, `$password`, and `$database` match your local server settings.
4.  **Run:**
    * Open your browser and go to `http://localhost/ST_new/` (or your folder name).

## 👤 Default Login Credentials (For Testing)

* **Admin:** `admin@test.com` / `admin123` (You may need to create this in your DB first)
* **Staff:** Register a new staff account via the Admin panel.
* **Client:** Register a new account via the Signup page.

---
*Developed by Sahan Tharuka