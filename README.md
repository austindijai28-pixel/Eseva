# 🛡️ Cop-Friendly e-Seva Website
### A Full-Stack Police Portal (HTML + CSS + JS + PHP + MySQL)

---

## 📁 Folder Structure

```
cop-seva/
│
├── frontend/               ← All HTML pages & CSS/JS
│   ├── index.html          ← Home page
│   ├── search.html         ← Search criminal records
│   ├── complaint.html      ← Register complaint
│   ├── login.html          ← Police login
│   ├── dashboard.html      ← Police dashboard
│   ├── css/
│   │   └── style.css       ← Global stylesheet
│
├── backend/                ← PHP scripts (API endpoints)
│   ├── config.php          ← Database connection
│   ├── search.php          ← Search criminal records API
│   ├── complaint.php       ← Submit complaint API
│   ├── login.php           ← Police login API
│   ├── dashboard.php       ← Fetch all data API
│   ├── add_criminal.php    ← Add criminal record API
│   ├── manage_criminal.php ← Edit/Delete criminal API
│   └── logout.php          ← Destroy session & redirect
│
└── database/
    └── setup.sql           ← Create tables + sample data
```

---

## 🚀 Step-by-Step Setup Guide (Using XAMPP)

### Step 1: Install XAMPP
- Download XAMPP from: https://www.apachefriends.org/
- Install it (default location: `C:\xampp` on Windows)

### Step 2: Start XAMPP
- Open XAMPP Control Panel
- Start **Apache** (web server)
- Start **MySQL** (database)
- Both should show green "Running" status

### Step 3: Copy Project Files
- Navigate to `C:\xampp\htdocs\` (on Windows)
  or `/Applications/XAMPP/htdocs/` (on Mac)
- Copy the entire `cop-seva` folder there

Your path should look like:
```
C:\xampp\htdocs\cop-seva\
```

### Step 4: Create the Database
- Open your browser and go to: http://localhost/phpmyadmin
- Click **"New"** in the left sidebar to create a new database
  *(or let the SQL script create it automatically)*
- Click the **"SQL"** tab at the top
- Open `database/setup.sql` file in Notepad/any text editor
- Copy ALL contents and paste into the SQL text box in phpMyAdmin
- Click **"Go"** to execute
- You should see "cop_seva" database appear in the left sidebar ✅

### Step 5: Verify Database Config
- Open `backend/config.php` in a text editor
- Check these settings match your XAMPP:
  ```php
  define('DB_HOST', 'localhost');
  define('DB_USER', 'root');   // XAMPP default
  define('DB_PASS', '');       // XAMPP default (empty)
  define('DB_NAME', 'cop_seva');
  ```
- If you set a MySQL password in XAMPP, update `DB_PASS`

### Step 6: Open the Website
- In your browser, go to:
  ```
  http://localhost/cop-seva/frontend/index.html
  ```
- You should see the e-Seva home page! 🎉

---

## 🔑 Default Login Credentials

| Field    | Value      |
|----------|------------|
| Username | `admin`    |
| Password | `admin123` |

*(This is inserted automatically by setup.sql)*

---

## 📋 Feature Summary

| Page              | URL                              | Description                        |
|-------------------|----------------------------------|------------------------------------|
| Home              | `/frontend/index.html`           | Landing page with quick links      |
| Search Records    | `/frontend/search.html`          | Search criminals by name           |
| Register Complaint| `/frontend/complaint.html`       | Public complaint submission        |
| Police Login      | `/frontend/login.html`           | Secure officer login               |
| Police Dashboard  | `/frontend/dashboard.html`       | View/add/edit/delete all records   |

---

## 🗄️ Database Tables

### `criminals` — Criminal records
| Column    | Type         | Description              |
|-----------|--------------|--------------------------|
| id        | INT (PK)     | Auto-increment           |
| name      | VARCHAR(100) | Criminal's name          |
| age       | INT          | Age                      |
| crime     | VARCHAR(255) | Type of crime            |
| status    | ENUM         | 'Wanted' or 'Arrested'   |
| location  | VARCHAR(255) | Last known location      |
| created_at| TIMESTAMP    | Auto-set date            |

### `complaints` — Public complaints
| Column      | Type    | Description              |
|-------------|---------|--------------------------|
| id          | INT (PK)| Auto-increment           |
| name        | VARCHAR | Complainant's name       |
| phone       | VARCHAR | 10-digit phone number    |
| address     | TEXT    | Complainant's address    |
| complaint   | TEXT    | Complaint description    |
| submitted_at| TIMESTAMP | Auto-set date          |

### `police_users` — Officer accounts
| Column   | Type    | Description              |
|----------|---------|--------------------------|
| id       | INT (PK)| Auto-increment           |
| username | VARCHAR | Unique username          |
| password | VARCHAR | MD5-hashed password      |

---

## 🔒 Security Features Used
- **Prepared Statements** — prevents SQL Injection on all queries
- **PHP Sessions** — dashboard only accessible after login
- **HTML Escaping** — prevents XSS in displayed data
- **Input Validation** — both client (JS) and server (PHP) side
- **MD5 Password Hashing** — passwords not stored as plaintext

---

## 🐛 Common Troubleshooting

| Problem                      | Solution                                        |
|------------------------------|-------------------------------------------------|
| Blank page / PHP not running | Make sure Apache is started in XAMPP            |
| Database connection failed   | Make sure MySQL is started in XAMPP             |
| "Table not found" error      | Run `setup.sql` in phpMyAdmin again             |
| Login not working            | Check credentials: admin / admin123             |
| CORS error in browser        | Make sure you're using `localhost`, not file:// |

---

## 📞 Emergency Numbers (India)
- Police: **100**
- Fire: **101**
- Ambulance: **108**
- Women Helpline: **1091**

---

*Built for learning purposes. Beginner-friendly PHP + MySQL full-stack project.*
