# Cybersecurity Authentication Project

A Laravel-based authentication system implementing custom credential security with:
- Registration and login
- Session-protected dashboard
- Forgot-password reset flow (token expiry)
- Password change in settings
- SHA-256 hashing with per-user salt and application pepper

## Security Model (Current)

- Password hash: `SHA-256(password + salt + pepper)`
- Salt: generated per password set using `bin2hex(random_bytes(16))`
- Pepper: stored in environment variable `PASSWORD_PEPPER` (not in DB)
- Reset tokens: stored as SHA-256 hash with pepper
- Reset token expiry: configurable via `PASSWORD_RESET_TTL_MINUTES` (default: 15)

## Environment Variables

Required/important values:

```env
APP_ENV=local
APP_URL=http://127.0.0.1:8000
PASSWORD_PEPPER=your-long-random-secret
PASSWORD_RESET_TTL_MINUTES=15
```

## Local Setup

```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan serve
```

Open: `http://127.0.0.1:8000/login`

## Test Commands

Run all tests:

```bash
php artisan test
```

## Core Routes

- `GET /register` / `POST /register`
- `GET /login` / `POST /login`
- `GET /forgot-password` / `POST /forgot-password`
- `GET /reset-password/{token}` / `POST /reset-password`
- `GET /settings` (session-protected)
- `POST /settings/username` / `POST /settings/password`
- `GET /dashboard` (session-protected)

## Submission Documents

- Short security documentation:
  - `docs/short-password-security-documentation.md`
- Extended midterm documentation:
  - `docs/midterm-auth-documentation.md`

## Notes

- This project intentionally demonstrates explicit salt + pepper logic for coursework.
- For production-grade systems, adaptive password hashing (Argon2id/bcrypt) is recommended.
