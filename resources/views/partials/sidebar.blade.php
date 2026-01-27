{{-- الشريط الجانبي --}}
<nav class="sidebar" id="sidebar">
    <div class="sidebar-brand">
        <h4>
            <i class="fas fa-book-open me-2"></i>
            الدفتر الرقمي
        </h4>
    </div>
    
    <ul class="nav flex-column mt-3">
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" 
               href="{{ route('dashboard') }}">
                <i class="fas fa-tachometer-alt"></i>
                لوحة التحكم
            </a>
        </li>
        
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('shop.edit') ? 'active' : '' }}" 
               href="{{ route('shop.edit') }}">
                <i class="fas fa-store"></i>
                إدارة المحل
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('customers-suppliers.*') ? 'active' : '' }}" 
               href="{{ route('customers-suppliers.index') }}">
                <i class="fas fa-users"></i>
                العملاء والموردين
            </a>
        </li>
        
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('transactions.*') ? 'active' : '' }}" 
               href="{{ route('transactions.index') }}">
                <i class="fas fa-receipt"></i>
                المعاملات
            </a>
        </li>
        
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('reports.*') ? 'active' : '' }}" 
               href="{{-- route('reports.index') --}}">
                <i class="fas fa-chart-bar"></i>
                التقارير
            </a>
        </li>
     
        {{-- يمكن إضافة المزيد من الروابط هنا --}}
        <li class="nav-item mt-3">
            <hr class="text-white-50">
        </li>
        
        <li class="nav-item">
            <a class="nav-link" href="#" onclick="showToast('قريباً...', 'info')">
                <i class="fas fa-cog"></i>
                الإعدادات
            </a>
        </li>
        
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('profile.*') ? 'active' : '' }}" 
            href="{{ route('profile.edit') }}">
                <i class="fas fa-user"></i>
                الملف الشخصي
            </a>
        </li>
        
        <li class="nav-item">
            <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                @csrf
                <a class="nav-link" href="#" onclick="event.preventDefault(); this.closest('form').submit();">
                    <i class="fas fa-sign-out-alt"></i>
                    تسجيل الخروج
                </a>
            </form>
        </li>
    </ul>
</nav>