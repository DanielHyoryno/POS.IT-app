<x-guest-layout>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
    /* Override sedikit style Tailwind agar tidak bentrok dengan Bootstrap */
    .form-control:focus {
        border-color: #86b7fe;
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
    }

    a {
        text-decoration: none;
    }
    </style>

    <x-auth-session-status class="mb-3 alert alert-success" :status="session('status')" />

    <div class="py-3">
        <div class="text-center mb-4">
            <h3 class="fw-bold text-dark">{{ __('Welcome to POS.it!') }}</h3>
            <p class="text-muted small">Please enter your details to login.</p>
        </div>

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="form-floating mb-3">
                <input type="email" class="form-control rounded-3" id="email" name="email" value="{{ old('email') }}"
                    required autofocus autocomplete="username" placeholder="name@example.com">
                <label for="email" class="text-muted">{{ __('Email Address') }}</label>
                <x-input-error :messages="$errors->get('email')" class="text-danger small mt-1" />
            </div>

            <div class="form-floating mb-3">
                <input type="password" class="form-control rounded-3" id="password" name="password" required
                    autocomplete="current-password" placeholder="Password">
                <label for="password" class="text-muted">{{ __('Password') }}</label>
                <x-input-error :messages="$errors->get('password')" class="text-danger small mt-1" />
            </div>

            <div class="d-flex justify-content-between align-items-center mb-4">
                <div class="form-check">
                    <input id="remember_me" type="checkbox" class="form-check-input" name="remember">
                    <label for="remember_me" class="form-check-label small text-muted">
                        {{ __('Remember me') }}
                    </label>
                </div>

                @if (Route::has('password.request'))
                <a class="small fw-bold text-primary" href="{{ route('password.request') }}">
                    {{ __('Forgot Password?') }}
                </a>
                @endif
            </div>

            <div class="d-grid">
                <button type="submit" class="btn btn-primary fw-bold rounded-pill py-2">
                    {{ __('Log in') }}
                </button>
            </div>

            <div class="text-center mt-3">
                <small class="text-muted">Don't have an account? <a href="{{ route('register') }}" class="fw-bold">Sign
                        up</a></small>
            </div>
        </form>
    </div>
</x-guest-layout>