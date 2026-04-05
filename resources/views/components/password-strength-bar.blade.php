@props([
    'inputId',
])

<div class="password-strength" data-password-strength data-password-input-id="{{ $inputId }}" data-tone="none">
    <div
        class="password-strength-track"
        role="progressbar"
        aria-label="Password strength"
        aria-valuemin="0"
        aria-valuemax="100"
        aria-valuenow="0"
    >
        <span class="password-strength-fill"></span>
    </div>
    <p class="password-strength-text">Strength: Not entered</p>
</div>
