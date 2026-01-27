{{-- السكريبتات المشتركة --}}

{{-- Bootstrap JS --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

{{-- Chart.js للرسوم البيانية --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

{{-- ملف JavaScript المخصص --}}
<script src="{{ asset('assets/js/app.js') }}"></script>

{{-- سكريبتات إضافية خاصة بالصفحة --}}
@yield('scripts')