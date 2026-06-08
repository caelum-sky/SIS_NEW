<form method="POST" action="{{ route('profile.update') }}">
    @csrf
    @method('PATCH')

    <div class="mb-4">
        <label for="name" class="form-label fw-bold">Name</label>
        <input type="text" id="name" name="name" class="form-control rounded-3"
               value="{{ old('name', $user->name) }}" required>
    </div>

    <div class="mb-4">
        <label for="email" class="form-label fw-bold">Email</label>
        <input type="email" id="email" name="email" class="form-control rounded-3"
               value="{{ old('email', $user->email) }}" required>
    </div>

    <button type="submit" class="btn btn-primary w-100 rounded-3 shadow-sm">
        <i class="bi bi-save"></i> Save Changes
    </button>

    @if (session('success'))
        <div class="alert alert-success mt-3">{{ session('success') }}</div>
    @endif
    

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

.btn-primary:hover {
    background-color: #0056b3;
}

.alert-success {
    background-color: #d4edda;
    border-color: #c3e6cb;
    color: #155724;
    border-radius: 8px;
    padding: 10px;
}

    </style>
</form>
