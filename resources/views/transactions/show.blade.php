@extends('layouts.master')

@section('title', 'تفاصيل المعاملة - الدفتر الرقمي')

@section('content')
<div class="container-fluid">
    <div class="page-header">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h1 class="page-title">
                    <i class="fas fa-receipt me-2"></i>
                    تفاصيل المعاملة
                </h1>
                <p class="page-subtitle">عرض تفاصيل المعاملة المالية رقم #{{ $transaction->id }}</p>
            </div>
            <a href="{{ route('transactions.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i>
                العودة إلى المعاملات
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-6">
                    <h6 class="text-muted">العميل / المورد</h6>
                    <p class="fs-5 fw-bold">{{ $transaction->customerSupplier->name }}</p>
                </div>
                <div class="col-md-6">
                    <h6 class="text-muted">نوع المعاملة</h6>
                    @if($transaction->type === 'credit')
                        <span class="badge bg-success fs-6">دائن (مقبوضات)</span>
                    @else
                        <span class="badge bg-danger fs-6">مدين (مدفوعات)</span>
                    @endif
                </div>
            </div>

            <hr class="my-4">

            <div class="row g-3">
                <div class="col-md-6">
                    <h6 class="text-muted">المبلغ</h6>
                    <p class="fs-5 fw-bold">{{ number_format($transaction->amount, 2) }} ر.س</p>
                </div>
                <div class="col-md-6">
                    <h6 class="text-muted">التاريخ</h6>
                    <p class="fs-5 fw-bold">{{ $transaction->transaction_date }}</p>
                </div>
            </div>

            <hr class="my-4">

            <div class="row g-3">
                <div class="col-12">
                    <h6 class="text-muted">الوصف</h6>
                    <p class="fs-6">{{ $transaction->description ?: 'لا يوجد وصف.' }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection