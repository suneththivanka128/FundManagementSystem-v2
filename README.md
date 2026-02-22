# Fund Management System

**Academic Project: HNDIT 2024 - 2nd Semester**

A comprehensive web-based application designed to manage community or organization funds, member registrations, payments, and expenses. Developed as part of the curriculum for the Higher National Diploma in Information Technology (HNDIT).

## Features

### Admin Features
- **Dashboard**: Visualize monthly fund collections with interactive charts.
- **Member Management**: Approve or reject new member registrations and view member messages.
- **Payment Management**: Add and track fund contributions from members.
- **Expense Tracking**: Log and categorize all fund expenditures.
- **Announcements**: Publish important updates for all members.

### User Features
- **Personal Dashboard**: View personal contribution summaries and fund status.
- **Payment History**: Track all past contributions.
- **Expense Transparency**: View a history of all system expenditures.
- **Contact Us**: Send inquiries or messages directly to the administrators.

## Tech Stack
- **Frontend**: HTML5, CSS3, JavaScript
- **Backend**: PHP
- **Database**: MySQL
- **Charts**: Chart.js

## Installation & Setup

1. **Clone the repository**:
   ```bash
   git clone https://github.com/your-username/FundManagementSystem.git
   ```

2. **Database Setup**:
   - Open XAMPP Control Panel and start Apache and MySQL.
   - Go to `http://localhost/phpmyadmin/`.
   - Create a new database named `fund management system`.
   - Import the SQL file located at `DB-SQL Code/fund management system.sql`.

3. **Configuration**:
   - Open `config/database.php`.
   - Update the database credentials (`DB_HOST`, `DB_USER`, `DB_PASS`, `DB_NAME`) to match your local environment.

4. **Run the Application**:
   - Place the project folder in your XAMPP `htdocs` directory.
   - Access the application at `http://localhost/FundManagementSystem-v2/index.php`.

## Project Structure
- `actions/`: PHP scripts for processing form data (Login, Register, Announcements, etc.).
- `api/`: Backend API endpoints returning JSON data for the frontend.
- `config/`: Configuration files for database and menu items.
- `css/`: Stylesheets for various pages.
- `js/`: JavaScript files for interactive features and charts.
- `DB-SQL Code/`: Contains the database schema.
- `ProfilePhoto/`: Directory for uploaded member profile pictures.

## Screenshots
*(Add screenshots here after uploading to GitHub)*

## Contributors

Special thanks to the following friends who contributed to the success of this project:

- **[Sachintha165](https://github.com/Sachintha165)**
- **[rashminda-aluvihare](https://github.com/rashminda-aluvihare)**
- **[dinuka-prasad](https://github.com/dinuka-prasad)**

## License
MIT License

## Contact
For any inquiries, please contact the administrator.
