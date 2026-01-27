@extends('layouts.master')

@section('title', 'لوحة التحكم - الدفتر الرقمي')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-dark fw-bold">لوحة التحكم</h1>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addTransactionModal">
            <i class="fas fa-plus me-2"></i>إضافة معاملة جديدة
        </button>
    </div>

    <!-- Statistics Cards -->
    <div class="row g-4 mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="card stats-card h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <p class="stats-label">إجمالي العملاء</p>
                            <h3 class="stats-number text-primary" id="totalCustomers">15</h3>
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
                            <h3 class="stats-number text-success" id="totalSuppliers">8</h3>
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
                            <h3 class="stats-number text-danger" id="totalDebts">25,000 ر.س</h3>
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
                            <h3 class="stats-number text-success" id="totalCredits">18,000 ر.س</h3>
                        </div>
                        <div class="text-success">
                            <i class="fas fa-arrow-down fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Recent Transactions -->
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
                                    <th>الحالة</th>
                                </tr>
                            </thead>
                            <tbody id="recentTransactions">
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                                <i class="fas fa-user"></i>
                                            </div>
                                            <div>
                                                <h6 class="mb-0">أحمد محمد</h6>
                                                <small class="text-muted">عميل</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td><span class="badge bg-danger">مدين</span></td>
                                    <td class="fw-bold text-danger">1,500 ر.س</td>
                                    <td>2025-01-28</td>
                                    <td><span class="badge bg-warning">معلق</span></td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                                <i class="fas fa-building"></i>
                                            </div>
                                            <div>
                                                <h6 class="mb-0">شركة النور</h6>
                                                <small class="text-muted">مورد</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td><span class="badge bg-success">دائن</span></td>
                                    <td class="fw-bold text-success">800 ر.س</td>
                                    <td>2025-01-27</td>
                                    <td><span class="badge bg-success">مكتمل</span></td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="bg-info text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                                <i class="fas fa-building"></i>
                                            </div>
                                            <div>
                                                <h6 class="mb-0">مؤسسة الخليج</h6>
                                                <small class="text-muted">مورد</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td><span class="badge bg-danger">مدين</span></td>
                                    <td class="fw-bold text-danger">2,200 ر.س</td>
                                    <td>2025-01-26</td>
                                    <td><span class="badge bg-warning">معلق</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Stats -->
        <div class="col-xl-4">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">إحصائيات سريعة</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span>معاملات اليوم</span>
                        <span class="badge bg-primary">12</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span>معاملات الأسبوع</span>
                        <span class="badge bg-success">48</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span>معاملات الشهر</span>
                        <span class="badge bg-info">156</span>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="fw-bold">صافي الربح</span>
                        <span class="badge bg-success fs-6">7,000 ر.س</span>
                    </div>
                </div>
            </div>

            <!-- Top Customers -->
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">أكبر العملاء</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <h6 class="mb-0">أحمد محمد</h6>
                            <small class="text-muted">15 معاملة</small>
                        </div>
                        <span class="text-danger fw-bold">5,000 ر.س</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <h6 class="mb-0">شركة النور</h6>
                            <small class="text-muted">8 معاملات</small>
                        </div>
                        <span class="text-success fw-bold">3,500 ر.س</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-0">مؤسسة الخليج</h6>
                            <small class="text-muted">12 معاملة</small>
                        </div>
                        <span class="text-danger fw-bold">2,800 ر.س</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Transaction Modal -->
<div class="modal fade" id="addTransactionModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">إضافة معاملة جديدة</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="addTransactionForm">
                    <div class="mb-3">
                        <label class="form-label">العميل/المورد</label>
                        <select class="form-select" required>
                            <option value="">اختر العميل أو المورد</option>
                            <option value="1">أحمد محمد</option>
                            <option value="2">شركة النور</option>
                            <option value="3">مؤسسة الخليج</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">نوع المعاملة</label>
                        <select class="form-select" required>
                            <option value="">اختر نوع المعاملة</option>
                            <option value="debit">مدين</option>
                            <option value="credit">دائن</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">المبلغ</label>
                        <input type="number" class="form-control" placeholder="أدخل المبلغ" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">الوصف</label>
                        <textarea class="form-control" rows="3" placeholder="وصف المعاملة (اختياري)"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                <button type="button" class="btn btn-primary">
                    <i class="fas fa-save me-2"></i>حفظ المعاملة
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Load dashboard data
    document.addEventListener('DOMContentLoaded', function() {
        loadDashboardStats();
        loadRecentTransactions();
    });

    function loadDashboardStats() {
        // Simulate API call
        setTimeout(() => {
            // Update stats with animation
            animateNumber('totalCustomers', 15);
            animateNumber('totalSuppliers', 8);
        }, 500);
    }

    function loadRecentTransactions() {
        // Simulate loading recent transactions
        console.log('Loading recent transactions...');
    }

    function animateNumber(elementId, targetNumber) {
        const element = document.getElementById(elementId);
        const startNumber = 0;
        const duration = 1000;
        const increment = targetNumber / (duration / 16);
        let currentNumber = startNumber;

        const timer = setInterval(() => {
            currentNumber += increment;
            if (currentNumber >= targetNumber) {
                currentNumber = targetNumber;
                clearInterval(timer);
            }
            element.textContent = Math.floor(currentNumber);
        }, 16);
    }

    // Add transaction form submission
    document.getElementById('addTransactionForm').addEventListener('submit', function(e) {
        e.preventDefault();
        // Handle form submission
        console.log('Adding new transaction...');
        
        // Close modal
        const modal = bootstrap.Modal.getInstance(document.getElementById('addTransactionModal'));
        modal.hide();
        
        // Show success message
        showToast('تم إضافة المعاملة بنجاح', 'success');
    });

    function showToast(message, type = 'info') {
        // Create toast element
        const toast = document.createElement('div');
        toast.className = `alert alert-${type} alert-dismissible fade show position-fixed`;
        toast.style.cssText = 'top: 20px; left: 20px; z-index: 9999; min-width: 300px;';
        toast.innerHTML = `
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;
        
        document.body.appendChild(toast);
        
        // Auto remove after 3 seconds
        setTimeout(() => {
            if (toast.parentNode) {
                toast.parentNode.removeChild(toast);
            }
        }, 3000);
    }
</script>
@endsection

