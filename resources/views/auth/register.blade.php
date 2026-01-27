@extends('layouts.guest')

@section('title', 'إنشاء حساب جديد - الدفتر الرقمي')

@section('content')
<div class="auth-header">
    <div class="auth-logo">
        <i class="fas fa-user-plus"></i>
    </div>
    <h1 class="auth-title">إنشاء حساب جديد</h1>
    <p class="auth-subtitle">ابدأ في إدارة دفترك الرقمي اليوم</p>
</div>

<form method="POST" action="{{ route('register') }}">
    @csrf

    <!-- الاسم -->
    <div class="form-group">
        <label for="name" class="form-label">الاسم الكامل</label>
        <input id="name" 
               class="form-input @error('name') border-red-500 @enderror" 
               type="text" 
               name="name" 
               value="{{ old('name') }}" 
               required 
               autofocus 
               autocomplete="name"
               placeholder="أدخل اسمك الكامل">
        @error('name')
            <div class="form-error">{{ $message }}</div>
        @enderror
    </div>

    <!-- البريد الإلكتروني -->
    <div class="form-group">
        <label for="email" class="form-label">البريد الإلكتروني</label>
        <input id="email" 
               class="form-input @error('email') border-red-500 @enderror" 
               type="email" 
               name="email" 
               value="{{ old('email') }}" 
               required 
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
               autocomplete="new-password"
               placeholder="أدخل كلمة مرور قوية">
        @error('password')
            <div class="form-error">{{ $message }}</div>
        @enderror
    </div>

    <!-- تأكيد كلمة المرور -->
    <div class="form-group">
        <label for="password_confirmation" class="form-label">تأكيد كلمة المرور</label>
        <input id="password_confirmation" 
               class="form-input @error('password_confirmation') border-red-500 @enderror" 
               type="password" 
               name="password_confirmation" 
               required 
               autocomplete="new-password"
               placeholder="أعد إدخال كلمة المرور">
        @error('password_confirmation')
            <div class="form-error">{{ $message }}</div>
        @enderror
    </div>

    <!-- زر إنشاء الحساب -->
    <button type="submit" class="btn-primary">
        <i class="fas fa-user-plus me-2"></i>
        إنشاء الحساب
    </button>

    <!-- روابط إضافية -->
    <div class="auth-links">
        <div>
            <span class="text-gray-600">لديك حساب بالفعل؟</span>
            <a href="{{ route('login') }}" class="auth-link">
                <i class="fas fa-sign-in-alt me-1"></i>
                تسجيل الدخول
            </a>
        </div>
    </div>
</form>
@endsection