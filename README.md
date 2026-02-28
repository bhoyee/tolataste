# TolaTaste (TolaTaste of Africa)

Production Laravel 9 application for an online restaurant/storefront: customers browse a menu, place pickup/delivery orders (including guest checkout), pay online, and receive confirmations. Admins manage products, orders, customers, and site content via an admin panel. A POS module is included under `Modules/POS`.

## What it does

- **Customer ordering**
  - Product/menu browsing, cart, checkout (pickup/delivery), tips, coupons/discounts
  - Guest checkout support (stores guest record + order)
  - Order scheduling (preorder vs. same-day time selection)
- **Payments**
  - Stripe, PayPal, Mollie, Razorpay, Flutterwave, Paystack, Instamojo, SSLCommerz (availability depends on configuration)
- **Notifications**
  - Email order confirmations (SMTP)
  - Optional SMS (BulkSMS helper)
  - Optional WhatsApp admin alert (Twilio WhatsApp helper)
  - Push notifications to admins via FCM (where enabled)
- **Admin**
  - Order management + order status updates
  - Product/category/content management
  - Customer management

## Tech stack

- PHP 8.x, **Laravel 9**
- MySQL
- Vite + (some) React assets (see `resources/` + `vite.config.js`)
- `nwidart/laravel-modules` for modular features (`Modules/`)

## Local development (Windows/macOS/Linux)

Prereqs: PHP 8.x, Composer, Node.js + npm, and a MySQL database.

```bash
composer install
npm install
cp .env.example .env
php artisan key:generate
php artisan migrate
npm run dev
php artisan serve
```

If you need public storage:

```bash
php artisan storage:link
```

## Configuration notes (important)

- **Do not commit secrets**: `.env` and `secure/` are ignored by `.gitignore`.
- **Mail config**: SMTP is configured via `.env` and/or the database (see `app/Helpers/MailHelper.php`).
- **Stripe keys**: this app reads Stripe credentials from the database model `App\Models\StripePayment` (configured in the admin payment settings), not from `STRIPE_SECRET` in `.env`.
- **WhatsApp (Twilio)**: set `TWILIO_SID`, `TWILIO_AUTH_TOKEN`, `TWILIO_WHATSAPP_NUMBER`, and `MY_WHATSAPP_NUMBER` in `.env`.
- **SMS (BulkSMS)**: set `BULKSMS_USERNAME` and `BULKSMS_PASSWORD` in `.env`.

## Repo layout (high level)

- `app/` Laravel application code (controllers, jobs, mail, helpers)
- `Modules/` feature modules (includes `Modules/POS`)
- `resources/` Blade views + frontend assets
- `routes/` web + API routes
- `config/` Laravel configuration

## License

This repository contains application code for TolaTaste. If you’re evaluating this project (recruiter/partner), contact the owner for usage permissions.

