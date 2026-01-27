@extends('layouts.guest')

@section('title', 'تسجيل الدخول - الدفتر الرقمي')

@section('content')
<div class="auth-header">
    <div class="auth-logo">
        <i class="fas fa-book-open"></i>
    </div>
    <h1 class="auth-title">مرحباً بك مرة أخرى</h1>
    <p class="auth-subtitle">سجل دخولك للوصول إلى دفترك الرقمي</p>
</div>

<!-- رسالة الحالة -->
@if (session('status'))
    <div class="status-message">
        {{ session('status') }}
    </div>
@endif

<form method="POST" action="{{ route('login') }}">
    @csrf

    <!-- البريد الإلكتروني -->
    <div class="form-group">
        <label for="email" class="form-label">البريد الإلكتروني</label>
        <input id="email" 
               class="form-input @error('email') border-red-500 @enderror" 
               type="email" 
               name="email" 
               value="{{ old('email') }}" 
               required 
               autofocus 
               autocomplete="username"
               placeholder="أدخل بريدك الإلكتروني">
        @error('email')
            <div class="form-error">{{ $message }}</div>
        @enderror
    </div>

    <!-- كلمة المرور -->
    <div class="form-group">
        <label for="password" class="form-label">كلمة المرور</label>
        <input id="password" 
               class="form-input @error('password') border-red-500 @enderror" 
               type="password" 
               name="password" 
               required 
               autocomplete="current-password"
               placeholder="أدخل كلمة المرور">
        @error('password')
            <div class="form-error">{{ $message }}</div>
        @enderror
    </div>

    <!-- تذكرني -->
    <div class="checkbox-container">
        <label for="remember_me" class="checkbox-label">
            <input id="remember_me" type="checkbox" name="remember">
            تذكرني
        </label>
    </div>

    <!-- زر تسجيل الدخول -->
    <button type="submit" class="btn-primary">
        <i class="fas fa-sign-in-alt me-2"></i>
        تسجيل الدخول
    </button>

    <!-- روابط إضافية -->
    <div class="auth-links">
        @if (Route::has('password.request'))
            <div class="forgot-password">
                <a href="{{ route('password.request') }}" class="auth-link">
                    <i class="fas fa-key me-1"></i>
                    نسيت كلمة المرور؟
                </a>
            </div>
        @endif
        
        @if (Route::has('register'))
            <div style="margin-top: 1rem;">
                <span class="text-gray-600">ليس لديك حساب؟</span>
                <a href="{{ route('register') }}" class="auth-link">
                    <i class="fas fa-user-plus me-1"></i>
                    إنشاء حساب جديد
                </a>
            </div>
        @endif
    </div>
</form>
@endsection