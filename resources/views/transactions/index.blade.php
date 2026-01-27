@extends('layouts.master')

@section('title', 'المعاملات - الدفتر الرقمي')

@section('styles')
<style>
.page-header {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    padding: 2rem;
    border-radius: 15px;
    margin-bottom: 2rem;
    border: 1px solid #dee2e6;
}

.page-title {
    color: #2c3e50;
    font-size: 2rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
}

.page-subtitle {
    color: #6c757d;
    font-size: 1.1rem;
    margin-bottom: 0;
}

.stats-card {
    background: white;
    border-radius: 15px;
    padding: 1.5rem;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    border: none;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.stats-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: var(--accent-color);
}

.stats-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
}

.stats-card-success::before { background: #28a745; }
.stats-card-danger::before { background: #dc3545; }
.stats-card-info::before { background: #17a2b8; }
.stats-card-warning::before { background: #ffc107; }

.stats-card .stats-icon {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    color: white;
    margin-bottom: 1rem;
}

.stats-card-success .stats-icon { background: #28a745; }
.stats-card-danger .stats-icon { background: #dc3545; }
.stats-card-info .stats-icon { background: #17a2b8; }
.stats-card-warning .stats-icon { background: #ffc107; }

.stats-number {
    font-size: 2rem;
    font-weight: 700;
    color: #2c3e50;
    margin-bottom: 0.5rem;
}

.stats-label {
    color: #6c757d;
    font-size: 0.9rem;
    margin-bottom: 0;
}

.table-header {
    background: linear-gradient(135deg, #2563eb, #1d4ed8);
    color: white;
}

.table-header th {
    border: none;
    font-weight: 600;
    padding: 1rem 0.75rem;
}

.table-hover tbody tr:hover {
    background-color: rgba(37, 99, 235, 0.05);
}

.transaction-type-credit {
    background: #d4edda;
    color: #155724;
    padding: 0.25rem 0.75rem;
    border-radius: 20px;
    font-size: 0.875rem;
    font-weight: 500;
}

.transaction-type-debit {
    background: #f8d7da;
    color: #721c24;
    padding: 0.25rem 0.75rem;
    border-radius: 20px;
    font-size: 0.875rem;
    font-weight: 500;
}

.transaction-amount-credit {
    color: #28a745;
    font-weight: 600;
}

.transaction-amount-debit {
    color: #dc3545;
    font-weight: 600;
}

.action-btn {
    width: 35px;
    height: 35px;
    border-radius: 50%;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border: none;
    margin: 0 2px;
    transition: all 0.3s ease;
}

.action-btn:hover {
    transform: scale(1.1);
}

.btn-view {
    background: #17a2b8;
    color: white;
}

.btn-edit {
    background: #ffc107;
    color: #212529;
}

.btn-delete {
    background: #dc3545;
    color: white;
}

.form-label.required::after {
    content: ' *';
    color: #dc3545;
}

.pagination-info {
    color: #6c757d;
    font-size: 0.9rem;
}

.empty-state {
    text-align: center;
    padding: 3rem;
    color: #6c757d;
}

.empty-state i {
    font-size: 4rem;
    margin-bottom: 1rem;
    opacity: 0.5;
}

@media (max-width: 768px) {
    .page-header {
        padding: 1rem;
    }
    
    .page-title {
        font-size: 1.5rem;
    }
    
    .stats-card {
        margin-bottom: 1rem;
    }
    
    .table-responsive {
        font-size: 0.875rem;
    }
    
    .action-btn {
        width: 30px;
        height: 30px;
    }
}
</style>
@endsection

@section('content')
<div class="container-fluid">
    <div class="page-header">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h1 class="page-title">
                    <i class="fas fa-exchange-alt me-2"></i>
                    إدارة المعاملات
                </h1>
                <p class="page-subtitle">عرض وإدارة جميع المعاملات المالية</p>
            </div>
            <a href="{{ route('transactions.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i>
                إضافة معاملة جديدة
            </a>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-3">
            <div class="stats-card stats-card-success">
                <div class="stats-icon">
                    <i class="fas fa-arrow-up"></i>
                </div>
                <div class="stats-content">
                    <h3 class="stats-number">{{ number_format($totalCredits, 2) }} ر.س</h3>
                    <p class="stats-label">إجمالي المقبوضات</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stats-card stats-card-danger">
                <div class="stats-icon">
                    <i class="fas fa-arrow-down"></i>
                </div>
                <div class="stats-content">
                    <h3 class="stats-number">{{ number_format($totalDebits, 2) }} ر.س</h3>
                    <p class="stats-label">إجمالي المدفوعات</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stats-card stats-card-info">
                <div class="stats-icon">
                    <i class="fas fa-list"></i>
                </div>
                <div class="stats-content">
                    <h3 class="stats-number">{{ $totalTransactions }}</h3>
                    <p class="stats-label">إجمالي المعاملات</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stats-card stats-card-warning">
                <div class="stats-icon">
                    <i class="fas fa-balance-scale"></i>
                </div>
                <div class="stats-content">
                    <h3 class="stats-number">{{ number_format($netBalance, 2) }} ر.س</h3>
                    <p class="stats-label">الرصيد الصافي</p>
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <form action="{{ route('transactions.index') }}" method="GET">
                <div class="row">
                    <div class="col-md-3">
                        <label class="form-label">البحث</label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="fas fa-search"></i>
                            </span>
                            <input type="text" class="form-control" name="search" placeholder="البحث في المعاملات..." value="{{ request('search') }}">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">نوع المعاملة</label>
                        <select class="form-select" name="type">
                            <option value="">جميع الأنواع</option>
                            <option value="credit" {{ request('type') == 'credit' ? 'selected' : '' }}>دائن</option>
                            <option value="debit" {{ request('type') == 'debit' ? 'selected' : '' }}>مدين</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">العميل/المورد</label>
                        <select class="form-select" name="customer_supplier_id">
                            <option value="">الكل</option>
                             @foreach ($customersSuppliers as $customerSupplier)
                                <option value="{{ $customerSupplier->id }}" {{ request('customer_supplier_id') == $customerSupplier->id ? 'selected' : '' }}>
                                    {{ $customerSupplier->name }}
                                </option>
                            @endforeach 
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">من تاريخ</label>
                        <input type="date" class="form-control" name="date_from" value="{{ request('date_from') }}">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">إلى تاريخ</label>
                        <input type="date" class="form-control" name="date_to" value="{{ request('date_to') }}">
                    </div>
                    <div class="col-md-1">
                        <label class="form-label">&nbsp;</label>
                        <button type="submit" class="btn btn-primary w-100">
                             <i class="fas fa-filter"></i>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif --}}

    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">
                    <i class="fas fa-table me-2"></i>
                    قائمة المعاملات
                </h5>
                <div class="btn-group">
                    <a href="{{-- route('transactions.export', ['format' => 'excel']) --}}" class="btn btn-outline-primary btn-sm">
                        <i class="fas fa-file-excel me-1"></i>
                        Excel
                    </a>
                    <a href="{{-- route('transactions.export', ['format' => 'pdf']) --}}" class="btn btn-outline-primary btn-sm">
                        <i class="fas fa-file-pdf me-1"></i>
                        PDF
                    </a>
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0" id="transactionsTable">
                    <thead class="table-header">
                        <tr>
                            <th width="5%">#</th>
                            <th width="15%">التاريخ</th>
                            <th width="20%">العميل/المورد</th>
                            <th width="10%">النوع</th>
                            <th width="15%">المبلغ</th>
                            <th width="10%">الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($transactions as $index => $transaction)
                            <tr>
                                <td>{{ $transactions->firstItem() + $index }}</td>
                                <td>{{ $transaction->transaction_date }}</td>
                                <td>{{ $transaction->customerSupplier->name ?? 'غير محدد' }}</td>
                                <td>
                                    <span class="transaction-type-{{ $transaction->type }}">
                                        {{ $transaction->type === 'credit' ? 'دائن' : 'مدين' }}
                                    </span>
                                </td>
                                <td class="transaction-amount-{{ $transaction->type }}">
                                    {{ number_format($transaction->amount, 2) }} ر.س
                                </td>
                                <td class="d-flex">
                                    <a href="{{ route('transactions.show', $transaction->id) }}" class="btn btn-outline-primary btn-sm me-1" title="عرض">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('transactions.edit', $transaction->id) }}" class="btn btn-outline-warning btn-sm me-1" title="تعديل">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <!-- زر الحذف -->
                                    <button type="button" class="btn btn-outline-danger btn-sm me-1" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $transaction->id }}" title="حذف">
                                        <i class="fas fa-trash"></i>
                                    </button>


                                </td>
                            </tr>
                            
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4">
                                    <div class="empty-state">
                                        <i class="fas fa-inbox"></i>
                                        <p>لا توجد معاملات لعرضها</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                
            </div>
        </div>
        
        <div class="card-footer">
            <div class="d-flex justify-content-between align-items-center">
                <div class="pagination-info">
                    عرض {{ $transactions->firstItem() ?? 0 }} إلى {{ $transactions->lastItem() ?? 0 }} من {{ $transactions->total() }} معاملة
                </div>
                <nav>
                    {{ $transactions->appends(request()->except('page'))->links('pagination::bootstrap-5') }}
                </nav>
            </div>
        </div>
    </div>
</div>
@foreach($transactions as $transaction)
<div class="modal fade" id="deleteModal{{ $transaction->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $transaction->id }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel{{ $transaction->id }}">تأكيد الحذف</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="إغلاق"></button>
            </div>
            <div class="modal-body">
                هل أنت متأكد من حذف المعاملة رقم #{{ $transaction->id }}؟
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                <form action="{{ route('transactions.destroy', $transaction->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">حذف</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endforeach
@endsection

