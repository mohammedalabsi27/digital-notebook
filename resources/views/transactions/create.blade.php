@extends('layouts.master')

@section('title', 'إضافة معاملة جديدة - الدفتر الرقمي')

@section('content')
<div class="container-fluid">
    <div class="page-header">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h1 class="page-title">
                    <i class="fas fa-plus me-2"></i>
                    إضافة معاملة جديدة
                </h1>
                <p class="page-subtitle">أدخل تفاصيل المعاملة المالية الجديدة</p>
            </div>
            <a href="{{ route('transactions.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i>
                العودة إلى المعاملات
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h5 class="card-title mb-0">
                <i class="fas fa-file-alt me-2"></i>
                بيانات المعاملة
            </h5>
        </div>
        <div class="card-body">
            <form action="{{ route('transactions.store') }}" method="POST">
                @csrf

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="customer_supplier_id" class="form-label required">العميل/المورد</label>
                            <select class="form-select @error('customer_supplier_id') is-invalid @enderror" id="customer_supplier_id" name="customer_supplier_id" >
                                <option value="">اختر العميل أو المورد</option>
                                @foreach($customersSuppliers as $cs)
                                    <option value="{{ $cs->id }}" {{ old('customer_supplier_id') == $cs->id ? 'selected' : '' }}>
                                        {{ $cs->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('customer_supplier_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="type" class="form-label required">نوع المعاملة</label>
                            <select class="form-select @error('type') is-invalid @enderror" id="type" name="type" >
                                <option value="">اختر نوع المعاملة</option>
                                <option value="credit" {{ old('type') == 'credit' ? 'selected' : '' }}>دائن (مقبوضات)</option>
                                <option value="debit" {{ old('type') == 'debit' ? 'selected' : '' }}>مدين (مدفوعات)</option>
                            </select>
                            @error('type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="amount" class="form-label required">المبلغ</label>
                            <div class="input-group">
                                <input type="number" class="form-control @error('amount') is-invalid @enderror" id="amount" name="amount"
                                       step="0.01"   placeholder="0.00" value="{{ old('amount') }}">
                                <span class="input-group-text">ر.س</span>
                            </div>
                            @error('amount')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="transaction_date" class="form-label">التاريخ</label>
                            <input type="date" class="form-control @error('transaction_date') is-invalid @enderror" id="transaction_date" name="transaction_date"
                                   value="{{ old('transaction_date', date('Y-m-d')) }}">
                            @error('transaction_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">الوصف</label>
                    <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description"
                              rows="3" placeholder="وصف المعاملة (اختياري)">{{ old('description') }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex justify-content-start">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i>
                        حفظ المعاملة
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection