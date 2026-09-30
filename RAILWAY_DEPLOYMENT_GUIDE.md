# Deploy to Railway

This CodeIgniter 4 app deploys with a **Dockerfile** (Apache + PHP 8.2 + PostgreSQL extensions). That avoids the usual Railway failures: missing `pgsql`/`intl`, PHP built-in server 404s on `/health`, and HTTPS redirect loops.

## 1. Push the code to GitHub

Commit these files and push to your repo (including `Dockerfile`, `docker/`, and `railway.toml`).

## 2. Create the Railway project

1. Open [Railway](https://railway.app) and sign in with GitHub.
2. **New Project** → **Deploy from GitHub repo** → select this repository.
3. Railway will build from the `Dockerfile`.

## 3. Add PostgreSQL and connect it

1. In the same project: **New** → **Database** → **PostgreSQL**.
2. Open your **web service** → **Variables**.
3. Click **Add variable reference** / **Connect** and link the Postgres service so `DATABASE_URL` is set.
   - Variable name: `DATABASE_URL`
   - Value: `${{Postgres.DATABASE_URL}}` (use the actual Postgres service name if it is different).

Also set:

| Variable | Value |
|---|---|
| `CI_ENVIRONMENT` | `production` |

You do **not** need `app.baseURL`. The app uses `RAILWAY_PUBLIC_DOMAIN`.

Do **not** set `app.forceGlobalSecureRequests` to `true`. Railway health checks hit HTTP inside the container; forcing HTTPS causes a restart loop.

## 4. Generate a public URL

Web service → **Settings** → **Networking** → **Generate domain**.

## 5. Create tables once

After the deploy is live, open:

`https://YOUR-DOMAIN.up.railway.app/customer-accounts/setup`

Submit the setup form so `customers` and `users` tables are created.

## 6. Confirm it is healthy

- `https://YOUR-DOMAIN.up.railway.app/health` should return JSON `"status":"healthy"`.
- `https://YOUR-DOMAIN.up.railway.app/` should load the home page.

If the home page says the database failed, the web service is not linked to Postgres (`DATABASE_URL` missing) or the deploy is still using an old build.

## Local vs Railway

- Local XAMPP can keep using MySQL in your machine `.env`.
- Railway uses PostgreSQL via `DATABASE_URL`. Leave local `.env` gitignored.
