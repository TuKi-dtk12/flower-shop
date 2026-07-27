# 🌸 Tuki Fresh Flower - Secure Luxury E-commerce Platform

## 🌐 Live Demo & Deployment

The project has been successfully deployed and is currently live. You can check out the live demo here:

👉 **[tu4nk13t.dev](https://tu4nk13t.dev/)**

A full-stack, highly secure e-commerce platform built with **Laravel 11**, focusing on strict application security (AppSec), optimal data integrity, and a premium "Dark Luxury" user interface.

## 🚀 Technical Highlights & Core Features

This project was built to demonstrate not just web development, but **System Architecture** and **Defensive Programming**.

### 🛡️ 1. Enterprise-Grade Security (AppSec)
- **Role-Based Access Control (RBAC):** Multi-layered middleware isolating the Admin Panel from regular users to prevent Privilege Escalation.
- **Anti-Web Shell & Path Traversal:** Implemented a highly secure file upload pipeline for product reviews. Utilizes Server-side MIME validation and automatic UUID renaming before storing in isolated public directories.
- **Strict Password Enforcement:** Mitigates brute-force/dictionary attacks by enforcing Laravel's rigorous password policies (`Password::min(8)->mixedCase()->symbols()`).
- **SQLi & XSS Prevention:** Exclusively utilizes Eloquent ORM (PDO Parameter Binding) against SQL injections, and strict Blade templating engines to sanitize outputs.
- **Denial of Inventory Protection:** Capped cart quantities strictly at the controller level to prevent automated scripts from hoarding inventory and crashing the database.

### 🛒 2. Architecture & Data Integrity
- **Database-Backed Cart:** Replaced volatile Session carts with a scalable relational database approach. This ensures data persistence across devices and prevents data loss upon session regeneration.
- **Database Transactions:** The entire checkout flow is wrapped in `DB::transaction`. Creating orders, transferring cart items, and purging the cart happens atomically—preventing orphan data if any step fails.

### 🤖 3. API Integrations
- **AI Consultant (Tuki Chatbox):** Integrated **Google Gemini API** to create a real-time, context-aware virtual assistant that recommends flowers based on user inputs and budget.
- **Dynamic Contactless Payments:** Integrated the **VietQR API** to dynamically generate EMVCo-standard QR codes mapped exactly to the order's total and the Admin's banking configuration.

### 💎 4. "Dark Luxury" UI/UX
- Entirely customized interface using **Tailwind CSS**.
- Responsive Grid/Flexbox layouts, interactive product galleries (Vanilla JS), and modern glass-morphism effects tailored for a premium user experience.

---

## 💻 Tech Stack
- **Backend:** PHP 8.2, Laravel 11, Eloquent ORM
- **Frontend:** Tailwind CSS, Blade Templates, Vanilla JS
- **Database:** MySQL 8
- **External APIs:** Gemini AI (Google), VietQR API

---

## 🛠️ Local Setup Instructions

1. **Clone the repository:**
   ```bash
   git clone https://github.com/your-username/tuki-fresh-flower.git
   cd tuki-fresh-flower
   ```

2. **Install Dependencies:**
   ```bash
   composer install
   npm install && npm run build
   ```

3. **Environment Setup:**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
   *Note: You must configure your `DB_*` variables and set `GEMINI_API_KEY=your_key_here` in the `.env` file.*

4. **Database Migration & Seeding:**
   ```bash
   php artisan migrate --seed
   ```

5. **Storage Link & Serve:**
   ```bash
   php artisan storage:link
   php artisan serve
   ```

---
> **Developer Note for Recruiters:** This project heavily emphasizes robust backend logic, relational data management, and proactive mitigation of OWASP Top 10 vulnerabilities over simple CRUD operations.
