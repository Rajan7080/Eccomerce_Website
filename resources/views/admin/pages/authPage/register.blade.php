@extends('admin.layouts.master')

@section('content')
@extends('admin.layouts.master')

@section('content')
<div class="container mt-5" style="max-width: 500px;">
    <h3 class="mb-4 text-center">Register New Admin</h3>

    <form action="{{ route('submit.register') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="name" class="form-label">Full Name</label>
            <input type="text" name="name" class="form-control" required value="{{ old('name') }}">
            @error('name')
            <div class="text-danger small">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email address</label>
            <input type="email" name="email" class="form-control" required value="{{ old('email') }}">
            @error('email')
            <div class="text-danger small">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Password (min 6 characters)</label>
            <input type="password" name="password" class="form-control" required>
            @error('password')
            <div class="text-danger small">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary w-100">Register</button>

        <div class="text-center mt-3">
            <a href="{{ route('loginpage') }}">Already have an account? Login</a>
        </div>
    </form>
</div>
@endsection

@endsection