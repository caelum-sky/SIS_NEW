@section('title', 'Profile')
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-black leading-tight mb-4">
            {{ __('Profile Settings') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

            <!-- Profile Information -->
            <div class="card shadow-lg rounded-4 border-0 mb-4 p-4">
                <div class="card-header bg-primary text-white fw-bold rounded-top-4">
                    {{ __('Profile Information') }}
                </div>
                <div class="card-body p-4">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <!-- Update Password -->
            <div class="card shadow-lg rounded-4 border-0 mb-4 p-4">
                <div class="card-header bg-warning text-white fw-bold rounded-top-4">
                    {{ __('Update Password') }}
                </div>
                <div class="card-body p-4">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <!-- Delete Account -->
            <div class="card shadow-lg rounded-4 border-0 mb-4 p-4">
                <div class="card-header bg-danger text-white fw-bold rounded-top-4">
                    {{ __('Delete Account') }}
                </div>
                <div class="card-body p-4">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

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

    .btn-warning:hover {
        background-color: #d19a00;
    }

    .btn-danger:hover {
        background-color: #a00000;
    }

    .card {
        border: none;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15);
    }

    .card-header {
        font-weight: bold;
        padding: 12px 20px;
        border-bottom: 2px solid rgba(0, 0, 0, 0.1);
    }

    .card-body {
        padding: 20px;
    }

    input:focus {
        outline: none;
        border-color: #007bff;
        box-shadow: 0 0 8px rgba(0, 123, 255, 0.3);
    }

    .btn-primary {
        background-color: #007bff;
        border: none;
    }

    .alert-success {
        background-color: #d4edda;
        border-color: #c3e6cb;
        color: #155724;
        border-radius: 8px;
        padding: 10px;
    }
</style>
