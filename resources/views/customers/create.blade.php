@extends('layouts.master')

@section('title', 'إضافة عميل/مورد - الدفتر الرقمي')

@section('content')
<div class="container-fluid">
    <div class="page-header">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h1 class="page-title">
                    <i class="fas fa-plus me-2"></i>
                    إضافة عميل/مورد جديد
                </h1>
                <p class="page-subtitle">أدخل تفاصيل الحساب الجديد</p>
            </div>
            <a href="{{ route('customers-suppliers.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i>
                العودة إلى القائمة
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('customers-suppliers.store') }}" method="POST">
                @csrf

                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="name" class="form-label">الاسم الكامل *</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}">
                        @error('name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="type" class="form-label">نوع الحساب *</label>
                        <select class="form-select @error('type') is-invalid @enderror" id="type" name="type">
                            <option value="">اختر النوع</option>
                            <option value="customer" {{ old('type') == 'customer' ? 'selected' : '' }}>عميل</option>
                            <option value="supplier" {{ old('type') == 'supplier' ? 'selected' : '' }}>مورد</option>
                        </select>
                        @error('type')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="email" class="form-label">البريد الإلكتروني</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}">
                        @error('email')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="phone" class="form-label">رقم الهاتف</label>
                        <input type="tel" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ old('phone') }}">
                        @error('phone')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    
                    {{-- <div class="col-md-6">
                        <label for="balance" class="form-label">الرصيد الابتدائي</label>
                        <input type="number" step="0.01" class="form-control @error('balance') is-invalid @enderror" id="balance" name="balance" value="{{ old('balance', 0) }}">
                        @error('balance')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                     --}}
                    <div class="col-12">
                        <label for="address" class="form-label">العنوان</label>
                        <textarea class="form-control @error('address') is-invalid @enderror" id="address" name="address" rows="3">{{ old('address') }}</textarea>
                        @error('address')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>
                        حفظ العميل/المورد
                    </button>
                    <a href="{{ route('customers-suppliers.index') }}" class="btn btn-secondary">
                        إلغاء
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection