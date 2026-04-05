# Short Documentation: Password Hashing, Salt, and Pepper

This system uses a custom Laravel authentication flow with secure password handling.  
Passwords are never stored in plain text. The database stores only `username`, `password_hash`, and `salt`.

## 1. Hashing Algorithm Used

The system uses **SHA-256** via PHP's `hash()` function.

Main password hashing logic (in `app/Support/PasswordSecurity.php`):

```php
hash('sha256', $password . $salt . $pepper)
```

Key points:
- SHA-256 produces a fixed 64-character hexadecimal digest.
- During login, the system recomputes the hash from user input and compares it with `hash_equals(...)` (timing-safe comparison).
- Reset tokens are also hashed before database storage (`hash('sha256', $token . $pepper)`).

Note: This project intentionally demonstrates manual salt + pepper logic.  
In production, adaptive password hashers such as Argon2id/bcrypt are generally recommended.

## 2. How Salt Is Generated and Used

Salt is generated with a cryptographically secure random source:

```php
bin2hex(random_bytes(16))
```

What this means:
- `random_bytes(16)` generates 16 random bytes securely.
- `bin2hex(...)` converts that into a 32-character hex string.
- A **new unique salt is generated per password set** (for registration and password reset/update).

How it is used:
1. Generate salt.
2. Combine `password + salt + pepper`.
3. Hash with SHA-256.
4. Store `password_hash` and `salt` in the `users` table.
5. On login, load the user's stored salt and recompute the hash for verification.

## 3. Where Pepper Is Stored and How It Is Applied

Pepper is stored in environment configuration, not in the database:
- `.env`: `PASSWORD_PEPPER=...`
- Loaded via `config/security.php` as `security.password_pepper`
- Read in code by `PasswordSecurity::pepper()`

Application:
- Password hash input: `password + salt + pepper`
- Reset token hash input: `token + pepper`

If the pepper is missing, the system throws an error and blocks hashing/verification.  
This prevents running the auth flow with an unsafe configuration.

## 4. Why Salt and Pepper Improve Security

### Salt improves security because:
- Users with the same password still get different hashes.
- Precomputed rainbow tables become much less useful.
- Attackers must crack each user hash individually.

### Pepper improves security because:
- It is a secret outside the database.
- If only the database is leaked, attacker still does not have the pepper.
- Offline cracking becomes significantly harder without the application secret.

### Together (salt + pepper):
- Provide layered protection (defense in depth).
- Reduce impact of common credential-storage attacks.
- Make password hash attacks more expensive and less scalable.

Operational note: rotating pepper invalidates existing password hashes unless users reset passwords, so pepper rotation should be planned carefully.
