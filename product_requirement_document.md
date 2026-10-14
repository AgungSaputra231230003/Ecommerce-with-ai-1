# Product Requirement Document (PRD)
## Gen-Z E-Commerce Platform

---

## 1. Document Control & Overview

| Field | Details |
| :--- | :--- |
| **Project Name** | Gen-Z E-Commerce Web Application |
| **Document Version** | v1.0 |
| **Status** | Approved / Ready for Development |
| **Tech Stack** | Laravel (Latest), Tailwind CSS (v4/Latest), MariaDB, External Image URLs |
| **Primary Audience** | Gen-Z Consumers & Platform Operations Team |

### Executive Summary
A streamlined, fully functional e-commerce web platform engineered for Gen-Z users. The application features an ultra-modern aesthetic, unified authentication with role-based UI dynamics, external media link integration for products, and comprehensive admin controls for managing products, categories, and customer roles.

---

## 2. Target Audience & User Personas

1. **Customer (Gen-Z Buyer):**
   * **Profile:** Digital-native user seeking an aesthetic, fast, and intuitive shopping experience.
   * **Needs:** Easy registration, quick product browsing, clear visual hierarchy, and seamless purchase flows.
2. **Admin (Platform Manager):**
   * **Profile:** Internal store manager.
   * **Needs:** Direct single-login access, hidden/protected control tools, full CRUD capabilities for catalog items, and user promotion controls.

---

## 3. Key Functional Requirements

### 3.1 Unified Authentication & Dynamic UI Rules
* **Single Login Portal:** A unified login interface for both Admins and Customers.
* **Customer Registration:** Self-service registration exclusively for Customers. Admin accounts cannot be created via public registration.
* **Dynamic Header Presentation:**
  * **Customer Login:** Displays user name only in the top navigation.
  * **Admin Login:** Displays user name with an explicit `[Admin]` badge/pill adjacent to the name.
* **Admin Dashboard Access Button:**
  * **Visibility:** Conditionally rendered **only** when an Admin user is authenticated. Hidden from DOM/UI for standard Customers.
  * **Behavior:** Clicking the button launches the Admin Dashboard in a new browser tab (`target="_blank"`).

### 3.2 Admin Features & Controls
1. **Product Management (CRUD):**
   * Create, Read, Update, and Delete products.
   * Image Handling: Uses external URLs (e.g., Google Images/Unsplash CDN) instead of local file uploads.
2. **Category Management (CRUD):**
   * Manage product categories and URL-friendly slugs.
3. **Customer & Role Management:**
   * View all registered Customers.
   * Promote any Customer account to an Admin role directly from the dashboard.

### 3.3 Customer Features
1. **Catalog & Search:**
   * Responsive product grid with modern visual cards.
   * Category filtering and keyword search.
2. **Cart & Purchase Simulation:**
   * Add to cart, view cart summary, and perform order checkout simulations.

---

## 4. Non-Functional Requirements & Design Guidelines

### 4.1 Tech Stack & Infrastructure
* **Backend Framework:** Laravel (Latest Stable Version).
* **Frontend Styling:** Tailwind CSS (Latest Version) with modern UI utility libraries.
* **Database Engine:** MariaDB.
* **Media Handling:** Direct hotlinking/external URL storage for images.

### 4.2 Visual Identity (Gen-Z Aesthetic)
* **Design Philosophy:** Neo-brutalism / Soft-glassmorphism fusion with vibrant accent tones, dark mode capability, and high contrast elements.
* **Typography:** Clean sans-serif fonts (e.g., *Plus Jakarta Sans*, *Outfit*, or *Inter*).
* **Interactivity:** Micro-interactions, soft hover states, sleek transitions, and mobile-first responsiveness.

---

## 5. Database Schema Design (MariaDB)

### 5.1 `users` Table
| Column | Type | Constraints / Attributes |
| :--- | :--- | :--- |
| `id` | BIGINT | Primary Key, Auto Increment |
| `name` | VARCHAR(255) | Not Null |
| `email` | VARCHAR(255) | Unique, Not Null |
| `password` | VARCHAR(255) | Hashed, Not Null |
| `role` | ENUM('customer', 'admin') | Default: `'customer'` |
| `created_at` / `updated_at` | TIMESTAMP | Nullable |

### 5.2 `categories` Table
| Column | Type | Constraints / Attributes |
| :--- | :--- | :--- |
| `id` | BIGINT | Primary Key, Auto Increment |
| `name` | VARCHAR(255) | Not Null |
| `slug` | VARCHAR(255) | Unique, Not Null |

### 5.3 `products` Table
| Column | Type | Constraints / Attributes |
| :--- | :--- | :--- |
| `id` | BIGINT | Primary Key, Auto Increment |
| `category_id` | BIGINT | Foreign Key -> `categories.id` |
| `title` | VARCHAR(255) | Not Null |
| `description` | TEXT | Nullable |
| `price` | DECIMAL(12, 2) | Not Null |
| `stock` | INT | Default: 0 |
| `image_url` | TEXT | Google / External Image Source Link |

---

## 6. Access Control & Authorization Matrix

| Action / Route | Customer | Admin |
| :--- | :---: | :---: |
| Public Store Front (`/`) | Yes | Yes |
| User Register (`/register`) | Yes | No (Redirect) |
| Unified Login (`/login`) | Yes | Yes |
| View Admin Badge in Header | No | Yes |
| View "Admin Studio" Button | No | Yes |
| Open Admin Studio (`/admin/*`) | Denied (403/Redirect) | Allowed (New Tab) |
| Manage Products & Categories | Denied | Allowed |
| Promote Customer to Admin | Denied | Allowed |

---

## 7. Out of Scope (Phase 1)
* Native payment gateway API integration (Xendit/Midtrans) — simple checkout simulation used for Phase 1.
* Multi-vendor seller onboarding.
* Local file storage/AWS S3 bucket configuration for image uploads.