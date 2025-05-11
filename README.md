# PIDEV Symfony Application

## Description
**PIDEV** is a Symfony-based web application designed to manage various user roles and functionalities, including administrators, experts, suppliers, and farmers. The application provides features such as user registration, password reset, event management, product management, and PDF export of user data. It also includes a dashboard for administrators to manage users and view statistics.

## Table of Contents
- [Features](#features)
- [Installation](#installation)
- [Usage](#usage)
- [Technologies Used](#technologies-used)
- [Contributing](#contributing)
- [License](#license)
- [Keywords](#keywords)

## Features
- **User Management**: Registration, login, and role-based access control for administrators, experts, suppliers, and farmers.
- **Password Reset**: Secure password reset functionality via email.
- **Event Management**: Create, update, and manage events.
- **Product Management**: Manage products with details like name, description, quantity, and price.
- **Dashboard**: Admin dashboard with user statistics and management tools.
- **PDF Export**: Export user data to PDF using Dompdf.
- **Responsive Design**: Frontend built with responsive styles for a seamless user experience.

## Installation

1. **Clone the repository**:
   ```bash
   git clone https://github.com/username/pidev-symfony.git
   cd pidev-symfony
   ```

2. **Install dependencies**:
   ```bash
   composer install
   npm install
   ```

3. **Configure the environment**:
   - Copy `.env` to `.env.local` and update your database credentials.

4. **Run migrations**:
   ```bash
   php bin/console doctrine:migrations:migrate
   ```

5. **Start the development server**:
   ```bash
   symfony server:start
   ```

6. **Build assets**:
   ```bash
   npm run dev
   ```

## Usage
- Access the application at: [http://localhost:8000](http://localhost:8000).
- Use the admin dashboard to manage users, events, and products.
- Register as a user with different roles (e.g., expert, supplier, farmer) to explore role-specific features.

## Technologies Used
- **Backend**: Symfony Framework
- **Frontend**: Twig, SCSS, Bootstrap
- **Database**: MySQL
- **PDF Generation**: Dompdf
- **JavaScript**: Vanilla JS, jQuery
- **CSS Framework**: SB Admin 2

## Contributing
Contributions are welcome! Please follow these steps:

1. Fork the repository.
2. Create a new branch:
   ```bash
   git checkout -b feature-name
   ```
3. Commit your changes:
   ```bash
   git commit -m "Add feature-name"
   ```
4. Push to the branch:
   ```bash
   git push origin feature-name
   ```
5. Open a pull request.

## License
This project is licensed under the MIT License. See the [LICENSE](LICENSE) file for details.

## Keywords
Symfony, User Management, Dashboard, PDF Export, Event Management, Product Management, Role-Based Access Control, Responsive Design, Web Application
