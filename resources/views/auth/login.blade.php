@extends('layouts.app')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Saira:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

<style>
    /* Reset & Background */
    body {
        background: #f2f2f9 !important;
        font-family: 'Saira', sans-serif !important;
    }

    .login-wrapper {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 20px;
    }

    /* Card Styling khas Volgh */
    .login-card {
        background: #ffffff;
        width: 100%;
        max-width: 450px;
        border-radius: 8px;
        border: none;
        box-shadow: 0 10px 40px rgba(168, 180, 208, 0.2); /* Shadow Volgh */
        overflow: hidden;
    }

    .login-header {
        padding: 40px 40px 20px 40px;
        text-align: center;
    }

    .login-header .logo {
        font-size: 30px;
        font-weight: 700;
        color: #1c273c;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        margin-bottom: 20px;
    }

    .login-header .logo i {
        color: #705ec8; /* Ungu Volgh */
    }

    .login-header h1 {
        font-size: 22px;
        font-weight: 600;
        color: #2b313c;
        margin-bottom: 10px;
    }

    .login-header p {
        color: #9ea9bd;
        font-size: 14px;
    }

    /* Form Styling */
    .card-body {
        padding: 0 40px 40px 40px !important;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-label {
        font-weight: 500;
        color: #50555a;
        font-size: 14px;
        margin-bottom: 8px;
    }

    .form-control {
        height: 45px;
        border: 1px solid #ebedf4;
        border-radius: 4px;
        padding: 10px 15px;
        font-size: 14px;
        transition: all 0.3s;
    }

    .form-control:focus {
        border-color: #705ec8;
        box-shadow: 0 0 0 3px rgba(112, 94, 200, 0.1);
        outline: none;
    }

    /* Button Styling */
    .btn-login {
        background: #705ec8;
        border: none;
        width: 100%;
        height: 45px;
        color: #fff;
        font-weight: 600;
        border-radius: 4px;
        font-size: 16px;
        margin-top: 10px;
        transition: 0.3s;
        box-shadow: 0 4px 15px rgba(112, 94, 200, 0.3);
    }

    .btn-login:hover {
        background: #5e4eb3;
        transform: translateY(-1px);
        box-shadow: 0 6px 20px rgba(112, 94, 200, 0.4);
    }

    /* Social Login (Opsional tapi bikin keren) */
    .social-login {
        display: flex;
        gap: 10px;
        margin-top: 25px;
    }

    .social-btn {
        flex: 1;
        height: 40px;
        border: 1px solid #ebedf4;
        border-radius: 4px;
        display: flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        color: #50555a;
        font-size: 18px;
        transition: 0.3s;
    }

    .social-btn:hover {
        background: #f8f9fa;
        border-color: #cbd4e1;
    }

    .footer-text {
        text-align: center;
        margin-top: 20px;
        font-size: 13px;
        color: #9ea9bd;
    }

    .footer-text a {
        color: #705ec8;
        text-decoration: none;
        font-weight: 600;
    }
</style>

<div class="login-wrapper">
    <div class="login-card">
        <div class="login-header">
            <div class="logo">
                <i class="fas fa-bahai"></i>    Library System
            </div>
            <h1>Welcome Back!</h1>
            <p>Sign in to continue to library system.</p>
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route('authenticate') }}">
                @csrf
                <div class="form-group">
                    <label for="email" class="form-label">Email Address</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" required autofocus>
                </div>

                <div class="form-group">
                    <label for="password" class="form-label">Password</label>
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                         <label class="form-label"></label>
                    </div>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Enter password" required>
                </div>

                <button type="submit" class="btn btn-login">Login</button>

                <div class="footer-text">
             © 2026 Alpnn. All rights reserved.
                </div>
            </form>
        </div>
    </div>
</div>
@endsection