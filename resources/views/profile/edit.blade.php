@extends('layouts.mainlayout')
@section('title', 'Settings')
@section('content')

<div class="py-4">
    <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

        <!-- Profile Information -->
        <div class="card shadow-lg rounded-4 border-0 mb-4">
            <div class="card-header bg-primary text-white fw-bold">
                {{ __('Profile Information') }}
            </div>
            <div class="card-body p-4">
                @include('profile.partials.update-profile-information-form')
            </div>
        </div>

        <!-- Update Password -->
        <div class="card shadow-lg rounded-4 border-0 mb-4">
            <div class="card-header bg-warning fw-bold">
                {{ __('Update Password') }}
            </div>
            <div class="card-body p-4">
                @include('profile.partials.update-password-form')
            </div>
        </div>

        <!-- Delete Account -->
        <div class="card shadow-lg rounded-4 border-0 mb-4">
            <div class="card-header bg-danger text-white fw-bold">
                {{ __('Delete Account') }}
            </div>
            <div class="card-body p-4">
                @include('profile.partials.delete-user-form')
            </div>
        </div>

    </div>
</div>
@endsection
