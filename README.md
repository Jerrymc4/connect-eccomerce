# ConnectCommerce E-commerce Platform

ConnectCommerce is a multi-tenant e-commerce platform that allows businesses to create and manage online stores. The platform provides a comprehensive set of features for managing products, orders, customers, and more.

## Features

- Multi-tenant architecture with dedicated database per store
- Subscription-based pricing plans
- Custom domains for each store
- Comprehensive admin dashboard
- Modern, responsive UI with blue-themed design
- RESTful API for integrations

## Installation

1. Clone the repository:
```bash
git clone https://github.com/yourusername/connect-ecommerce-app.git
cd connect-ecommerce-app
```

2. Install dependencies:
```bash
composer install
npm install
```

3. Set up environment variables:
```bash
cp .env.example .env
php artisan key:generate
```

4. Configure your database in `.env` file.

5. Run migrations and seeders:
```bash
php artisan migrate
php artisan db:seed
```

6. Compile assets:
```bash
npm run dev
```

7. Start the development server:
```bash
php artisan serve
```

## Style Guide

A comprehensive style guide is available at [docs/style-guide.md](docs/style-guide.md). This guide includes detailed information about:

- Color palette
- Typography
- Components
- Form elements
- Interactive elements
- Responsive design guidelines
- Accessibility standards

## Development Notes

- The platform uses Laravel Tenancy package for multi-tenancy
- Each store has its own database named `store_{id}`
- Alpine.js is used for interactive UI components
- Tailwind CSS is used for styling
- PHPUnit is used for testing

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.
