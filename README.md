Travel Shadow 🌍✈️

Travel Shadow is a web-based Tourism Management System developed using PHP and MySQL. The platform simplifies travel planning by allowing users to discover destinations, explore travel packages, make bookings, manage favorites, and interact with tour providers through enquiries and feedback.
The system provides dedicated dashboards for Administrators, Tour Providers, and Travelers, ensuring efficient management of tourism-related services.

📖 Table of Contents

Overview


Features

System Architecture

User Roles

Technology Stack

Database Design

Installation

Screenshots

Security Considerations

Future Enhancements

Contributing

License

🚀 Overview

Travel Shadow aims to bridge the gap between travelers and tour providers by offering a centralized platform for destination discovery and tour package booking.

Core Objectives
Simplify travel planning
Provide online booking facilities
Enable tour provider management
Improve customer-provider communication
Maintain booking and payment records

✨ Features

👤 Traveler Module

User Registration & Login

Browse Destinations

View Package Details

Add Destinations to Favorites

Book Travel Packages

Track Bookings

Online Payment Management

Submit Reviews & Ratings

Send Enquiries

Raise Complaints

View Weather Information


🏢 Tour Provider Module

Provider Registration

Destination Management

Package Management

Image Upload Management

Booking Management

Enquiry Response Management

Complaint Handling


🔐 Admin Module

User Management

Tour Provider Approval

Destination Management

Category Management

Booking Monitoring

Payment Monitoring

Feedback Management

Complaint Resolution


🏗️ System Architecture

+----------------+
|     Users      |
+--------+-------+
         |
         v
+----------------+
|  Web Interface |
| PHP + Bootstrap|
+--------+-------+
         |
         v
+----------------+
| Business Logic |
|      PHP       |
+--------+-------+
         |
         v
+----------------+
| MySQL Database |
+----------------+


👥 User Roles

Traveler

Search and book travel packages while interacting with providers.

Tour Provider

Create and manage destinations, packages, and customer enquiries.

Administrator

Manage the entire system, including users, providers, bookings, and complaints.


🛠️ Technology Stack

Frontend

HTML5

CSS3

Bootstrap

JavaScript

jQuery

Backend

PHP

Database

MySQL

MariaDB

Development Environment

XAMPP

WAMP

LAMP


🗄️ Database Design

Main Tables

Table	Purpose

login	Authentication

user	Traveler information

tour_providers	Provider information

places	Destinations

packages	Tour packages

images	Destination gallery

booking	Booking records

payment	Payment records

favourite	Saved destinations

enquiry	User enquiries

complaint	Complaint management

feedback	Reviews and ratings

categories	Destination categories


⚙️ Installation

Prerequisites

PHP 7.x or higher

MySQL/MariaDB

Apache Server

XAMPP/WAMP/LAMP

Clone Repository

git clone https://github.com/yourusername/travel-shadow.git

Create Database

CREATE DATABASE travel_shadow;

Import Database

mysql -u root -p travel_shadow < db.sql

Configure Database Connection


Update:

connection.php

Example:

$conn = mysqli_connect(
    "localhost",
    "root",
    "",
    "travel_shadow"
);
Run Application

Place the project folder inside:

XAMPP  -> htdocs
WAMP   -> www
LAMP   -> /var/www/html

Open:

http://localhost/travel_shadow

📸 Screenshots

Add screenshots here:

screenshots/
├── homepage.png
├── login.png
├── destinations.png
├── booking.png
├── admin-dashboard.png
└── provider-dashboard.png

Example:

![Home Page](screenshots/homepage.png)
🔒 Security Considerations

Current project improvements recommended:

Implement Password Hashing (bcrypt)
Use Prepared Statements
Add CSRF Protection
Validate File Uploads
Secure Session Management
Improve Access Control
Input Validation & Sanitization
📈 Future Enhancements
Payment Gateway Integration
Email Notifications
SMS Notifications
Google Maps Integration
Advanced Search Filters
Recommendation Engine
REST API Development
Mobile Application
Analytics Dashboard
🎓 Academic Value

This project demonstrates concepts including:

Database Design
CRUD Operations
Authentication Systems
Role-Based Access Control
File Upload Management
Booking Management Systems
Web Application Development
🤝 Contributing

Contributions are welcome.

Fork the repository
Create a new branch
git checkout -b feature/new-feature
Commit changes
git commit -m "Add new feature"
Push branch
git push origin feature/new-feature
Open a Pull Request
📄 License

This project is developed for educational purposes. Consider adding an open-source license such as MIT License before public release.

👨‍💻 Author

Akshay Santhosh

BCA Graduate | Cyber Security Enthusiast | SOC Analyst Aspirant

LinkedIn: Add your profile link here

⭐ If you found this project useful, consider giving it a star on GitHub.
