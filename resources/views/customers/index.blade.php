@extends('layouts.master')

@section('title', 'العملاء والموردون - الدفتر الرقمي')

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
    /* أنماط البطاقات */
    .customer-card {
        transition: all 0.3s ease;
        border: 1px solid #e2e8f0;
    }

    .customer-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
        border-color: var(--primary-color, #007bff);
    }

    /* أيقونة الصورة الشخصية/الشركة */
    /* .customer-avatar {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
        font-weight: bold;
        color: white;
    } */

    /* أنماط الرصيد */
    .balance-positive {
        color: #28a745; /* Bootstrap success color */
    }

    .balance-negative {
        color: #dc3545; /* Bootstrap danger color */
    }

    .balance-zero {
        color: #6c757d; /* Bootstrap secondary color */
    }

    .action-buttons .btn {
        width: 35px;
        height: 35px;
        padding: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        margin: 0 2px;
    }
</style>
@endsection

@section('content')
<div class="container-fluid">
    <div class="page-header">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h1 class="page-title">
                    <i class="fas fa-users me-2"></i>
                    العملاء والموردون
                </h1>
                <p class="page-subtitle">إدارة جميع العملاء والموردين في النظام</p>
            </div>
            <a href="{{ route('customers-suppliers.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i>
                إضافة جديد
            </a>
        </div>
    </div>

        <!-- Filters -->
    <div class="card filter-card mb-4">
        <div class="card-body">
            <form action="{{ route('customers-suppliers.index') }}" method="GET" class="row g-3">
                <div class="col-md-6">
                    <input type="text" name="search" class="form-control" placeholder="ابحث بالاسم أو رقم الهاتف..." value="{{ request('search') }}">
                </div>
                <div class="col-md-3">
                    <select name="type" class="form-select">
                        <option value="">الكل</option>
                        <option value="customer" {{ request('type') == 'customer' ? 'selected' : '' }}>العملاء</option>
                        <option value="supplier" {{ request('type') == 'supplier' ? 'selected' : '' }}>الموردين</option>
                    </select>
                </div>
                <div class="col-md-3 d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary me-2">
                        <i class="fas fa-filter me-2"></i>تصفية
                    </button>
                    <a href="{{ route('customers-suppliers.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-times me-2"></i>إعادة تعيين
                    </a>
                </div>
            </form>
            
        </div>
    </div>

    <!-- Results Counter -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <span class="text-muted">
            عرض <span id="resultCount">0</span> من أصل <span id="totalCount">0</span> نتيجة
        </span>
        <div class="btn-group" role="group">
            <input type="radio" class="btn-check" name="viewType" id="cardViewBtn" checked>
            <label class="btn btn-outline-primary" for="cardViewBtn">
                <i class="fas fa-th-large"></i>
            </label>
            <input type="radio" class="btn-check" name="viewType" id="tableViewBtn">
            <label class="btn btn-outline-primary" for="tableViewBtn">
                <i class="fas fa-list"></i>
            </label>
        </div>
    </div>

    <div id="customersGrid" class="row g-4">
        @foreach($customersSuppliers as $cs)
        <div class="col-xl-4 col-lg-6 col-md-6">
            <div class="card customer-card h-100">
                <div class="card-body">
                    <div class="d-flex align-items-start justify-content-between mb-3">
                        <div class="d-flex align-items-center">
                            <div class="customer-avatar {{ $cs->type === 'customer' ? 'bg-primary' : 'bg-success' }} me-3">
                                <i class="fas fa-{{ $cs->type === 'customer' ? 'user' : 'building' }}"></i>
                            </div>
                            <div>
                                <h6 class="mb-1 fw-bold">{{ $cs->name }}</h6>
                                <span class="badge {{ $cs->type === 'customer' ? 'bg-primary' : 'bg-success' }}">{{ $cs->type === 'customer' ? 'عميل' : 'مورد' }}</span>
                            </div>
                        </div>
                        <div class="action-buttons">
                            <a href="{{ route('customers-suppliers.edit', $cs->id) }}" class="btn btn-outline-primary btn-sm" title="تعديل">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('customers-suppliers.destroy', $cs->id) }}" method="POST" onsubmit="return confirm('هل أنت متأكد من الحذف؟')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger btn-sm" title="حذف">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>

                    <div class="mb-2">
                        <small class="text-muted">
                            <i class="fas fa-user me-1"></i>{{ $cs->name ?: '-' }}
                        </small>
                    </div>
                    <div class="mb-2">
                        <small class="text-muted">
                            <i class="fas fa-phone me-1"></i>{{ $cs->phone ?: '-' }}
                        </small>
                    </div>
                    <div class="mb-3">
                        <small class="text-muted">
                            <i class="fas fa-envelope me-1"></i>{{ $cs->email ?: '-' }}
                        </small>
                    </div>
                    <div class="border-top pt-3 mt-auto">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="fw-bold">الرصيد الحالي:</span>
                            <span class="fw-bold {{ $cs->balance() > 0 ? 'text-danger' : ($cs->balance() < 0 ? 'text-success' : 'text-gray-500') }}">{{ number_format($cs->balance(), 2) }} ر.س</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <div id="customersTable" class="card" style="display: none;">
        {{-- <div class="card-header">
            <h5 class="card-title mb-0">
                <i class="fas fa-list me-2"></i>
                قائمة العملاء والموردين
            </h5>
        </div> --}}
        <div class="card-body">
            @if ($customersSuppliers->isEmpty())
                <p class="text-muted text-center py-4">لا توجد بيانات متاحة حالياً.</p>
            @else
                <div class="table-responsive">
                    <table class="table table-hover ">
                        <thead>
                            <tr>
                                <th>الاسم</th>
                                <th>النوع</th>
                                <th>رقم الهاتف</th>
                                <th>البريد الإلكتروني</th>
                                <th>الرصيد</th>
                                <th>الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($customersSuppliers as $cs)
                            <tr>
                                <td>{{ $cs->name }}</td>
                                <td>
                                    @if($cs->type === 'customer')
                                        <span class="badge bg-primary">عميل</span>
                                    @else
                                        <span class="badge bg-success">مورد</span>
                                    @endif
                                </td>
                                <td>{{ $cs->phone ?: '-' }}</td>
                                <td>{{ $cs->email ?: '-' }}</td>
                                <td>
                                    <span class="fw-bold {{ $cs->balance() > 0 ? 'text-danger' : ($cs->balance() < 0 ? 'text-success' : 'text-gray-500') }}">{{ number_format($cs->balance(), 2) }} ر.س</span>
                                </td>
                                <td>
                                    <div class="d-flex">
                                        <a href="{{ route('customers-suppliers.show', $cs) }}" class="btn btn-outline-primary btn-sm me-1 " title="عرض التفاصيل">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('customers-suppliers.edit', $cs) }}" class="btn btn-outline-warning btn-sm me-1" title="تعديل">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('customers-suppliers.destroy', $cs->id) }}" method="POST" onsubmit="return confirm('هل أنت متأكد من الحذف؟')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger btn-sm me-1 " title="حذف">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
    <div class="mt-4 d-flex justify-content-between align-items-center flex-wrap">
        <div class="pagination-info mb-2 mb-md-0">
            عرض {{ $customersSuppliers->firstItem() ?? 0 }} إلى {{ $customersSuppliers->lastItem() ?? 0 }} من {{ $customersSuppliers->total() }} عميل/مورد
        </div>
        <nav>
            {{ $customersSuppliers->appends(request()->except('page'))->links('pagination::bootstrap-5') }}
        </nav>
    </div>

