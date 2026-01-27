{{-- قسم head المشترك --}}
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta name="description" content="نظام إدارة الحسابات والمعاملات المالية للمحلات التجارية">
<meta name="keywords" content="دفتر رقمي, محاسبة, إدارة العملاء, المعاملات المالية">
<meta name="author" content="الدفتر الرقمي">

<title>@yield('title', 'الدفتر الرقمي')</title>

{{-- الأيقونة المفضلة --}}
<link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">

{{-- Bootstrap RTL CSS --}}
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css" rel="stylesheet">

{{-- Font Awesome --}}
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

{{-- Google Fonts - Cairo --}}
<link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;500;600;700&display=swap" rel="stylesheet">

{{-- ملف CSS المخصص --}}
<link href="{{ asset('assets/css/app.css') }}" rel="stylesheet">

{{-- أنماط إضافية خاصة بالصفحة --}}
@yield('styles')