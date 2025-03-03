﻿
# Event Management System

A **web-based event management system** that allows users to **create, manage, and view events, register attendees, and generate event reports**. 
## Features

- **User Authentication**: Secure login and registration.
- **Event Management**: Users can create, update, and delete their own events.
- **Admin Dashboard**: Admins can manage all events and attendees.
- **Event Registration**: Attendees can register for events.
- **Event Reports**: Generate reports on events and attendees. Admins can also download reports in CSV format.
- **Role-Based Access Control**:
  - **Admin**: Full access to all events and reports.
  - **Users**: Can only edit or delete their own events.
- **Responsive UI**: User-friendly and mobile-responsive design.

## Installation

### Prerequisites
- PHP (>=8.0)
- MySQL Database
- XAMPP (or any local server with Apache and MySQL)

### Steps to Install
1. **Clone the Repository**
   ```sh
   git clone https://github.com/your-username/event-management-system.git
   cd event-management-system
   ```
2. **Set Up Database**
   - Import the provided SQL file (`database.sql`) into MySQL **or** run `schema.php` to generate the database automatically.
   - Configure your database settings in `db/db.php`:
     ```php
     $servername = "localhost";
     $username = "root";
     $password = "";
     $dbname = "event_management";
     ```
3. **Start the Server**
   - If using XAMPP, start **Apache** and **MySQL**.
   - Open `http://localhost/event-management-system/` in your browser.

## Login Credentials for Testing

### Admin Account:
- **Email**: `admin@gmail.com`
- **Password**: `admin12345`

### User Account:
- **Email**: `rajesh@gmail.com`
- **Password**: `12345`

## Folder Structure
```
/event-management-system
│── db/                # Database file
│── includes/          # Header, footer, sidebar
│── css/               # Stylesheets
│── js/                # JavaScript files
│── index.php          # Homepage
│── dashboard.php      # Admin dashboard
│── all_events.php     # Event list (paginated, sortable, filterable)
│── create_event.php   # Create event page
│── register_attendee.php # Attendee registration
│── event_reports.php  # Reports page (CSV export)
│── config.php         # Database connection file
│── logout.php         # Logout functionality
│── README.md          # Project documentation
```

## Contributing
If you'd like to contribute, please fork the repository and submit a pull request.

## License
This project is open-source and available under the [MIT License](LICENSE).

## Contact
For any inquiries, feel free to reach out via GitHub issues or email me at **rajeshmondalcse@gmail.com**.

## Live Demo 
Check out the live version of the Event Management System here: **https://live.rajeshmondal.info/**.

