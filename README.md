# 🌐 Hotel Management System (Laravel)

> ⚠️ **Important Notice**  
> This repository is provided **for viewing purposes only**.  
> No permission is granted to copy, modify, or distribute this code.

A modular **Hotel Management System** built with **Laravel 11** and **PHP 8.2**, showcasing clean CRUD workflows, pragmatic validation, and a modern Blade/Tailwind UI.  
It demonstrates core hotel operations including **Rooms**, **Room Types**, **Guests & Groups**, **Reservations**, **Housekeeping**, and **Maintenance Tickets**.

---

## 📑 Table of Contents
- [✨ Features](#-features)
- [🛠 Tech Stack](#-tech-stack)
- [📊 Screens & Modules](#-screens--modules)
- [⚙️ Local Setup](#-local-setup)
- [📐 Quality & Conventions](#-quality--conventions)
- [📂 Folder Structure](#-folder-structure)
- [🧩 Troubleshooting](#-troubleshooting)
- [🚀 Roadmap Ideas](#-roadmap-ideas)
- [📜 License & Permissions](#-license--permissions)
- [📬 Contact](#-contact)

---

## ✨ Features
- **Rooms** → Listing, status badges (vacant / occupied / cleaning / maintenance / out_of_service), basic attributes.  
- **Room Types** → Name, capacity, beds, base price.  
- **Guests & Groups** → Guest details (name, nationality, document type/number), reusable group assignments with optional color.  
- **Reservations** → Room assignment, date range, status (new / confirmed / checked_in / checked_out / canceled), paid amount, guest linking, search & filter.  
- **Housekeeping** → Task notes, `needs_food` flag, created_by, completed_at.  
- **Maintenance** → Ticketed issues per room, tool requests, status tracking, created_by, completed_at.  
- **UI/UX** → Blade components, responsive Tailwind tables, filters, flash messages, validation feedback.  

---

## 🛠 Tech Stack
- **Backend:** Laravel 12, PHP 8.2  
- **Database:** MySQL / MariaDB with Eloquent ORM, migrations, seeders  
- **Frontend:** Blade templates, Tailwind CSS  
- **Authentication:** Laravel session-based auth  
- **Tooling:** Composer, Artisan CLI, Node.js (for asset builds)  

---

## 📊 Screens & Modules
- Admin → Rooms  
- Admin → Room Types  
- Admin → Guests  
- Admin → Groups  
- Admin → Reservations (index, create, edit, show)  
- Admin → Housekeeping Tasks  
- Admin → Maintenance Tickets  

> Views live under `resources/views/admin/...` with reusable partials (`_form.blade.php`) and Blade components (`resources/views/components`).

---

## ⚙️ Local Setup

### Prerequisites
- PHP **8.2+**  
- Composer **2.x**  
- MySQL **8.x** / MariaDB **10.6+**  
- Node.js **18+** (for asset compilation)  
- Git  

### 1) Clone
"don't do it"