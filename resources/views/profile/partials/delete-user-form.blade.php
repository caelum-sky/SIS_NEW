<form method="post" action="{{ route('profile.destroy') }}" class="p-6">
    @csrf
    @method('delete')

    <!-- Warning Header -->
    <h2 class="text-lg fw-bold text-danger mb-3">
        <i class="bi bi-exclamation-triangle-fill"></i> {{ __('Are you sure you want to delete your account?') }}
    </h2>

    <!-- Warning Description -->
    <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">
        {{ __('All your resources and data will be permanently deleted. Please enter your password to confirm this action.') }}
    </p>

    <!-- Password Input -->
    <div class="mb-4">
        <x-input-label for="password" :value="__('Password')" />
        <x-text-input
            id="password"
            name="password"
            type="password"
            class="mt-2 form-control rounded-3 border-danger shadow-sm px-3 py-2"
            placeholder="{{ __('Enter your password') }}" 
            required
        />
        <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
    </div>

    <!-- Action Buttons -->
    <div class="d-flex justify-content-end gap-3 mt-4">


        <x-danger-button 
            class="btn btn-danger fw-bold rounded-3 px-4 py-2"
        >
            <i class="bi bi-trash3"></i> {{ __('Delete Account') }}
        </x-danger-button>
    </div>
</form>

<!-- Additional Styles -->
<style>
    .btn-danger {
        background-color: #dc3545;
        border-color: #dc3545;
    }

    .btn-danger:hover {
        background-color: #c82333;
        border-color: #bd2130;
    }

    .btn-secondary {
        background-color: #6c757d;
        border-color: #6c757d;
    }

    .btn-secondary:hover {
        background-color: #5a6268;
        border-color: #545b62;
    }

    .alert-success {
        background-color: #d4edda;
        color: #155724;
        border-left: 4px solid #28a745;
        padding: 12px;
        border-radius: 4px;
    }

    .alert-error {
        background-color: #f8d7da;
        color: #721c24;
        border-left: 4px solid #dc3545;
        padding: 12px;
        border-radius: 4px;
    }

    .form-control:focus {
        border-color: #dc3545;
        box-shadow: 0 0 5px rgba(220, 53, 69, 0.5);
    }
</style>
