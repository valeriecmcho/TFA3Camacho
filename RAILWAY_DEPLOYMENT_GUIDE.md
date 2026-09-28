# Gabay sa Deployment ng TFA3Camacho POS System sa Railway

## Paano i-deploy ang CodeIgniter 4 project sa Railway.app

Ito ang kumpletong step-by-step procedure para i-deploy ang TFA3Camacho POS System sa Railway cloud platform.

---

## 📋 Prerequisites (Kailangan bago magsimula)

Bago magsimula, siguraduhin na mayroon ka ng:

1. ✅ **Railway.app account** - Pumunta sa [railway.app](https://railway.app) at mag-sign up
2. ✅ **GitHub account** - Ang project ay kailangang nasa GitHub repository
3. ✅ **Git installed** - Para i-push ang code sa GitHub
4. ✅ **Local working project** - Ang TFA3Camacho project ay dapat gumagana locally

---

## 🚀 STEP 1: I-push ang Project sa GitHub

Kung hindi pa nasa GitHub ang project:

1. **Mag-login sa GitHub account mo**
2. **Mag-create ng new repository:**
   - Click ang "+" icon sa GitHub
   - Piliin "New repository"
   - Pangalanan ito (halimbawa: `tfa3camacho-pos`)
   - Pwede mong i-leave bilang Public o Private
   - Click "Create repository"

3. **I-push ang project mula sa terminal:**
   ```bash
   cd C:\xampp\htdocs\TFA3Camacho
   git init
   git add .
   git commit -m "Initial commit - TFA3 POS System"
   git branch -M main
   git remote add origin https://github.com/USERNAME/tfa3camacho-pos.git
   git push -u origin main
   ```
   
   *Palitan ang `USERNAME` sa iyong GitHub username*

---

## 🚀 STEP 2: Mag-create ng Railway Project

1. **Pumunta sa [railway.app](https://railway.app)**
2. **Mag-login sa iyong account**
3. **Click "New Project"** (o "Start a New Project")
4. **Piliin "Deploy from GitHub repo"**
5. **I-connect ang GitHub account** (kung first time)
6. **Hanapin at piliin ang `tfa3camacho-pos` repository**
7. **Click "Import"**

---

## 🚀 STEP 3: Mag-add ng PostgreSQL Database

Ang project ay kailangan ng database. Sa Railway, gagamitin natin ang PostgreSQL:

1. **Sa Railway dashboard, click "New Service"**
2. **Piliin "Database"**
3. **Piliin "PostgreSQL"**
4. **Wait lang hanggang ma-deploy ang database**

Pagkatapos, Railway ay awtomatikong magbibigay ng `DATABASE_URL` environment variable.

---

## 🚀 STEP 4: I-configure ang Application Service

Ngayon i-configure natin ang main application:

1. **I-click ang existing service** (ang PHP application service)
2. **Pumunta sa "Settings" tab**
3. **Check ang mga configuration files:**
   - `railway.toml` - Dito nakaset ang PHP version (8.2)
   - `railpack.json` - Dito nakaset ang build at deploy commands
   - `nixpacks.toml` - Legacy file (deperoated)

4. **I-verify ang environment variables:**
   - `PHP_VERSION` = 8.2
   - `CI_ENVIRONMENT` = production
   - `DATABASE_URL` = (awtomatikong naka-set ng Railway)

---

## 🚀 STEP 5: I-trigger ang Deployment

1. **Pumunta sa "Deployments" tab**
2. **Click "Redeploy"** kung hindi pa naka-deploy
3. **Humingi ng deployment logs:**
   - Makikita mo ang build process
   - Kung may error, ito ang makikita dito
   - Hintayin na maging "Success" ang status

**Ano ang nangyayari during deployment:**
- Railway ay i-install ang PHP 8.2
- I-install ang mga required extensions (including PostgreSQL)
- Run `composer install --no-dev --optimize-autoloader`
- Start ang PHP built-in server
- Health check ang application

---

## 🚀 STEP 6: I-setup ang Database Tables

Pagkatapos ma-deploy, kailangan pang i-setup ang database tables. May tatlong options:

### Option A: Gamit ang Web Interface (Recommended)

1. **Kunin ang deployed URL** (makikita sa Railway dashboard)
2. **Access ang URL sa browser**
3. **Pumunta sa `/setup_railway_database`**
   - Halimbawa: `https://tfa3camacho-production.up.railway.app/setup_railway_database`
4. **Kung successful, makikita mo:**
   - "Database setup completed successfully"
   - "customers table created"
   - "users table created"
   - "Sample data inserted"

### Option B: Gamit ang Railway Console

1. **Pumunta sa Railway dashboard**
2. **I-click ang PostgreSQL service**
3. **Pumunta sa "Console" tab**
4. **Run ang mga SQL commands:**

```sql
CREATE TABLE IF NOT EXISTS customers (
    id SERIAL PRIMARY KEY,
    full_name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    phone VARCHAR(20),
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS users (
    id SERIAL PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    full_name VARCHAR(100) NOT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO customers (full_name, email, phone, created_at) VALUES
('Juan Dela Cruz', 'juan@example.com', '09171234567', CURRENT_TIMESTAMP),
('Maria Santos', 'maria@example.com', '09181234567', CURRENT_TIMESTAMP),
('Pedro Reyes', 'pedro@example.com', '09191234567', CURRENT_TIMESTAMP),
('Ana Garcia', 'ana@example.com', '09201234567', CURRENT_TIMESTAMP),
('Mark Flores', 'mark@example.com', '09211234567', CURRENT_TIMESTAMP);

INSERT INTO users (username, full_name, created_at) VALUES
('admin', 'Administrator', CURRENT_TIMESTAMP),
('cashier1', 'John Smith', CURRENT_TIMESTAMP),
('cashier2', 'Jane Doe', CURRENT_TIMESTAMP),
('manager', 'Robert Johnson', CURRENT_TIMESTAMP),
('supervisor', 'Emily Brown', CURRENT_TIMESTAMP);
```

### Option C: Gamit ang Local Setup Script

1. **Edit ang `setup_railway_database.php`**
2. **Tiyakin na tama ang database connection**
3. **Access ang script sa deployed URL**

---

## 🚀 STEP 7: I-test ang Deployed Application

1. **Access ang main URL:**
   - Halimbawa: `https://tfa3camacho-production.up.railway.app/`

2. **Test ang Home Page:**
   - Dapat makakita ka ng navigation menu
   - Dapat walang errors

3. **Test ang Customer Accounts:**
   - Pumunta sa `/customer-accounts`
   - Dapat makakita ka ng 5 customer records
   - Check ang fields: ID, Full Name, Email, Phone, Created At

4. **Test ang User Accounts:**
   - Pumunta sa `/user-accounts`
   - Dapat makakita ka ng 5 user records
   - Check ang fields: ID, Username, Full Name, Created At

---

## 🚀 STEP 8: I-set ang Custom Domain (Optional)

Kung gusto mo ng custom domain:

1. **Pumunta sa "Settings" tab ng application service**
2. **Pumunta sa "Networking"**
3. **Click "Generate Domain"** o "Add Custom Domain"
4. **Follow ang instructions para sa DNS setup**

---

## 🔧 Troubleshooting

### Problem: "Whoops!" error page

**Solutions:**
1. Check ang Railway logs sa "Deployments" tab
2. Siguraduhin na PostgreSQL service ay running
3. Verify na `DATABASE_URL` environment variable ay naka-set
4. Check na PostgreSQL extension ay naka-install

### Problem: Database connection fails

**Solutions:**
1. Verify na PostgreSQL service ay running sa Railway
2. Check na `DATABASE_URL` ay tama ang format
3. Ensure na database tables ay created (run setup script)
4. Check ang `app/Config/Database.php` configuration

### Problem: Build fails

**Solutions:**
1. Check ang `railpack.json` build command
2. Verify na `composer.json` ay tama ang dependencies
3. Check Railway build logs for specific errors
4. Ensure na PHP 8.2 ay naka-configure

### Problem: Empty pages

**Solutions:**
1. Check ang PHP error logs
2. Verify na `writable` directory ay may write permissions
3. Ensure na lahat ng files ay nasa tamang location

---

## 📝 Important Files Explanation

### railway.toml
```
[build]
builder = "RAILPACK"

[build.env]
PHP_VERSION = "8.2"
CI_ENVIRONMENT = "production"
```
- Sinasabi ito sa Railway na gamitin ang Railpack builder
- Naka-set ang PHP version sa 8.2
- Environment ay production

### railpack.json
```json
{
  "build": {
    "builder": "railpack",
    "buildCommand": "composer install --no-dev --optimize-autoloader"
  },
  "deploy": {
    "startCommand": "php -S 0.0.0.0:$PORT -t public",
    "healthcheckPath": "/health"
  }
}
```
- Build command: Install dependencies
- Start command: PHP built-in server
- Health check: Path para sa monitoring

### app/Config/Database.php
- Awtomatikong detects Railway's `DATABASE_URL`
- Kung may `DATABASE_URL`, gagamitin ang PostgreSQL
- Kung wala, gagamitin ang MySQL (local development)

---

## 🔄 Local vs Production Configuration

### Local Development (XAMPP)
- Database: MySQL
- Configuration: `.env` file
- Access: `http://localhost/TFA3Camacho/`

### Production (Railway)
- Database: PostgreSQL
- Configuration: Railway environment variables
- Access: `https://your-app.up.railway.app/`

Ang application ay awtomatikong nag-detect kung anong environment ang ginagamit.

---

## 📌 Key Reminders

1. **Always push to GitHub first** - Railway pulls from GitHub
2. **PostgreSQL service is required** - Hindi gagana without database
3. **Run database setup after deployment** - Tables need to be created manually
4. **Check logs for errors** - Railway logs are very helpful
5. **Environment variables are key** - `DATABASE_URL` is critical

---

## 🎉 Summary

1. ✅ Push project to GitHub
2. ✅ Create Railway project from GitHub
3. ✅ Add PostgreSQL database service
4. ✅ Configure application service
5. ✅ Trigger deployment
6. ✅ Setup database tables
7. ✅ Test the application
8. ✅ (Optional) Set custom domain

---

## 📞 Additional Resources

- [Railway Documentation](https://docs.railway.app)
- [CodeIgniter 4 Documentation](https://codeigniter.com/user_guide)
- [PostgreSQL Documentation](https://www.postgresql.org/docs)

---

Kung may mga tanong o issues, check ang Railway logs at magsimula sa troubleshooting section sa itaas. Good luck sa deployment! 🚀
