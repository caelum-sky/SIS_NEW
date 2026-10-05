<meta name="description" content="@yield('meta_description', config('app.school_name') . ' Student Information System — secure access to student records, enrollments, grades, requirements, and billing.')">
<meta name="keywords" content="student information system, SIS, school portal, enrollment, grades, academic records">
<meta name="robots" content="index, follow">
<link rel="canonical" href="{{ url()->current() }}">
<meta property="og:type" content="website">
<meta property="og:site_name" content="{{ config('app.name') }}">
<meta property="og:title" content="@yield('title', config('app.name'))">
<meta property="og:description" content="@yield('meta_description', config('app.school_name') . ' Student Information System')">
<meta property="og:url" content="{{ url()->current() }}">
<meta property="og:image" content="{{ asset('img/og-cover.png') }}">
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="@yield('title', config('app.name'))">
