<?php

namespace App\Support;

use InvalidArgumentException;

class PasswordSecurity
{
    /**
     * Generate a cryptographically secure random salt per user.
     */
    public static function generateSalt(): string
    {
        return bin2hex(random_bytes(16));
    }

    /**
     * Hash password + salt + pepper using SHA-256.
     */
    public static function hash(string $password, string $salt): string
    {
        return hash('sha256', $password.$salt.self::pepper());
    }

    /**
     * Timing-safe password hash verification.
     */
    public static function verify(string $plainPassword, string $salt, string $storedHash): bool
    {
        return hash_equals($storedHash, self::hash($plainPassword, $salt));
    }

    /**
     * Hash reset tokens before storing them in the database.
     */
    public static function hashResetToken(string $token): string
    {
        return hash('sha256', $token.self::pepper());
    }

    private static function pepper(): string
    {
        $pepper = (string) config('security.password_pepper', '');
        if ($pepper === '') {
            throw new InvalidArgumentException('Missing PASSWORD_PEPPER in environment configuration.');
        }

        return $pepper;
    }
}
