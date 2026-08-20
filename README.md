# 💊 Saydalaghty Platform (منصة صيدليتي)

A web-based pharmacy directory and medicine availability search engine designed to help users instantly locate prescribed medications, discover nearby pharmacies, and check real-time stock levels and pricing.

---

## 📸 Screenshots & Showcase

| Page | Description | Preview |
| :--- | :--- | :---: |
| **Home Page & Search** | Clean landing page featuring an intuitive medicine search bar with location filtering. | *![Home Page](path/to/home.png)* |
| **Search Results** | Live availability results displaying stock quantities, prices, pharmacy address, and direct call actions. | *![Search Results](path/to/search-results.png)* |
| **Pharmacies Directory** | Responsive grid highlighting partner pharmacies with brand logos, full addresses, and contact numbers. | *![Pharmacies](path/to/pharmacies.png)* |
| **Authentication System** | Secure login and registration interface for user/pharmacy account management. | *![Login](path/to/login.png)* |
| **Profile & Account Settings** | Comprehensive user dashboard supporting profile picture uploads, detail editing, and account deletion. | *![Profile Edit](path/to/profile.png)* |

---

## ✨ Key Features

- 🔍 **Smart Medicine Search:** Search for specific drugs (e.g., *Panadol*) and filter by region to locate nearby stock instantly.
- 📊 **Real-time Inventory & Pricing:** View exact stock counts (e.g., *60 units available*) along with updated drug pricing in EGP.
- 📞 **Direct Contact Integration:** Quick-action phone links to call pharmacies directly from search results.
- 🏪 **Pharmacy Directory:** Browse registered pharmacies including top chains (*El Ezaby, Seif, Roshdy, 19011, El Nahda*).
- 👤 **Account & Profile Management:**
  - Secure user authentication (**Login** & **Sign Up**).
  - Profile image uploads and data modification (**Edit Profile**).
  - Account removal controls (**Delete Profile**).

---

## 🛠️ Tech Stack & Prerequisites

* **Frontend:** HTML5, CSS3, JavaScript (Custom Responsive Layouts)
* **Backend:** PHP 8.x
* **Database:** MySQL
* **Local Server Environment:** Apache / XAMPP / WAMP

---

## 🚀 Getting Started

### 1. Repository Setup
Clone this repository to your local web server root directory (`htdocs` for XAMPP):
```bash
cd C:/xampp/htdocs/
git clone https://github.com/your-username/saydalaghty.git Q
```

### 2. Database Configuration
1. Open XAMPP Control Panel and start **Apache** and **MySQL**.
2. Navigate to `http://localhost/phpmyadmin`.
3. Create a new database named `pharmacy_db` (or as configured in your project).
4. Import the provided SQL dump file (`database.sql`).

### 3. Execution
Launch your web browser and open:
```text
http://localhost/Q/home.php
```

---

## 📁 Project Structure

```text
├── home.php            # Main landing page & medicine search engine
├── Pharmacies.php      # Directory listing all registered pharmacies
├── profile.php         # User profile viewer, edit form, and deletion confirmation
├── login.php           # User login portal
├── signup.php          # New account registration portal
├── assets/             # Images, logos, and stylesheets
└── config/             # Database connection setup
```

---
