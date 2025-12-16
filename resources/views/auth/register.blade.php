<x-guest-layout>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
    .form-control:focus {
        border-color: #86b7fe;
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
    }

    a {
        text-decoration: none;
    }
    </style>

    <div class="py-3">
        <div class="text-center mb-4">
            <h3 class="fw-bold text-dark">{{ __('Create Account') }}</h3>
            <p class="text-muted small">Join us! Please enter your details below.</p>
        </div>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="form-floating mb-3">
                <input type="text" class="form-control rounded-3" id="name" name="name" value="{{ old('name') }}"
                    required autofocus autocomplete="name" placeholder="Full Name">
                <label for="name" class="text-muted">{{ __('Full Name') }}</label>
                <x-input-error :messages="$errors->get('name')" class="text-danger small mt-1" />
            </div>

            <div class="form-floating mb-3">
                <input type="email" class="form-control rounded-3" id="email" name="email" value="{{ old('email') }}"
                    required autocomplete="username" placeholder="name@example.com">
                <label for="email" class="text-muted">{{ __('Email Address') }}</label>
                <x-input-error :messages="$errors->get('email')" class="text-danger small mt-1" />
            </div>

            <div class="form-floating mb-3">
                <input type="password" class="form-control rounded-3" id="password" name="password" required
                    autocomplete="new-password" placeholder="Password">
                <label for="password" class="text-muted">{{ __('Password') }}</label>
                <x-input-error :messages="$errors->get('password')" class="text-danger small mt-1" />
            </div>

            <div class="form-floating mb-4">
                <input type="password" class="form-control rounded-3" id="password_confirmation"
                    name="password_confirmation" required autocomplete="new-password" placeholder="Confirm Password">
                <label for="password_confirmation" class="text-muted">{{ __('Confirm Password') }}</label>
                <x-input-error :messages="$errors->get('password_confirmation')" class="text-danger small mt-1" />
            </div>

            <div class="d-grid mb-3">
                <button type="submit" class="btn btn-primary fw-bold rounded-pill py-2">
                    {{ __('Register') }}
                </button>
            </div>

            <div class="text-center">
                <small class="text-muted">
                    {{ __('Already registered?') }}
                    <a href="{{ route('login') }}" class="fw-bold">{{ __('Log in') }}</a>
                </small>
            </div>
        </form>
    </div>
</x-guest-layout>