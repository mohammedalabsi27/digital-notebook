<div class="sidebar-wrapper">
    <div class="sidebar">
        <div class="sidebar-header">
            <a href="{{ route('dashboard') }}" class="logo-link">
                <span class="logo-icon">&#x1F4D2;</span>
                <span class="logo-text">{{ config('app.name', 'دفتر المحل') }}</span>
            </a>
            <button class="sidebar-toggle-btn">
                <span>&#x2715;</span> {{-- أيقونة X --}}
            </button>
        </div>

        <nav class="sidebar-nav">
            <ul class="nav-list">
                <li class="nav-item">
                    <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <i class="fas fa-tachometer-alt nav-icon"></i>
                        <span>لوحة التحكم</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('customers.index') }}" class="nav-link {{ request()->routeIs('customers.*') ? 'active' : '' }}">
                        <i class="fas fa-users nav-icon"></i>
                        <span>العملاء</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('shop.index') }}" class="nav-link {{ request()->routeIs('shop.index') ? 'active' : '' }}">
                        <i class="fas fa-store nav-icon"></i>
                        <span>المحل الخاص بي</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('profile.edit') }}" class="nav-link {{ request()->routeIs('profile.*') ? 'active' : '' }}">
                        <i class="fas fa-user-circle nav-icon"></i>
                        <span>الملف الشخصي</span>
                    </a>
                </li>
            </ul>
        </nav>

        <div class="sidebar-footer">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="logout-btn">
                    <i class="fas fa-sign-out-alt nav-icon"></i>
                    <span>تسجيل الخروج</span>
                </button>
            </form>
        </div>
    </div>
</div>