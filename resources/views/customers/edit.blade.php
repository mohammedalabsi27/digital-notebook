@extends('layouts.master')

@section('title', 'تعديل بيانات - الدفتر الرقمي')

@section('content')
<div class="container-fluid">
    <div class="page-header">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h1 class="page-title">
                    <i class="fas fa-edit me-2"></i>
                    تعديل بيانات: {{ $customersSupplier->name }}
                </h1>
                <p class="page-subtitle">قم بتحديث معلومات الحساب</p>
            </div>
            <a href="{{ route('customers-suppliers.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i>
                العودة إلى القائمة
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('customers-suppliers.update', $customersSupplier->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="name" class="form-label">الاسم الكامل *</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $customersSupplier->name) }}">
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
                            <option value="customer" {{ old('type', $customersSupplier->type) == 'customer' ? 'selected' : '' }}>عميل</option>
                            <option value="supplier" {{ old('type', $customersSupplier->type) == 'supplier' ? 'selected' : '' }}>مورد</option>
                        </select>
                        @error('type')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="email" class="form-label">البريد الإلكتروني</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $customersSupplier->email) }}">
                        @error('email')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="phone" class="form-label">رقم الهاتف</label>
                        <input type="tel" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ old('phone', $customersSupplier->phone) }}">
                        @error('phone')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    
                    <div class="col-12">
                        <label for="address" class="form-label">العنوان</label>
                        <textarea class="form-control @error('address') is-invalid @enderror" id="address" name="address" rows="3">{{ old('address', $customersSupplier->address) }}</textarea>
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
                        حفظ التعديلات
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