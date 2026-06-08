@extends('layouts.mainlayout')
@section('title', 'Dashboard')
@section('content')
<div class="main-panel">
    
    <!-- Profile Information Section -->
    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

            <!-- Profile Information -->
            <div class="card shadow-lg rounded-4 border-0 mb-4 p-4 text-center">
                <div class="card-header bg-primary text-white fw-bold rounded-top-4">
                    {{ __('Profile Information') }}
                </div>
                <div class="card-body p-4">
                    
                    <!-- Profile Image -->
                    <div class="d-flex justify-content-center mb-4">
                        <img src="{{ asset('img/1.png') }}" 
                            
                             class="rounded-circle shadow-sm" 
                             width="120" height="120">
                    </div>

                    <!-- User Information -->
                    <h4 class="fw-bold text-primary">{{ Auth::user()->name }}</h4>
                    <p class="text-muted">{{ Auth::user()->email }}</p>

                </div>
            </div>

            <div class="row g-3 mt-2">
                <div class="col-md-4"><a href="{{ route('interviews.index') }}" class="card text-decoration-none p-3 shadow-sm h-100"><strong>Interview Calendar</strong><br><small class="text-muted">Schedule first-year interviews</small></a></div>
                <div class="col-md-4"><a href="{{ route('admin.requirements.index') }}" class="card text-decoration-none p-3 shadow-sm h-100"><strong>Requirements Review</strong><br><small class="text-muted">Approve enrollment documents</small></a></div>
                <div class="col-md-4"><a href="{{ route('modules.reports') }}" class="card text-decoration-none p-3 shadow-sm h-100"><strong>Reports & Analytics</strong><br><small class="text-muted">Enrollment and billing insights</small></a></div>
            </div>
        </div>
    </div>
</div>
@endsection
