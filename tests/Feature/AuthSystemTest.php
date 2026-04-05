<?php

use App\Models\PasswordResetToken;
use App\Models\User;
use App\Support\PasswordSecurity;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function (): void {
    config(['security.password_pepper' => 'testing-pepper-secret']);
    config(['security.password_reset_ttl_minutes' => 15]);
});

function createAuthUser(string $username, string $password): User
{
    $salt = PasswordSecurity::generateSalt();

    return User::create([
        'username' => $username,
        'salt' => $salt,
        'password_hash' => PasswordSecurity::hash($password, $salt),
    ]);
}

test('registration creates user with valid salt and password hash', function () {
    $response = $this->post('/register', [
        'username' => 'student_alpha',
        'password' => 'ValidPass1!',
        'password_confirmation' => 'ValidPass1!',
    ]);

    $response->assertRedirect(route('login.form'));

    $user = User::where('username', 'student_alpha')->first();
    expect($user)->not->toBeNull();
    expect($user->salt)->toMatch('/^[a-f0-9]{32}$/');
    expect(strlen($user->password_hash))->toBe(64);
    expect(PasswordSecurity::verify('ValidPass1!', $user->salt, $user->password_hash))->toBeTrue();
});

test('login accepts valid credentials and rejects invalid credentials', function () {
    $user = createAuthUser('login_alpha', 'SecretPass1!');

    $ok = $this->post('/login', [
        'username' => 'login_alpha',
        'password' => 'SecretPass1!',
    ]);

    $ok->assertRedirect(route('dashboard'));
    $ok->assertSessionHas('auth_user_id', $user->id);

    $bad = $this->post('/login', [
        'username' => 'login_alpha',
        'password' => 'WrongPass1!',
    ]);

    $bad->assertRedirect();
    $bad->assertSessionHas('error', 'Invalid Username or Password');
});

test('forgot password blocks unknown username and does not create token', function () {
    $response = $this->post('/forgot-password', [
        'username' => 'ghost_user',
    ]);

    $response->assertRedirect();
    $response->assertSessionHas('error', 'Username does not exist.');
    expect(PasswordResetToken::count())->toBe(0);
});

test('forgot password generates token and reset link without username query', function () {
    $user = createAuthUser('reset_alpha', 'OldPass1!');

    $response = $this->post('/forgot-password', [
        'username' => $user->username,
    ]);

    $response->assertRedirect();
    $response->assertSessionHas('reset_link');

    $link = (string) $response->getSession()->get('reset_link');
    expect($link)->toContain('/reset-password/');
    expect($link)->not->toContain('username=');

    $tokenRecord = PasswordResetToken::first();
    expect($tokenRecord)->not->toBeNull();
    expect($tokenRecord->user_id)->toBe($user->id);
});

test('reset password updates hash and salt using token only', function () {
    $user = createAuthUser('token_reset', 'BeforePass1!');
    $oldSalt = $user->salt;
    $oldHash = $user->password_hash;

    $linkResponse = $this->post('/forgot-password', ['username' => $user->username]);
    $link = (string) $linkResponse->getSession()->get('reset_link');

    $path = (string) parse_url($link, PHP_URL_PATH);
    $token = basename($path);

    $reset = $this->post('/reset-password', [
        'token' => $token,
        'password' => 'AfterPass2@',
        'password_confirmation' => 'AfterPass2@',
    ]);

    $reset->assertRedirect(route('login.form'));
    $user->refresh();

    expect($user->salt)->not->toBe($oldSalt);
    expect($user->password_hash)->not->toBe($oldHash);
    expect(PasswordSecurity::verify('AfterPass2@', $user->salt, $user->password_hash))->toBeTrue();
});

test('settings password update rotates salt and hash', function () {
    $user = createAuthUser('settings_alpha', 'CurrentPass1!');
    $oldSalt = $user->salt;
    $oldHash = $user->password_hash;

    $response = $this->withSession([
        'auth_user_id' => $user->id,
        'auth_username' => $user->username,
    ])->post('/settings/password', [
        'current_password' => 'CurrentPass1!',
        'new_password' => 'ChangedPass2#',
        'new_password_confirmation' => 'ChangedPass2#',
    ]);

    $response->assertRedirect();
    $response->assertSessionHas('success', 'Password updated successfully.');

    $user->refresh();
    expect($user->salt)->not->toBe($oldSalt);
    expect($user->password_hash)->not->toBe($oldHash);
});
