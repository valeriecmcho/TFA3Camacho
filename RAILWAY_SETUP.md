# Railway Deployment Setup

This document explains how to deploy the TFA3Camacho POS System to Railway.app.

## Prerequisites

1. A Railway.app account
2. Git repository with this project
3. Railway CLI (optional)

## Deployment Steps

### 1. Add PostgreSQL Service

In your Railway project, you need to add a PostgreSQL database service:

1. Go to your Railway project
2. Click "New Service" 
3. Select "Database" → "PostgreSQL"
4. Railway will create a PostgreSQL database and provide a `DATABASE_URL` environment variable

### 2. Deploy the Application

1. Connect your Git repository to Railway
2. Railway will automatically detect the `railway.toml` and `nixpacks.toml` files
3. The build process will:
   - Install PHP 8.2
   - Install required extensions including PostgreSQL
   - Run `composer install --no-dev --optimize-autoloader`
   - Start the PHP built-in server

### 3. Database Setup

After deployment, you need to initialize the database tables:

**Option 1: Web Interface**
1. Access your deployed application URL
2. Navigate to `/customer-accounts/setup`
3. Click "Setup Database" to create the required tables
4. The setup script will create:
   - `customers` table
   - `users` table
   - Sample data for both tables

**Option 2: Direct Setup Script**
1. Access `/setup-database` directly
2. This will run the database setup script automatically
3. You should see success messages for table creation

**Option 3: Railway Console**
1. Go to Railway dashboard → PostgreSQL service → Console tab
2. Run the SQL commands from the setup_railway_database.php file

### 4. Environment Variables

Railway automatically provides the `DATABASE_URL` environment variable when you add a PostgreSQL service. The application will automatically parse this URL and configure the database connection.

No manual environment variable configuration is needed for the database.

## Configuration Files

### railway.toml
- Configures the build builder (RAILPACK)
- Sets PHP version to 8.2
- Sets environment to production

### railpack.json
- Configures the Railpack build process
- Sets build command for composer install
- Configures deployment with PHP built-in server
- Sets health check configuration

### nixpacks.toml (deprecated)
- Legacy Nixpacks configuration (kept for compatibility)
- May be removed in future updates

### composer.json
- Requires PHP 8.2
- Requires ext-pgsql for PostgreSQL support

### Database.php
- Automatically detects Railway's DATABASE_URL
- Parses the URL and configures PostgreSQL connection
- Falls back to MySQL configuration for local development

## Troubleshooting

### Application shows "Whoops!" error

1. Check Railway logs for specific error messages
2. Ensure PostgreSQL service is added and running
3. Verify DATABASE_URL environment variable is set
4. Check that PostgreSQL extension is installed in the build

### Database connection fails

1. Verify PostgreSQL service is running in Railway
2. Check that DATABASE_URL is correctly formatted
3. Ensure the database tables are created by visiting `/customer-accounts/setup`

### Build fails

1. Check that railpack.json has correct build and deploy commands
2. Verify composer.json has correct dependencies
3. Check Railway build logs for specific errors
4. Ensure PHP 8.2 is properly configured in environment variables

## Local Development

For local development, use the `env` file as a template:

1. Copy `env` to `.env`
2. Configure your local MySQL database settings
3. Run `php spark serve` to start the local server
4. Access the application at `http://localhost:8080`

## Production vs Development

- **Production (Railway)**: Uses PostgreSQL via DATABASE_URL
- **Development (Local)**: Uses MySQL via .env configuration

The application automatically detects which environment it's running in and configures the database accordingly.
