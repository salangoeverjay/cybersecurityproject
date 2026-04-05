<?php

use App\Support\PasswordSecurity;

beforeEach(function (): void {
    config(['security.password_pepper' => 'testing-pepper-secret']);
});

test('generateSalt returns 32-character hex salt', function () {
    $salt = PasswordSecurity::generateSalt();

    expect($salt)->toMatch('/^[a-f0-9]{32}$/');
});

test('hash and verify work for valid and invalid passwords', function () {
    $salt = PasswordSecurity::generateSalt();
    $hash = PasswordSecurity::hash('TestPass1!', $salt);

    expect(strlen($hash))->toBe(64);
    expect(PasswordSecurity::verify('TestPass1!', $salt, $hash))->toBeTrue();
    expect(PasswordSecurity::verify('WrongPass1!', $salt, $hash))->toBeFalse();
});

test('hashing throws when password pepper is missing', function () {
    config(['security.password_pepper' => '']);

    expect(fn () => PasswordSecurity::hash('TestPass1!', PasswordSecurity::generateSalt()))
        ->toThrow(\InvalidArgumentException::class);
});
