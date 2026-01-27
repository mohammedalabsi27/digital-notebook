@extends('layouts.master')

@section('title', $customersSupplier->name . ' - الدفتر الرقمي')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-dark fw-bold">{{ $customersSupplier->name }}</h1>
            <p class="text-muted">{{ $customersSupplier->type === 'customer' ? 'عميل' : 'مورد' }}</p>
        </div>
        <div>
            <a href="{{ route('customers-suppliers.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i>العودة
            </a>
            <a href="{{ route('transactions.create', ['customer_supplier_id' => $customersSupplier->id]) }}" class="btn btn-primary">
                <i class="fas fa-plus-circle me-2"></i>إضافة معاملة
            </a>
            <a href="{{ route('customers-suppliers.edit', $customersSupplier->id) }}" class="btn btn-warning">
                <i class="fas fa-edit me-2"></i>تعديل
            </a>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-xl-4 col-md-6">
            <div class="card h-100 shadow-sm border-0">
                <div class="card-body text-center">
                    <p class="mb-2 text-muted fw-bold">الرصيد الحالي</p>
                    <h2 class="display-4 fw-bold mb-0 {{ $customersSupplier->balance() > 0 ? 'text-danger' : 'text-success' }}">
                        {{ number_format(abs($customersSupplier->balance()), 2) }} ر.س
                    </h2>
                    {{-- <small class="text-muted">
                        {{ $customersSupplier->balance() > 0 ? 'مديون' : 'دائن' }}
                    </small> --}}
                </div>
            </div>
        </div>

        <div class="col-xl-8 col-md-6">
            <div class="card h-100 shadow-sm border-0">
                <div class="card-body">
                    <h5 class="card-title fw-bold mb-3">معلومات الاتصال</h5>
                    <ul class="list-unstyled mb-0">
                        @if($customersSupplier->phone)
                        <li class="mb-2"><i class="fas fa-phone-alt me-2 text-primary"></i>{{ $customersSupplier->phone }}</li>
                        @endif
                        @if($customersSupplier->email)
                        <li class="mb-2"><i class="fas fa-envelope me-2 text-primary"></i>{{ $customersSupplier->email }}</li>
                        @endif
                        @if($customersSupplier->address)
                        <li class="mb-2"><i class="fas fa-map-marker-alt me-2 text-primary"></i>{{ $customersSupplier->address }}</li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-header bg-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-bold">سجل المعاملات</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>التاريخ</th>
                            <th>النوع</th>
                            <th>المبلغ</th>
                            <th>الوصف</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($transactions as $transaction)
                        <tr>
                            <td>{{ $transaction->created_at->format('Y-m-d') }}</td>
                            <td>
                                <span class="badge {{ $transaction->type === 'debit' ? 'bg-danger' : 'bg-success' }}">
                                    {{ $transaction->type === 'debit' ? 'دائن' : 'مديون' }}
                                </span>
                            </td>
                            <td>{{ number_format($transaction->amount, 2) }} ر.س</td>
                            <td>{{ $transaction->description ?? 'لا يوجد' }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted">لا توجد معاملات لهذا العميل/المورد.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection