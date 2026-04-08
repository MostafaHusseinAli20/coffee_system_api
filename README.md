# ☕ Coffee System API

A **SaaS-based Coffee & Restaurant Management System API** built with Laravel that allows coffee shops and restaurants to manage their operations through a secure and scalable RESTful API.

---

## 📖 Overview

**Coffee System API** is a backend system designed to help coffee shops and restaurants manage their business operations in a centralized SaaS platform.

Each coffee shop can create its own account and manage:

- Products
- Categories
- Orders
- Users (Admins & Workers)
- Permissions
- Settings
- Authentication
- API operations

The system follows **clean architecture principles** and is built to be scalable for **web and mobile applications**.

---

## 🎯 Goals

- Build a scalable SaaS backend system
- Provide clean RESTful API
- Support multi-auth system
- Implement permission-based access control
- Secure authentication using JWT
- Ready for POS and Dashboard integration
- Maintain clean and maintainable architecture

---

## ⚙️ Core Features

### 🔐 Authentication & Authorization

- JWT Authentication
- Multi Guards
- Role & Permission System
- Admin access
- Developer access
- Worker access
- Middleware protection

### ☕ Coffee Management

- Coffee shop registration
- Coffee profile
- Coffee settings
- Coffee system configuration

### 📦 Product Management

- Create product
- Update product
- Delete product
- Product pricing
- Assign category to product

### 📂 Category Management

- Create category
- Update category
- Delete category
- Manage product categories

---

## 🧰 Tech Stack

| Technology | Usage |
|-----------|------|
| PHP 8+ | Core language |
| Laravel 11 | Backend Framework |
| MySQL | Database |
| JWT | Authentication |
| Laravel Breeze | Auth Structure |
| REST API | API Architecture |
| Middleware | Security |
| Service Pattern | Business Logic |
| Repository Pattern | Data Layer |
| API Resource | Response Formatting |
| Form Request | Validation |

---

## 🏛️ Architecture
Controllers
Services
Repositories
Middleware
Traits
Requests
Resources
Models
Routes

### Benefits

- Scalable
- Clean code
- Separation of concerns
- Easy to maintain
- Easy to expand

---

## 🔑 Authentication

The system uses **JWT Token Authentication**.

### Login

POST /api/login

### Response

```json
{
    "token": "jwt_token",
  "user": {
      "id": 1,
    "name": "Admin"
  }
}
