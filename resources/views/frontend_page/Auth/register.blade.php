<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-5" style="max-width: 500px;">
        <h3 class="mb-4 text-center">Register New Admin</h3>

        <form action="{{route('user.registerpost')}}" method="POST">
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
                <a href="{{route('user.login')}}">Already have an account? Login</a>
            </div>
        </form>
    </div>
</body>

</html>