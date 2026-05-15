# Project Details - Fresh Flower Selling Website

## 1. Project Overview

**Introduction**
Fresh Flower is a modern ecommerce platform focused on curated floral gifts and premium customer experience. The project delivers an elegant storefront, efficient order processing, and an AI-powered consultant to assist customers in selecting the right bouquets.

**Objectives**
- Provide a premium, floral-themed shopping experience across devices.
- Enable administrators to manage products and categories efficiently.
- Streamline cart, checkout, and order management workflows.
- Integrate an AI chatbox to guide customers with context-aware suggestions.

**Technology Stack**
- Backend: Laravel 11, PHP 8.3
- Frontend: Blade + Tailwind CSS
- Database: MySQL
- AI Integration: Google Gemini API

## 2. Implementation Process (Step-by-Step)

**Stage 1-2: Environment Setup & Database Schema Design**
- Laravel project initialization, environment configuration, and dependency setup.
- Database schema modeling for users, categories, products, orders, order items, and images.
- Migration strategy designed to support scalable ecommerce growth.

**Stage 3: Backend Development**
- Resource Controllers for admin CRUD on categories and products.
- Eloquent ORM for relational data modeling and query composition.
- Order management endpoints for listing, status updates, and administration.

**Stage 4: Frontend UI/UX with Floral Theme & Responsive Design**
- Blade layouts with Tailwind CSS for a clean, luxury floral aesthetic.
- Responsive navigation, product cards, and admin panels.
- Consistent design system using soft pastel palettes and serif typography.

**Stage 6: Functional & Security Testing**
- Functional validation for cart operations, checkout flow, and admin actions.
- Basic security checks for authentication, authorization, and request validation.
- Regression checks after UI and API updates.

## 3. Security Architecture (Critical Section)

**Authentication & Authorization**
- Laravel Breeze used for secure authentication.
- AdminMiddleware applied to protect admin routes and sensitive CRUD operations.
- Role checks based on `is_admin` flag in the user model.

**SQL Injection Protection**
- Eloquent ORM and query builder use parameter binding by default.
- Avoids raw SQL strings unless explicitly required.

**XSS Protection**
- Blade escaping is enabled by default for untrusted output.
- Form inputs are validated and sanitized on the server.

**CSRF Protection**
- CSRF tokens are enforced on all state-changing POST, PATCH, and DELETE requests.
- The chatbox AJAX requests include the CSRF token in headers.

**Secure File Upload**
- File uploads are validated with MIME type and size limits.
- Storage paths are managed using Laravel's filesystem to prevent direct exposure.

**API Security**
- Gemini API key is stored in `.env` and accessed via `config/services.php`.
- Rate limiting is applied to the chatbox endpoint to mitigate abuse.

```php
Route::post('/chat/consult', [ChatController::class, 'consult'])
    ->middleware('throttle:30,1')
    ->name('chat.consult');
```

## 4. Feature Spotlight: Smart Flower Consultant (AI Chatbox)

**Gemini API Integration**
- ChatController acts as a secure server-side proxy.
- The controller builds a product-aware prompt from available catalog data.
- The response is returned as JSON for the frontend widget.

**Interaction Flow**
1. User Message
2. AJAX Request
3. `ChatController`
4. Gemini API
5. JSON Response
6. Frontend UI renders assistant reply

**System Instruction (AI Personality)**
The system prompt positions the assistant as a polite and knowledgeable floral consultant, guiding customers in Vietnamese with elegant tone and relevant recommendations based on the available products.

## 5. Future Enhancements (Giai doan 7)

- Performance optimization: caching, query optimization, and asset bundling.
- Cloud deployment: containerization, CI/CD pipelines, managed database services.
- Advanced analytics: conversion tracking, product affinity, and chatbot success metrics.
- Customer personalization: wishlists, reminders, and birthday/anniversary flows.
- AI enhancements: sentiment analysis and multi-turn memory for richer consulting.
