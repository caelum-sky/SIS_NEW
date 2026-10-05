<x-guest-layout>
    @if (session('status'))
        <div class="alert alert-success mb-3">{{ session('status') }}</div>
    @endif

    <div class="mb-4">
        <h2 class="h4 fw-bold text-white mb-1">Welcome back</h2>
        <p class="text-sm mb-0" style="color:var(--text-3);">Sign in to continue to your portal.</p>
    </div>

    <form method="POST" action="{{ route('login') }}">
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
            <div class="auth-input-icon mt-1">
                <i class="bi bi-lock"></i>
                <x-text-input id="password" class="block w-full" type="password" name="password" required autocomplete="current-password" placeholder="••••••••" />
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

        <button type="submit" class="btn btn-primary w-100" style="padding:.65rem;">{{ __('Sign in') }}</button>

        <p class="text-center mt-4 mb-0 small" style="color:var(--text-3);">
            <i class="bi bi-shield-lock"></i> Secure authentication — students and administrators only.
        </p>
    </form>
</x-guest-layout>
