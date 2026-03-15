# 🍽️ NhaHang_VTi – Restaurant Management Website

## 📌 Introduction
**NhaHang_VTi** is a simple restaurant management website built with **PHP and MySQL**.  
The system allows users to browse the restaurant menu, view dish details, and manage restaurant data through a basic database system.

This project was created as a **practice project** to improve skills in **web development, database design, and backend integration**.

---

## 🚀 Features

### 👤 User Side
- View restaurant menu
- View dish details
- Browse food by categories

### ⚙️ Admin / System
- Manage food data
- Retrieve data from MySQL database
- Display dynamic content using PHP

---

## 🛠️ Technologies Used

- **PHP**
- **MySQL**
- **HTML**
- **CSS**
- **Bootstrap**
- **JavaScript**

---

## 🗄️ Database

The project uses a **MySQL database**.

Example tables include:

- `foods`
- `categories`
- `orders`
- `customers`

You can import the database using **phpMyAdmin**.

---

## ⚙️ Installation Guide

### 1️⃣ Clone the repository

```bash
git clone https://github.com/vti0209/Nhahang_VTi.git
```

### 2️⃣ Move the project to your server folder

Example using **XAMPP**:

```
htdocs/Nhahang_VTi
```

### 3️⃣ Import the database

- Open **phpMyAdmin**
- Import the provided `.sql` file

### 4️⃣ Configure database connection

Edit the database connection file:

```
connect.php
```

Example configuration:

```php
$conn = mysqli_connect("localhost","root","","restaurant_db");
```

### 5️⃣ Run the project

Open your browser and go to:

```
http://localhost/Nhahang_VTi
```

---

## 📂 Project Structure

```
Nhahang_VTi
│
├── css/
├── js/
├── images/
├── Database/
├── data.php
├── product.php
├── connect.php
└── README.md
```

---

## 📸 Screenshots

You can add screenshots of the interface here.

Example:

```
screenshots/home.png
screenshots/menu.png
```

---

## 👨‍💻 Author

**Ho Van Tiet**  
Second-year student at **Passerelles Numériques Vietnam (PNV)**

### Interests
- Front-end Development
- Web Development

🔗 GitHub:  
https://github.com/vti0209