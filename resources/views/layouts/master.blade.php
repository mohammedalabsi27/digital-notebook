<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    @include('partials.head')
</head>
<body>
    {{-- زر الهواتف المحمولة والطبقة المغطية --}}
    @include('partials.mobile-toggle')

    {{-- الشريط الجانبي --}}
    @include('partials.sidebar')

    {{-- المحتوى الرئيسي --}}
    <main class="main-content">
        @yield('content')
    </main>
    @if(session('success'))
    <div class="toast-container position-fixed top-0 end-0 p-3">
        <div class="toast align-items-center text-bg-success border-0 show" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="4000">
            <div class="d-flex">
                <div class="toast-body">
                    {{ session('success') }}
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    </div>
    @endif

    {{-- السكريبتات --}}
    @include('partials.scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var toastElList = [].slice.call(document.querySelectorAll('.toast'));
            var toastList = toastElList.map(function(toastEl) {
                return new bootstrap.Toast(toastEl)
            });
            toastList.forEach(toast => toast.show());
        });
    </script>

</body>
</html>