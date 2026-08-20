# 💊 Saydalaghty Platform (منصة صيدليتي)

A web-based pharmacy directory and medicine availability search engine designed to help users instantly locate prescribed medications, discover nearby pharmacies, and check real-time stock levels and pricing.

---

## 📸 Screenshots & Showcase

<img width="1600" height="852" alt="WhatsApp Image 2026-08-20 at 9 16 48 AM (1)" src="https://github.com/user-attachments/assets/54f1dd60-1c59-4c75-8c97-6b681ef406ad" />
<img width="1600" height="840" alt="WhatsApp Image 2026-08-20 at 9 23 08 AM" src="https://github.com/user-attachments/assets/4220dd18-ba78-4cd7-8849-94fb4832b994" />


<img width="1600" height="867" alt="WhatsApp Image 2026-08-20 at 9 16 48 AM (2)" src="https://github.com/user-attachments/assets/476be41a-a299-4c46-9092-e848c3b53fb1" />

<img width="1600" height="853" alt="WhatsApp Image 2026-08-20 at 9 16 48 AM (3)" src="https://github.com/user-attachments/assets/8c821495-7d90-4048-9054-cfde2f0d4e2f" />


<img width="1600" height="809" alt="WhatsApp Image 2026-08-20 at 9 16 48 AM (4)" src="https://github.com/user-attachments/assets/ae03bcad-96a4-4cbc-baf2-240965d21fb2" />

<img width="1600" height="852" alt="WhatsApp Image 2026-08-20 at 9 16 48 AM" src="https://github.com/user-attachments/assets/20c540d7-a82f-4d80-9733-0b814308442a" />

<img width="1600" height="723" alt="WhatsApp Image 2026-08-20 at 9 20 33 AM" src="https://github.com/user-attachments/assets/69e21eca-0aca-40f3-81eb-75363cdeae1b" />

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
