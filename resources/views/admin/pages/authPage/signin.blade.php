@extends('admin.layouts.master')

@section('content')
<style>
    .mainContaint {
        margin-top: 13%;
    }
</style>
<div class="mainContaint">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-4">
                <div class="card shadow-sm rounded-4">
                    <div class="card-body p-4">
                        <h4 class="card-title text-center mb-4">Sign In</h4>
                        <form action="{{route('login.submit')}}" method="POST">
                            <!-- If using Laravel, include CSRF -->
                            @csrf

                            <div class="mb-3">
                                <label for="email" class="form-label">Email address</label>
                                <input
                                    type="email"
                                    class="form-control"
                                    id="email"
                                    name="email"
                                    placeholder="name@example.com"
                                    required>
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input
                                    type="password"
                                    class="form-control"
                                    id="password"
                                    name="password"
                                    placeholder="Enter your password"
                                    required>
                            </div>

                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="rememberMe">
                                    <label class="form-check-label" for="rememberMe">
                                        Remember me
                                    </label>
                                </div>
                                <a href="/forgot-password" class="small text-decoration-none">Forgot password?</a>
                            </div>

                            <button type="submit" class="btn btn-primary w-100">Sign In</button>

                            <p class="text-center mt-3 mb-0">
                                Don't have an account?
                                <a href="{{route('registerpage')}}" class="text-decoration-none">Sign Up</a>
                            </p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection