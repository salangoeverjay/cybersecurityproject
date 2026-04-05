# Submission Checklist

Use this checklist before final submission.

## Functionality (Registration & Login)
- [ ] Register new account works
- [ ] Login with correct credentials works
- [ ] Login with wrong password is rejected
- [ ] Dashboard requires authenticated session

## Hash, Salt, Pepper Implementation
- [ ] Password hashing uses SHA-256 with `password + salt + pepper`
- [ ] Salt generated via `random_bytes` per password set
- [ ] Pepper stored in `.env` (`PASSWORD_PEPPER`) and not in DB
- [ ] Reset tokens are hashed before DB storage

## Code Quality & Organization
- [ ] Shared password-strength component is reused across forms
- [ ] Duplicate logic minimized
- [ ] Config values centralized (`config/security.php`)

## Documentation
- [ ] `docs/short-password-security-documentation.md` included
- [ ] `README.md` updated with project setup and security summary

## Completeness (Screenshots, Code, etc.)
- [ ] UI screenshots captured (register/login/dashboard/forgot/reset/settings)
- [ ] GitHub repository link included
- [ ] Documentation link included
