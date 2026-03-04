# Darpon Institute

Darpon Institute is a modern web application designed for comprehensive administrative, e-commerce, and logistics management. Built with a robust technology stack, it provides specialized features like product management, dynamic invoicing, advanced delivery logic, and integrated courier tracking specifically tailored to the local market needs.

## 🚀 Tech Stack

- **Framework**: [Laravel 12](https://laravel.com/) (PHP ^8.2)
- **Frontend**: [React](https://react.dev/), [Inertia.js 2.0](https://inertiajs.com/), [Tailwind CSS](https://tailwindcss.com/)
- **Database**: MySQL
- **PDF Generation**: [barryvdh/laravel-dompdf](https://github.com/barryvdh/laravel-dompdf)
- **Courier & Logistics APIs**: 
  - Steadfast Courier Laravel Package
  - Courier Fraud Checker BD

## 🛠️ Key Features

- **Store & Product Management**: Comprehensive catalog with specific attributes, variable pricing, and stock margin features.
- **Advanced Cart & Checkout Logic**: Dynamic free delivery conditions based on minimum weight values and other complex requirements.
- **Dynamic Invoicing System**: Custom invoicing featuring data points like Freight Charges and specific product breakdowns using DOMPDF.
- **Dashboard & Analytics**: Accurate sales calculations, COGS (Cost of Goods Sold), and profit margin tracking metrics.
- **Courier Integration**: Built-in hooks to verify courier fraud metrics and handle automated shipping methodologies for Steadfast.
- **SEO Ready**: Automated sitemap structure and feed generations using Spatie packages.

## ⚙️ Requirements

- PHP >= 8.2
- Node.js & NPM
- Composer
- MySQL

## 💻 Installation & Setup

1. **Clone the repository or Open the directory:**
   ```bash
   cd darpon
   ```

2. **Install PHP Dependencies:**
   ```bash
   composer install
   ```

3. **Install Node Utilities:**
   ```bash
   npm install
   ```

4. **Environment Setup:**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
   *Make sure to properly configure your database and email credentials in the `.env` file.*

5. **Run Migrations:**
   ```bash
   php artisan migrate
   ```

6. **Start the Application:**
   Start the Laravel backend and Vite frontend development server concurrently using the included script:
   ```bash
   npm run dev
   ```
   
   *Alternatively, manually run them on separate terminal tabs:*
   ```bash
   php artisan serve
   npm run dev
   ```

## 📄 License

This project is proprietary software belonging to **Darpon Institute**.
