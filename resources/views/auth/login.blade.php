<x-guest-layout>
    @if (session('status'))
        <div class="alert alert-success mb-3">{{ session('status') }}</div>
    @endif

    <div class="text-center mb-4">
        <span class="brand-mark d-inline-grid" style="width:48px;height:48px;border-radius:14px;background:linear-gradient(135deg,#2563EB,#06B6D4);color:#fff;font-size:1.3rem;place-items:center;box-shadow:0 8px 24px -8px rgba(37,99,235,.7);"><i class="bi bi-mortarboard-fill"></i></span>
        <h1 class="h4 fw-bold text-white mb-1 mt-3">Welcome back</h1>
        <p class="text-sm mb-0" style="color:var(--text-3);">{{ config('app.school_name') }} — sign in to continue.</p>
    </div>

    <form method="POST" action="{{ route('login') }}" id="loginForm">
        @csrf

        <div class="mb-3">
            <x-input-label for="email" :value="__('Email')" />
            <div class="auth-input-icon mt-1">
                <i class="bi bi-envelope"></i>
                <x-text-input id="email" class="block w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="you@example.com" />
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="mb-3">
            <x-input-label for="password" :value="__('Password')" />
            <div class="auth-input-icon mt-1 position-relative">
                <i class="bi bi-lock"></i>
                <x-text-input id="password" class="block w-full" type="password" name="password" required autocomplete="current-password" placeholder="••••••••" />
                <button type="button" id="togglePassword" class="position-absolute end-0 top-50 translate-middle-y me-2 btn btn-link btn-sm p-0 text-muted" aria-label="Show password">
                    <i class="bi bi-eye" id="togglePasswordIcon"></i>
                </button>
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="d-flex align-items-center justify-content-between mb-4">
            <label for="remember_me" class="d-flex align-items-center gap-2 small" style="color:var(--text-3);">
                <input id="remember_me" type="checkbox" name="remember">
                Remember me
            </label>
            @if (Route::has('password.request'))
                <a class="small" href="{{ route('password.request') }}">Forgot password?</a>
            @endif
        </div>

        <button type="submit" id="signInBtn" class="btn btn-primary w-100" style="padding:.65rem;">
            <span id="signInLabel">{{ __('Sign in') }}</span>
            <span id="signInSpinner" class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
        </button>

        <p class="text-center mt-4 mb-0 small" style="color:var(--text-3);">
            <i class="bi bi-shield-lock"></i> Secure authentication — students and administrators only.
        </p>
    </form>

    <script>
        (function () {
            var t = document.getElementById('togglePassword'), i = document.getElementById('togglePasswordIcon'), p = document.getElementById('password');
            if (t && p) t.addEventListener('click', function () {
                var show = p.type === 'password';
                p.type = show ? 'text' : 'password';
                i.className = show ? 'bi bi-eye-slash' : 'bi bi-eye';
            });
            var form = document.getElementById('loginForm'), btn = document.getElementById('signInBtn'), label = document.getElementById('signInLabel'), spinner = document.getElementById('signInSpinner');
            if (form) form.addEventListener('submit', function () {
                btn.disabled = true;
                label.textContent = 'Signing in... ';
                spinner.classList.remove('d-none');
            });
        })();
    </script>
</x-guest-layout>
