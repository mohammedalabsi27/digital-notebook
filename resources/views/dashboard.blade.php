@extends('layouts.master')

@section('title', 'لوحة التحكم - دفتر المحل')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-dark fw-bold">لوحة التحكم</h1>
        <a href="{{ route('transactions.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>إضافة معاملة جديدة
        </a>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="card stats-card h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <p class="stats-label">إجمالي العملاء</p>
                            <h3 class="stats-number text-primary">{{ $totalCustomers }}</h3>
                        </div>
                        <div class="text-primary">
                            <i class="fas fa-users fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card stats-card success h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <p class="stats-label">إجمالي الموردين</p>
                            <h3 class="stats-number text-success">{{ $totalSuppliers }}</h3>
                        </div>
                        <div class="text-success">
                            <i class="fas fa-building fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card stats-card danger h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <p class="stats-label">إجمالي الديون</p>
                            <h3 class="stats-number text-danger">{{ number_format($totalDebts, 2) }} ر.س</h3>
                        </div>
                        <div class="text-danger">
                            <i class="fas fa-arrow-up fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card stats-card warning h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <p class="stats-label">إجمالي المستحقات</p>
                            <h3 class="stats-number text-success">{{ number_format($totalCredits, 2) }} ر.س</h3>
                        </div>
                        <div class="text-success">
                            <i class="fas fa-arrow-down fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-xl-8">
            <div class="card card-rounded card-shadow">
                <div class="card-header">
                    <h5 class="mb-0">ملخص المعاملات الشهرية</h5>
                </div>
                <div class="card-body">
                    <canvas id="monthlyTransactionsChart"></canvas>
                </div>
            </div>
        </div>
        <div class="col-xl-4">
            <div class="card card-rounded card-shadow h-100">
                <div class="card-header">
                    <h5 class="mb-0">توزيع العملاء والموردين</h5>
                </div>
                <div class="card-body d-flex align-items-center justify-content-center">
                    <canvas id="customerSupplierChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-xl-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">آخر المعاملات</h5>
                    <a href="{{ route('transactions.index') }}" class="btn btn-outline-primary btn-sm">
                        عرض الكل
                    </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>العميل/المورد</th>
                                    <th>النوع</th>
                                    <th>المبلغ</th>
                                    <th>التاريخ</th>
                                    <th>الوصف</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentTransactions as $transaction)
                                    <tr class="transaction-row transaction-type-{{ $transaction->type }}">
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="bg-{{ $transaction->type === 'debit' ? 'danger' : 'success' }} text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                                    <i class="fas fa-user"></i>
                                                </div>
                                                <div>
                                                    <h6 class="mb-0">{{ $transaction->customerSupplier->name ?? 'لا يوجد' }}</h6>
                                                    <small class="text-muted">{{ $transaction->customerSupplier->type === 'customer' ? 'عميل' : 'مورد' }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td><span class="badge bg-{{ $transaction->type === 'debit' ? 'danger' : 'success' }}">{{ $transaction->type === 'debit' ? 'مدين' : 'دائن' }}</span></td>
                                        <td class="fw-bold text-{{ $transaction->type === 'debit' ? 'danger' : 'success' }}">{{ number_format($transaction->amount, 2) }} ر.س</td>
                                        <td>{{ $transaction->transaction_date->format('Y-m-d') }}</td>
                                        <td>{{ $transaction->description ?? 'لا يوجد' }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">لا توجد معاملات حالياً.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">أكبر العملاء مديونية</h5>
                </div>
                <div class="card-body">
                    @forelse($topCustomers as $customer)
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <h6 class="mb-0">{{ $customer->name }}</h6>
                            <small class="text-muted">إجمالي {{ number_format($customer->balance(), 2) }} ر.س</small>
                        </div>
                        <span class="text-danger fw-bold">{{ number_format($customer->balance(), 2) }} ر.س</span>
                    </div>
                    @empty
                    <p class="text-center text-muted">لا توجد بيانات حالياً.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script>
    // بيانات الرسوم البيانية من المتحكم
    const monthlyLabels = @json($chartData['monthlyLabels']);
    const monthlyDebits = @json($chartData['monthlyDebits']);
    const monthlyCredits = @json($chartData['monthlyCredits']);
    const customerCount = @json($chartData['customerCount']);
    const supplierCount = @json($chartData['supplierCount']);

    // Chart 1: Monthly Transactions Chart
    const monthlyTransactionsCtx = document.getElementById('monthlyTransactionsChart').getContext('2d');
    new Chart(monthlyTransactionsCtx, {
        type: 'line',
        data: {
            labels: monthlyLabels,
            datasets: [
                {
                    label: 'الديون (مدين)',
                    data: monthlyDebits,
                    borderColor: '#dc2626',
                    backgroundColor: 'rgba(220, 38, 38, 0.1)',
                    tension: 0.4,
                    fill: true
                },
                {
                    label: 'المستحقات (دائن)',
                    data: monthlyCredits,
                    borderColor: '#16a34a',
                    backgroundColor: 'rgba(22, 163, 74, 0.1)',
                    tension: 0.4,
                    fill: true
                }
            ]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            },
            plugins: {
                legend: {
                    position: 'top',
                    align: 'end',
                    labels: {
                        usePointStyle: true,
                        boxWidth: 8,
                        padding: 20
                    }
                }
            }
        }
    });

    // Chart 2: Customer vs Supplier Chart
    const customerSupplierCtx = document.getElementById('customerSupplierChart').getContext('2d');
    new Chart(customerSupplierCtx, {
        type: 'doughnut',
        data: {
            labels: ['العملاء', 'الموردين'],
            datasets: [{
                data: [customerCount, supplierCount],
                backgroundColor: ['#2563eb', '#16a34a'],
                hoverOffset: 4
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        usePointStyle: true,
                        boxWidth: 8,
                        padding: 20
                    }
                }
            }
        }
    });
</script>
@endsection