</div>

@endsection

@section('scripts')
<script>
    // عند تحميل الصفحة
    document.addEventListener('DOMContentLoaded', function () {
        const cardViewBtn = document.getElementById('cardViewBtn');
        const tableViewBtn = document.getElementById('tableViewBtn');
        const customersGrids = document.getElementById('customersGrid');
        const customersTable = document.getElementById('customersTable');

        // استعادة آخر وضع عرض تم اختياره من localStorage
        // const lastView = localStorage.getItem('customersView') || 'cards';
        // if (lastView === 'table') {
        //     customersGrids.style.display = 'none';
        //     customersTable.style.display = 'block';
        //     cardViewBtn.classList.remove('active');
        //     tableViewBtn.classList.add('active');
        // } else {
        //     customersGrids.style.display = 'flex';
        //     customersTable.style.display = 'none';
        //     cardViewBtn.classList.add('active');
        //     tableViewBtn.classList.remove('active');
        // }

        // عند الضغط على زر عرض البطاقات
        cardViewBtn.addEventListener('click', function () {
            customersGrids.style.display = 'flex';
            customersTable.style.display = 'none';
            cardViewBtn.classList.add('active');
            tableViewBtn.classList.remove('active');
            // حفظ الوضع الجديد في localStorage
            // localStorage.setItem('customersView', 'cards');
        });

        // عند الضغط على زر عرض الجدول
        tableViewBtn.addEventListener('click', function () {
            customersGrids.style.display = 'none';
            customersTable.style.display = 'block';
            cardViewBtn.classList.remove('active');
            tableViewBtn.classList.add('active');
            // حفظ الوضع الجديد في localStorage
            // localStorage.setItem('customersView', 'table');
        });
    });
</script>
@endsection