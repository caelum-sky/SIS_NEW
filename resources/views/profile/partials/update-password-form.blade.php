

    <form method="POST" action="{{ route('password.update') }}">
        @csrf
        @method('PUT')

        <!-- Current Password -->
        <div class="mb-4">
            <label for="update_password_current_password" class="form-label fw-bold">{{ __('Current Password') }}</label>
            <input 
                type="password" 
                id="update_password_current_password" 
                name="current_password" 
                class="form-control rounded-3 shadow-sm px-3 py-2"
                placeholder="Enter your current password"
                autocomplete="current-password"
                required
            />
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
        </div>

        <!-- New Password -->
        <div class="mb-4">
            <label for="update_password_password" class="form-label fw-bold">{{ __('New Password') }}</label>
            <input 
                type="password" 
                id="update_password_password" 
                name="password" 
                class="form-control rounded-3 shadow-sm px-3 py-2"
                placeholder="Enter your new password"
                autocomplete="new-password"
                required
            />
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mb-4">
            <label for="update_password_password_confirmation" class="form-label fw-bold">{{ __('Confirm Password') }}</label>
            <input 
                type="password" 
                id="update_password_password_confirmation" 
                name="password_confirmation" 
                class="form-control rounded-3 shadow-sm px-3 py-2"
                placeholder="Confirm your new password"
                autocomplete="new-password"
                required
            />
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
        </div>

        <!-- Save Button -->
        <button type="submit" class="btn btn-primary w-100 rounded-3 shadow-sm">
            <i class="bi bi-save"></i> {{ __('Save Changes') }}
        </button>

        <!-- Success Message -->
        @if (session('status') === 'password-updated')
            <div class="alert alert-success mt-4 text-center rounded-3 py-3">
                <i class="bi bi-check-circle"></i> {{ __('Password updated successfully!') }}
            </div>
        @endif
    </form>

    <style>
        .btn {
            padding: 10px 20px;
            border-radius: 8px;
            box-shadow: 2px 2px 8px rgba(0, 0, 0, 0.15);
            transition: background 0.3s ease-in-out;
        }

        .btn-primary:hover {
            background-color: #004080;
        }

        .alert-success {
            background-color: #d4edda;
            border-color: #c3e6cb;
            color: #155724;
            border-radius: 8px;
            padding: 10px;
        }

        .form-control:focus {
            outline: none;
            border-color: #007bff;
            box-shadow: 0 0 8px rgba(0, 123, 255, 0.3);
        }
    </style>

