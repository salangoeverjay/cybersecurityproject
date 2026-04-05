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
    <div class="password-strength-rules">
        <span class="password-rule" data-rule="length">At least 8 characters</span>
        <span class="password-rule" data-rule="mixed">Uppercase + lowercase letters</span>
        <span class="password-rule" data-rule="number">At least 1 number</span>
        <span class="password-rule" data-rule="symbol">At least 1 symbol</span>
    </div>
</div>
