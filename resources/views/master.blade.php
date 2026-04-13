<!DOCTYPE html>
<html lang="en">
<meta http-equiv="content-type" content="text/html;charset=UTF-8" />

<head>
    <title>UKK 2026 P1-Rizqia</title>
    <meta charset="utf-8" />
    <meta name="description"
        content="Bold admin dashboard live demo. Check out all the features of the admin panel. A large number of settings, additional services and widgets." />
    <meta name="keywords"
        content="Bold, bootstrap, bootstrap 5, admin themes, dark mode, free admin themes, bootstrap admin, bootstrap dashboard" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta property="og:locale" content="en_US" />
    <meta property="og:type" content="article" />
    <meta property="og:title" content="Bold | Bootstrap 5 HTML Admin Dashboard Theme by KeenThemes" />
    <meta property="og:url" content="https://keenthemes.com/products/bold-html-pro" />
    <meta property="og:site_name" content="Bold HTML Pro by Keenthemes" />
    <link rel="canonical" href="http://preview.keenthemes.com/#" />
    <link rel="shortcut icon" href="{{ asset('assets/media/logos/favicon.ico') }}" />
    <!--begin::Fonts(mandatory for all pages)-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <!--begin::Vendor Stylesheets(used for this page only)-->
    <link href="{{ asset('assets/plugins/custom/fullcalendar/fullcalendar.bundle.css') }}" rel="stylesheet"
        type="text/css" />
    <!--end::Vendor Stylesheets-->
    <!--begin::Global Stylesheets Bundle(mandatory for all pages)-->
    <link href="{{ asset('assets/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/style.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/custom.css') }}" rel="stylesheet" type="text/css" />
    <!--end::Global Stylesheets Bundle-->
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-52YZ3XGZJ6"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'G-52YZ3XGZJ6');
    </script>
    <script>
        // Frame-busting to prevent site from being loaded within a frame without permission (click-jacking)
        if (window.top != window.self) {
            window.top.location.replace(window.self.location.href);
        }
    </script>
</head>
<!--end::Head-->

<!--begin::Body-->

<body id="kt_app_body" data-kt-app-header-fixed="true" data-kt-app-header-fixed-mobile="true"
    data-kt-app-sidebar-enabled="true" data-kt-app-sidebar-fixed="true" data-kt-app-sidebar-hoverable="true"
    data-kt-app-sidebar-push-header="true" data-kt-app-sidebar-push-toolbar="true"
    data-kt-app-sidebar-push-footer="true" data-kt-app-toolbar-enabled="true" class="app-default">
    <!--begin::Theme mode setup on page load-->
    <script>
        var defaultThemeMode = "dark";
        document.documentElement.setAttribute("data-bs-theme", "dark");
    </script>
    <!--end::Theme mode setup on page load-->


    <!--begin::App-->
    <div class="d-flex flex-column flex-root app-root" id="kt_app_root">
        <!--begin::Page-->
        <div class="app-page  flex-column flex-column-fluid " id="kt_app_page">

            <!--begin::Header-->
            <div id="kt_app_header" class="app-header " data-kt-sticky="true"
                data-kt-sticky-activate="{default: true, lg: true}" data-kt-sticky-name="app-header-minimize"
                data-kt-sticky-offset="{default: '200px', lg: '300px'}" data-kt-sticky-animation="false">

                <!--begin::Header container-->
                <div class="app-container  container-fluid d-flex align-items-stretch flex-stack mt-7 "
                    id="kt_app_header_container">
                    <!--begin::Sidebar toggle-->
                    <div class="d-flex align-items-center d-block d-lg-none ms-n3" title="Show sidebar menu">
                        <div class="btn btn-icon btn-active-color-primary w-35px h-35px me-2"
                            id="kt_app_sidebar_mobile_toggle">
                            <i class="ki-duotone ki-abstract-14 fs-2"><span class="path1"></span><span
                                    class="path2"></span></i>
                        </div>

                        <!--begin::Logo image-->
                        <a href="index708f.html?page=index">
                            <img alt="Logo" src="{{ asset('assets/media/logos/default.svg') }}"
                                class="h-20px theme-light-show" />
                            <img alt="Logo" src="{{ asset('assets/media/logos/default-dark.svg') }}"
                                class="h-20px theme-dark-show" />
                        </a>
                        <!--end::Logo image-->
                    </div>
                    <!--end::Sidebar toggle-->


                    <!--begin::Navbar-->
                    <div class="app-navbar flex-lg-grow-1" id="kt_app_header_navbar">
                        <div class="app-navbar-item d-flex align-items-stretch flex-lg-grow-1">

                            <!--begin::Search-->
                            <div id="kt_header_search" class="header-search d-flex align-items-center w-lg-350px"
                                data-kt-search-keypress="true" data-kt-search-min-length="2"
                                data-kt-search-enter="enter" data-kt-search-layout="menu"
                                data-kt-search-responsive="true" data-kt-menu-trigger="auto"
                                data-kt-menu-permanent="true" data-kt-menu-placement="bottom-start">

                                <!--begin::Tablet and mobile search toggle-->
                                <div data-kt-search-element="toggle"
                                    class="search-toggle-mobile d-flex d-lg-none align-items-center">
                                    <div class="d-flex ">
                                        <i class="ki-duotone ki-magnifier fs-1 "><span class="path1"></span><span
                                                class="path2"></span></i>
                                    </div>
                                </div>
                                <!--end::Tablet and mobile search toggle-->

                                <!--begin::Form(use d-none d-lg-block classes for responsive search)-->
                                <form data-kt-search-element="form"
                                    class="d-none d-lg-block w-100 position-relative mb-5 mb-lg-0" autocomplete="off">
                                    <!--begin::Hidden input(Added to disable form autocomplete)-->
                                    <input type="hidden" />
                                    <!--end::Hidden input-->

                                    <!--begin::Icon-->
                                    <i
                                        class="ki-duotone ki-magnifier search-icon fs-2 text-gray-500 position-absolute top-50 translate-middle-y ms-5"><span
                                            class="path1"></span><span class="path2"></span></i> <!--end::Icon-->

                                    <!--begin::Input-->
                                    <input type="text"
                                        class="search-input form-control form-control rounded-1  ps-13" name="search"
                                        value="" placeholder="Search..." data-kt-search-element="input" />
                                    <!--end::Input-->

                                    <!--begin::Spinner-->
                                    <span
                                        class="search-spinner  position-absolute top-50 end-0 translate-middle-y lh-0 d-none me-5"
                                        data-kt-search-element="spinner">
                                        <span class="spinner-border h-15px w-15px align-middle text-gray-500"></span>
                                    </span>
                                    <!--end::Spinner-->

                                    <!--begin::Reset-->
                                    <span
                                        class="search-reset  btn btn-flush btn-active-color-primary position-absolute top-50 end-0 translate-middle-y lh-0 d-none me-4"
                                        data-kt-search-element="clear">
                                        <i class="ki-duotone ki-cross fs-2 fs-lg-1 me-0"><span
                                                class="path1"></span><span class="path2"></span></i> </span>
                                    <!--end::Reset-->
                                </form>
                                <!--end::Form-->

                            </div>
                            <!--end::Search-->
                        </div>

                        <!--begin::User menu-->
                        <div class="app-navbar-item ms-5" id="kt_header_user_menu_toggle">
                            <!--begin::Menu wrapper-->
                            @php
                                $name = optional(Auth::user()->detail)->name ?? 'U';
                            @endphp

                            <div class="cursor-pointer symbol symbol-30px symbol-md-35px"
                                data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-attach="parent"
                                data-kt-menu-placement="bottom-end">

                                <div class="symbol-label bg-light-primary text-primary fw-bold"
                                    style="font-size: 12px;">
                                    {{ strtoupper(substr($name, 0, 1)) }}
                                </div>
                            </div>

                            <!--begin::User account menu-->
                            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg menu-state-color fw-semibold py-4 fs-6 w-275px"
                                data-kt-menu="true">
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <div class="menu-content d-flex align-items-center px-3">
                                        <!--begin::Avatar-->
                                        @php
                                            $name = Auth::user()->detail->name ?? (Auth::user()->email ?? 'U');
                                            $initial = strtoupper(substr($name, 0, 1));
                                        @endphp

                                        <div class="symbol symbol-50px me-5">
                                            <div class="symbol-label bg-light-primary text-primary fw-bold">
                                                {{ $initial }}
                                            </div>
                                        </div>
                                        <!--end::Avatar-->

                                        <!--begin::Username-->
                                        <div class="d-flex flex-column">
                                            <div class="fw-bold d-flex align-items-center fs-5">
                                                {{ Auth::user()->detail->name }}<span
                                                    class="badge badge-light-success fw-bold fs-8 px-2 py-1 ms-2">Pro</span>
                                            </div>

                                            <a href="#" class="fw-semibold text-muted text-hover-primary fs-7">
                                                {{ Auth::user()->email }} </a>
                                        </div>
                                        <!--end::Username-->
                                    </div>
                                </div>
                                <!--end::Menu item-->

                                <!--begin::Menu separator-->
                                <div class="separator my-2"></div>
                                <!--end::Menu separator-->

                                <!--begin::Menu item-->
                                <div class="menu-item px-5" data-kt-menu-trigger="{default: 'click', lg: 'hover'}"
                                    data-kt-menu-placement="left-start" data-kt-menu-offset="-15px, 0">
                                    <a href="#" class="menu-link px-5">
                                        <span class="menu-title position-relative">
                                            Mode

                                            <span class="ms-5 position-absolute translate-middle-y top-50 end-0">
                                                <i class="ki-duotone ki-night-day theme-light-show fs-2"><span
                                                        class="path1"></span><span class="path2"></span><span
                                                        class="path3"></span><span class="path4"></span><span
                                                        class="path5"></span><span class="path6"></span><span
                                                        class="path7"></span><span class="path8"></span><span
                                                        class="path9"></span><span class="path10"></span></i> <i
                                                    class="ki-duotone ki-moon theme-dark-show fs-2"><span
                                                        class="path1"></span><span class="path2"></span></i>
                                            </span>
                                        </span>
                                    </a>

                                    <!--begin::Menu-->
                                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-title-gray-700 menu-icon-gray-500 menu-active-bg menu-state-color fw-semibold py-4 fs-base w-150px"
                                        data-kt-menu="true" data-kt-element="theme-mode-menu">

                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3 my-0">
                                            <a href="#" class="menu-link px-3 py-2" data-kt-element="mode"
                                                data-kt-value="dark">
                                                <span class="menu-icon" data-kt-element="icon">
                                                    <i class="ki-duotone ki-moon fs-2"><span
                                                            class="path1"></span><span class="path2"></span></i>
                                                </span>
                                                <span class="menu-title">
                                                    Dark
                                                </span>
                                            </a>
                                        </div>
                                        <!--end::Menu item-->
                                    </div>
                                    <!--end::Menu-->

                                </div>
                                <!--end::Menu item-->

                                <!--begin::Menu item-->
                                <div class="menu-item px-5">
                                    <a href="#" class="menu-link px-5"
                                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        Sign Out
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                        style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                                <!--end::Menu item-->
                            </div>
                            <!--end::User account menu-->

                            <!--end::Menu wrapper-->
                        </div>
                        <!--end::User menu-->

                        <!--begin::Header menu toggle-->
                        <!--end::Header menu toggle-->
                    </div>
                    <!--end::Navbar-->
                </div>
                <!--end::Header container-->
            </div>
            <!--end::Header-->
            <!--begin::Wrapper-->
            <div class="app-wrapper  flex-column flex-row-fluid " id="kt_app_wrapper">

                <!--begin::Sidebar-->
                <div id="kt_app_sidebar" class="app-sidebar  flex-column " data-kt-drawer="true"
                    data-kt-drawer-name="app-sidebar" data-kt-drawer-activate="{default: true, lg: false}"
                    data-kt-drawer-overlay="true" data-kt-drawer-width="250px" data-kt-drawer-direction="start"
                    data-kt-drawer-toggle="#kt_app_sidebar_mobile_toggle">


                    <div class="app-sidebar-header d-flex flex-stack d-none d-lg-flex pt-8 pb-2 px-8"
                        id="kt_app_sidebar_header">
                        <!--begin::Logo-->
                        <a href="index708f.html?page=index" class="app-sidebar-logo">
                            <img alt="Logo" src="{{ asset('assets/media/logos/default.svg') }}"
                                class="h-20px d-none d-sm-inline app-sidebar-logo-default theme-light-show" />
                            <img alt="Logo" src="{{ asset('assets/media/logos/default-dark.svg') }}"
                                class="h-20px theme-dark-show" />
                        </a>
                        <!--end::Logo-->

                        <!--begin::Sidebar toggle-->
                        <div id="kt_app_sidebar_toggle"
                            class="app-sidebar-toggle btn btn-sm btn-icon btn-color-gray-600 btn-active-color-primary d-none d-lg-flex rotate "
                            data-kt-toggle="true" data-kt-toggle-state="active" data-kt-toggle-target="body"
                            data-kt-toggle-name="app-sidebar-minimize">

                            <i class="ki-duotone ki-exit-left fs-1 rotate-180 me-n4"><span class="path1"></span><span
                                    class="path2"></span></i>
                        </div>
                        <!--end::Sidebar toggle-->
                    </div>

                    <!--begin::Navs-->
                    <div class="app-sidebar-navs flex-column-fluid py-4" id="kt_app_sidebar_navs">
                        <div id="kt_app_sidebar_navs_wrappers" class="app-sidebar-wrapper">
                            <div id="kt_app_sidebar_navs_scroll" class="hover-scroll-y mx-2 my-2"
                                data-kt-scroll="true" data-kt-scroll-activate="true" data-kt-scroll-height="auto"
                                data-kt-scroll-dependencies="#kt_app_sidebar_header"
                                data-kt-scroll-wrappers="#kt_app_sidebar_navs" data-kt-scroll-offset="5px">

                                {{-- Profile Section in Navbar --}}
                                <div class="d-flex align-items-center gap-3 px-3 py-2">
                                    {{-- Avatar with Status --}}
                                    <div class="position-relative flex-shrink-0">
                                        @php
                                            $name = Auth::user()->detail->name ?? (Auth::user()->email ?? 'U');
                                            $initial = strtoupper(substr($name, 0, 1));
                                        @endphp

                                        <div class="symbol symbol-40px symbol-circle">
                                            <div class="symbol-label fs-6 fw-bold"
                                                style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                                                {{ $initial }}
                                            </div>
                                        </div>
                                        {{-- Online Status Indicator --}}
                                        <span class="position-absolute bottom-0 end-0"
                                            style="width: 10px; height: 10px; background: #10b981; border-radius: 50%; border: 2px solid white;">
                                        </span>
                                    </div>

                                    {{-- User Info --}}
                                    <div class="flex-grow-1 min-w-0">
                                        <div class="fw-semibold text-gray-900 fs-7 text-truncate">
                                            {{ Auth::user()->detail->name }}
                                        </div>
                                        <div class="text-muted fs-8 text-truncate">
                                            {{ Auth::user()->email }}
                                        </div>
                                    </div>

                                    {{-- Role Badge --}}
                                    <div class="flex-shrink-0">
                                        <span class="badge badge-light-primary fs-9 px-2 py-1">
                                            {{ Auth::user()->role }}
                                        </span>
                                    </div>
                                </div>

                                {{-- Divider (optional) --}}
                                <div class="separator mx-3 mb-3"></div>

                                {{-- Sidebar Menu --}}
                                <div id="kt_app_sidebar_menu" data-kt-menu="true" data-kt-menu-expand="false"
                                    class="app-sidebar-menu-primary menu menu-column menu-rounded menu-sub-indention menu-state-bullet-primary px-3">

                                    {{-- ================= MENU UTAMA ================= --}}
                                    <div class="menu-item mb-1">
                                        <div class="menu-heading text-uppercase fs-8 fw-bolder text-muted">
                                            Menu Utama
                                        </div>
                                    </div>

                                    {{-- ================= DASHBOARD ================= --}}
                                    <div class="menu-item">
                                        <a class="menu-link" href="/admin">
                                            <span class="menu-icon"><i
                                                    class="ki-duotone ki-element-11 fs-2"></i></span>
                                            <span class="menu-title">Dashboard</span>
                                        </a>
                                    </div>

                                    {{-- ================= ADMIN ================= --}}
                                    @if (Auth::user()->role == 'admin')
                                        {{-- Users Management --}}
                                        <div class="menu-item">
                                            <a class="menu-link" href="{{ route('users.index') }}">
                                                <span class="menu-icon">
                                                    <i class="ki-duotone ki-people fs-2"></i>
                                                </span>
                                                <span class="menu-title">Users Management</span>
                                            </a>
                                        </div>

                                        {{-- Kategori --}}
                                        <div class="menu-item">
                                            <a class="menu-link" href="{{ route('categories.index') }}">
                                                <span class="menu-icon">
                                                    <i class="ki-duotone ki-element-11 fs-2"></i>
                                                </span>
                                                <span class="menu-title">Management Kategori</span>
                                            </a>
                                        </div>

                                        {{-- Management Alat --}}
                                        <div class="menu-item">
                                            <a class="menu-link" href="{{ route('tools.index') }}">
                                                <span class="menu-icon">
                                                    <i class="ki-duotone ki-wrench fs-2"></i>
                                                </span>
                                                <span class="menu-title">Management Alat</span>
                                            </a>
                                        </div>

                                        {{-- Data Peminjaman --}}
                                        <div class="menu-item">
                                            <a class="menu-link" href="#">
                                                <span class="menu-icon">
                                                    <i class="ki-duotone ki-book fs-2"></i>
                                                </span>
                                                <span class="menu-title">Data Peminjaman</span>
                                            </a>
                                        </div>

                                        {{-- Pengembalian --}}
                                        <div class="menu-item">
                                            <a class="menu-link" href="#">
                                                <span class="menu-icon">
                                                    <i class="ki-duotone ki-arrows-loop fs-2"></i>
                                                </span>
                                                <span class="menu-title">Pengembalian</span>
                                            </a>
                                        </div>

                                        {{-- Log Aktivitas --}}
                                        <div class="menu-item">
                                            <a class="menu-link" href="#">
                                                <span class="menu-icon">
                                                    <i class="ki-duotone ki-time fs-2"></i>
                                                </span>
                                                <span class="menu-title">Log Aktivitas</span>
                                            </a>
                                        </div>
                                    @endif

                                    {{-- ================= PETUGAS ================= --}}
                                    @if (Auth::user()->role == 'petugas')
                                        <div class="menu-item">
                                            <a class="menu-link" href="#">
                                                <span class="menu-title">Pengajuan Peminjaman</span>
                                            </a>
                                        </div>

                                        <div class="menu-item">
                                            <a class="menu-link" href="#">
                                                <span class="menu-title">Pengembalian</span>
                                            </a>
                                        </div>

                                        <div class="menu-item">
                                            <a class="menu-link" href="#">
                                                <span class="menu-title">Pelanggaran</span>
                                            </a>
                                        </div>

                                        <div class="menu-item">
                                            <a class="menu-link" href="#">
                                                <span class="menu-title">Laporan</span>
                                            </a>
                                        </div>
                                    @endif

                                    {{-- ================= PEMINJAM ================= --}}
                                    @if (Auth::user()->role == 'peminjam')
                                        <div class="menu-item">
                                            <a class="menu-link" href="#">
                                                <span class="menu-title">Daftar Alat</span>
                                            </a>
                                        </div>

                                        <div class="menu-item">
                                            <a class="menu-link" href="#">
                                                <span class="menu-title">Ajukan Peminjaman</span>
                                            </a>
                                        </div>

                                        <div class="menu-item">
                                            <a class="menu-link" href="#">
                                                <span class="menu-title">Pengembalian</span>
                                            </a>
                                        </div>

                                        <div class="menu-item">
                                            <a class="menu-link" href="#">
                                                <span class="menu-title">Riwayat Peminjaman</span>
                                            </a>
                                        </div>
                                    @endif
                                    <div class="separator mx-1 my-3"></div>

                                    {{-- Log Out --}}
                                    <div class="menu-item">
                                        <a class="menu-link text-danger" href="{{ route('logout') }}"
                                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                            <span class="menu-icon"><i
                                                    class="ki-duotone ki-exit-right fs-2 text-danger"><span
                                                        class="path1"></span><span class="path2"></span></i></span>
                                            <span class="menu-title text-danger">Log out</span>
                                        </a>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                            class="d-none">@csrf</form>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end::Navs-->


                </div>
                <!--end::Sidebar-->


                <!--begin::Main-->
                <div class="app-main flex-column flex-row-fluid " id="kt_app_main">
                    <!--begin::Content wrapper-->
                    <div class="d-flex flex-column flex-column-fluid">

                        <!--begin::Toolbar-->
                        <div id="kt_app_toolbar" class="app-toolbar  pt-7 pt-lg-10 ">

                            <!--begin::Toolbar container-->
                            <div id="kt_app_toolbar_container"
                                class="app-container  container-fluid d-flex align-items-stretch ">
                                <!--begin::Toolbar container-->
                                <div class="d-flex flex-stack flex-row-fluid">
                                    <!--begin::Toolbar container-->
                                    <div class="d-flex flex-column flex-row-fluid">
                                        <!--begin::Toolbar wrapper-->


                                        <!--begin::Page title-->
                                        <div class="page-title d-flex align-items-center gap-1 me-3">
                                            <!--begin::Title-->
                                            <span class="text-gray-900 fw-bolder fs-2x lh-1">
                                                Account
                                            </span>
                                            <!--end::Title-->


                                            <!--begin::Breadcrumb-->
                                            <ul
                                                class="breadcrumb breadcrumb-separatorless fw-semibold fs-base ms-3 d-flex mb-0">


                                                <!--begin::Item-->
                                                <li class="breadcrumb-item text-gray-700 fw-bold lh-1">
                                                    <a href="index708f.html?page=index"
                                                        class="text-gray-700 text-hover-primary">
                                                        <i class="ki-duotone ki-home fs-3 text-gray-500 ms-2"></i>
                                                    </a>
                                                </li>
                                                <!--end::Item-->

                                                <!--begin::Item-->
                                                <li class="breadcrumb-item mx-n1">
                                                    <i class="ki-duotone ki-right fs-4 text-gray-700"></i>
                                                </li>
                                                <!--end::Item-->



                                                <!--begin::Item-->
                                                <li class="breadcrumb-item text-gray-700 fw-bold lh-1">
                                                    Account </li>
                                                <!--end::Item-->

                                                <!--begin::Item-->
                                                <li class="breadcrumb-item mx-n1">
                                                    <i class="ki-duotone ki-right fs-4 text-gray-700"></i>
                                                </li>
                                                <!--end::Item-->



                                                <!--begin::Item-->
                                                <li class="breadcrumb-item text-gray-500">
                                                    Overview </li>
                                                <!--end::Item-->


                                            </ul>
                                            <!--end::Breadcrumb-->
                                        </div>
                                        <!--end::Page title-->
                                    </div>
                                    <!--end::Toolbar container-->

                                    <!--begin::Actions-->
                                    <div class="d-flex align-self-center flex-center flex-shrink-0">
                                        <a href="#"
                                            class="btn btn-sm btn-secondary d-flex flex-center ms-3 px-4 py-3"
                                            data-bs-toggle="modal" data-bs-target="#kt_modal_invite_friends">
                                            <i class="ki-duotone ki-plus-square fs-2 text-gray-500"><span
                                                    class="path1"></span><span class="path2"></span><span
                                                    class="path3"></span></i>
                                            <span>Invite</span>
                                        </a>

                                        <a href="#" class="btn btn-sm btn-primary ms-3 px-4 py-3"
                                            data-bs-toggle="modal" data-bs-target="#kt_modal_new_target">
                                            Create <span class="d-none d-sm-inline">App</span>
                                        </a>
                                    </div>
                                    <!--end::Actions-->
                                </div>
                                <!--end::Toolbar container-->
                            </div>
                            <!--end::Toolbar container-->
                        </div>
                        <!--end::Toolbar-->

                        <!--begin::Content-->
                        @yield('content')
                        <!--end::Content-->

                    </div>
                    <!--end::Content wrapper-->


                    <!--begin::Footer-->
                    <div id="kt_app_footer" class="app-footer ">

                        <!--begin::Footer container-->
                        <div
                            class="app-container  container-fluid d-flex flex-column flex-md-row flex-center flex-md-stack py-3 ">
                            <!--begin::Copyright-->
                            <div class="text-gray-900 order-2 order-md-1">
                                <span class="text-muted fw-semibold me-1">2026&copy;</span>
                                <a href="https://keenthemes.com/" target="_blank"
                                    class="text-gray-800 text-hover-primary">Keenthemes</a>
                            </div>
                            <!--end::Copyright-->

                            <!--begin::Menu-->
                            <ul class="menu menu-gray-600 menu-hover-primary fw-semibold order-1">
                                <li class="menu-item"><a href="https://keenthemes.com/" target="_blank"
                                        class="menu-link px-2">About</a></li>

                                <li class="menu-item"><a href="https://devs.keenthemes.com/" target="_blank"
                                        class="menu-link px-2">Support</a></li>

                                <li class="menu-item"><a href="https://keenthemes.com/products/bold-html-pro"
                                        target="_blank" class="menu-link px-2">Purchase</a></li>
                            </ul>
                            <!--end::Menu-->
                        </div>
                        <!--end::Footer container-->
                    </div>
                    <!--end::Footer-->
                </div>
                <!--end:::Main-->


            </div>
            <!--end::Wrapper-->


        </div>
        <!--end::Page-->

    </div>
    <!--end::App-->

    <!--begin::Javascript-->
    <script>
        var hostUrl = "assets/index.html";
    </script>

    <!--begin::Global Javascript Bundle(mandatory for all pages)-->
    <script src="{{ asset('assets/plugins/global/plugins.bundle.js') }}"></script>
    <script src="{{ asset('assets/js/scripts.bundle.js') }}"></script>
    <!--end::Global Javascript Bundle-->

    <!--begin::Vendors Javascript(used for this page only)-->
    <script src="{{ asset('assets/plugins/custom/fullcalendar/fullcalendar.bundle.js') }}"></script>
    <script src="https://cdn.amcharts.com/lib/5/index.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/xy.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/percent.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/radar.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/themes/Animated.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/map.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/geodata/worldLow.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/geodata/continentsLow.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/geodata/usaLow.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/geodata/worldTimeZonesLow.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/geodata/worldTimeZoneAreasLow.js"></script>
    <!--end::Vendors Javascript-->

    <!--begin::Custom Javascript(used for this page only)-->
    <script src="{{ asset('assets/js/widgets.bundle.js') }}"></script>
    <script src="{{ asset('assets/js/custom/widgets.js') }}"></script>
    <script src="{{ asset('assets/js/custom/apps/chat/chat.js') }}"></script>
    <script src="{{ asset('assets/js/custom/utilities/modals/upgrade-plan.js') }}"></script>
    <script src="{{ asset('assets/js/custom/utilities/modals/new-target.js') }}"></script>
    <script src="{{ asset('assets/js/custom/utilities/modals/offer-a-deal/type.js') }}"></script>
    <script src="{{ asset('assets/js/custom/utilities/modals/offer-a-deal/details.js') }}"></script>
    <script src="{{ asset('assets/js/custom/utilities/modals/offer-a-deal/finance.js') }}"></script>
    <script src="{{ asset('assets/js/custom/utilities/modals/offer-a-deal/complete.js') }}"></script>
    <script src="{{ asset('assets/js/custom/utilities/modals/offer-a-deal/main.js') }}"></script>
    <!--end::Custom Javascript-->
    <script>
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 5000,
            timerProgressBar: true,
            customClass: {
                popup: 'swal2-toast-modern'
            },
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        });

        @if (session('success'))
            Toast.fire({
                icon: 'success',
                title: '{{ session('success') }}',
            });
        @endif

        @if (session('error'))
            Toast.fire({
                icon: 'error',
                title: '{{ session('error') }}',
            });
        @endif

        @if ($errors->any())
            Swal.fire({
                icon: 'error',
                title: 'Validasi Gagal!',
                html: `<ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>`,
                confirmButtonText: 'Mengerti',
                customClass: {
                    popup: 'swal2-modern-popup'
                },
                showClass: {
                    popup: 'animate__animated animate__fadeInDown animate__faster'
                },
                hideClass: {
                    popup: 'animate__animated animate__fadeOutUp animate__faster'
                }
            });
        @endif
    </script>
    <script>
        document.getElementById('photo-input').addEventListener('change', function(e) {
            const file = e.target.files[0];
            const preview = document.getElementById('preview-image');

            if (file) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    preview.src = e.target.result;
                }

                reader.readAsDataURL(file);
            }
        });
    </script>
    {{-- ===== SCRIPT ===== --}}

    {{-- ===== SCRIPT ===== --}}
    <script>
        (function() {

            // Format angka ribuan dengan titik
            function formatRupiah(val) {
                return val.replace(/\D/g, '').replace(/\B(?=(\d{3})+(?!\d))/g, '.');
            }

            // Format price input (harga alat utama)
            const priceDisplay = document.getElementById('price_display');
            const priceRaw = document.getElementById('price_raw');

            priceDisplay?.addEventListener('input', function() {
                const raw = this.value.replace(/\D/g, '');
                this.value = raw ? formatRupiah(raw) : '';
                priceRaw.value = raw;
                document.getElementById('price_terbilang').textContent =
                    raw ? 'Rp ' + parseInt(raw).toLocaleString('id-ID') : '';
            });

            priceDisplay?.addEventListener('keypress', function(e) {
                if (!/[0-9]/.test(e.key)) e.preventDefault();
            });

            // Format price input bundle (event delegation)
            document.getElementById('bundle-items-wrapper')?.addEventListener('input', function(e) {
                if (!e.target.classList.contains('bundle-price-display')) return;
                const raw = e.target.value.replace(/\D/g, '');
                e.target.value = raw ? formatRupiah(raw) : '';
                const hiddenInput = e.target.closest('.bundle-item-row').querySelector('.bundle-price-raw');
                if (hiddenInput) hiddenInput.value = raw;
            });

            document.getElementById('bundle-items-wrapper')?.addEventListener('keypress', function(e) {
                if (!e.target.classList.contains('bundle-price-display')) return;
                if (!/[0-9]/.test(e.key)) e.preventDefault();
            });

            // Preview foto
            document.getElementById('photo-input')?.addEventListener('change', function() {
                const file = this.files[0];
                if (!file) return;
                const reader = new FileReader();
                reader.onload = e => document.getElementById('preview-image').src = e.target.result;
                reader.readAsDataURL(file);
            });

            // Toggle bundle fields + prefix kode BDL-
            function updateCodePrefix(type) {
                const label = document.getElementById('code_prefix_label');
                if (label) label.style.display = type === 'bundle' ? 'flex' : 'none';
                updateCodePreview(type, document.getElementById('code_prefix')?.value || '');
            }

            function updateCodePreview(type, val) {
                const preview = document.getElementById('code_preview');
                if (!preview) return;
                const upper = val.toUpperCase();
                preview.textContent = upper ?
                    'Kode: ' + (type === 'bundle' ? 'BDL-' + upper : upper) :
                    '';
            }

            document.getElementById('item_type')?.addEventListener('change', function() {
                const isBundle = this.value === 'bundle';
                document.getElementById('bundle-fields').style.display = isBundle ? 'block' : 'none';
                updateCodePrefix(this.value);
            });

            document.getElementById('code_prefix')?.addEventListener('input', function() {
                updateCodePreview(document.getElementById('item_type').value, this.value);
            });

            // Renumber baris bundle
            function renumberRows() {
                document.querySelectorAll('#bundle-items-wrapper .bundle-number').forEach((el, i) => {
                    el.textContent = (i + 1) + '.';
                });
            }

            // Tambah item bundle
            let bundleIndex = 1;

            document.getElementById('add-bundle-item')?.addEventListener('click', function() {
                const wrapper = document.getElementById('bundle-items-wrapper');
                const row = document.createElement('div');
                row.className = 'bundle-item-row d-flex gap-3 align-items-center';
                row.innerHTML = `
            <div class="d-flex align-items-center gap-3 flex-grow-1 bg-light rounded-2 px-4 py-2">
                <span class="text-muted fs-8 fw-bold bundle-number" style="min-width: 18px;">${bundleIndex + 1}.</span>
                <input type="text" name="bundle_items[${bundleIndex}][name]"
                    class="form-control form-control-flush form-control-sm bg-transparent border-0 p-0"
                    placeholder="Nama komponen, contoh: Charger">
                <div class="d-flex align-items-center gap-1 flex-shrink-0">
                    <input type="number" name="bundle_items[${bundleIndex}][qty]"
                        class="form-control form-control-flush form-control-sm bg-transparent border-0 p-0 text-center fw-semibold"
                        style="width: 45px;" placeholder="1" min="1" value="1">
                    <span class="text-muted fs-8">pcs</span>
                </div>
                <div class="border-start border-gray-300 mx-1" style="height: 20px;"></div>
                <div class="d-flex align-items-center gap-1 flex-shrink-0">
                    <span class="text-muted fs-8 fw-semibold">Rp</span>
                    <input type="text" name="bundle_items[${bundleIndex}][price_display]"
                        class="form-control form-control-flush form-control-sm bg-transparent border-0 p-0 text-end bundle-price-display"
                        style="width: 90px;" placeholder="0" autocomplete="off">
                    <input type="hidden" name="bundle_items[${bundleIndex}][price]" class="bundle-price-raw">
                </div>
            </div>
            <button type="button" class="btn btn-sm btn-icon btn-light-danger flex-shrink-0 remove-bundle-item">
                <i class="ki-duotone ki-trash fs-4">
                    <span class="path1"></span><span class="path2"></span>
                    <span class="path3"></span><span class="path4"></span>
                    <span class="path5"></span>
                </i>
            </button>`;
                wrapper.appendChild(row);
                bundleIndex++;
                renumberRows();
            });

            // Hapus item bundle
            document.getElementById('bundle-items-wrapper')?.addEventListener('click', function(e) {
                const btn = e.target.closest('.remove-bundle-item');
                if (!btn) return;
                if (this.querySelectorAll('.bundle-item-row').length > 1) {
                    btn.closest('.bundle-item-row').remove();
                    renumberRows();
                }
            });

        })();
    </script>
    <script>
        (function() {

            function updateCodePrefix(type) {
                const label = document.getElementById('code_prefix_label');
                label.style.display = type === 'bundle' ? 'flex' : 'none';
                updateCodePreview(type, document.getElementById('code_prefix').value);
            }

            function updateCodePreview(type, val) {
                const preview = document.getElementById('code_preview');
                const upper = val.toUpperCase();
                preview.textContent = upper ?
                    'Kode: ' + (type === 'bundle' ? 'BDL-' + upper : upper) :
                    '';
            }

            document.getElementById('item_type')?.addEventListener('change', function() {
                updateCodePrefix(this.value);
            });

            document.getElementById('code_prefix')?.addEventListener('input', function() {
                updateCodePreview(document.getElementById('item_type').value, this.value);
            });

        })();
    </script>

    {{-- Script toggle bundle + preview foto --}}
    <script>
        document.querySelectorAll('[id^="edit_item_type_"]').forEach(function(select) {
            const id = select.id.split('_').pop();

            const bundleFields = document.getElementById('edit-bundle-fields_' + id);
            const photoInput = document.getElementById('edit-photo-input_' + id);
            const previewImg = document.getElementById('edit-preview-image_' + id);
            const priceDisplay = document.getElementById('edit_price_display_' + id);
            const priceRaw = document.getElementById('edit_price_raw_' + id);
            const addBtn = document.getElementById('edit-add-bundle-item_' + id);
            const wrapper = document.getElementById('edit-bundle-items-wrapper_' + id);

            // Toggle bundle
            select.addEventListener('change', function() {
                bundleFields.style.display = this.value === 'bundle' ? '' : 'none';
            });

            // Preview foto
            if (photoInput) {
                photoInput.addEventListener('change', function() {
                    const reader = new FileReader();
                    reader.onload = e => previewImg.src = e.target.result;
                    reader.readAsDataURL(this.files[0]);
                });
            }

            // Format harga
            if (priceDisplay) {
                priceDisplay.addEventListener('input', function() {
                    let raw = this.value.replace(/\D/g, '');
                    priceRaw.value = raw;
                    this.value = raw ? parseInt(raw).toLocaleString('id-ID') : '';
                });
            }

            // Tambah bundle item
            if (addBtn) {
                addBtn.addEventListener('click', function() {
                    const index = wrapper.querySelectorAll('.bundle-item-row').length;

                    const html = `
            <div class="bundle-item-row d-flex gap-3 align-items-center">
                <span class="bundle-number">${index + 1}.</span>
                <input type="text" name="bundle_items[${index}][name]" placeholder="Nama">
                <input type="number" name="bundle_items[${index}][qty]" value="1" min="1">
                <input type="hidden" name="bundle_items[${index}][price]">
                <button type="button" class="remove-bundle-item">X</button>
            </div>`;

                    wrapper.insertAdjacentHTML('beforeend', html);
                });
            }

            // Hapus item
            if (wrapper) {
                wrapper.addEventListener('click', function(e) {
                    if (e.target.closest('.remove-bundle-item')) {
                        const rows = wrapper.querySelectorAll('.bundle-item-row');
                        if (rows.length > 1) {
                            e.target.closest('.bundle-item-row').remove();
                        }
                    }
                });
            }
        });

        document.querySelectorAll('[id^="edit_price_display_"]').forEach(function(input) {
            const id = input.id.split('_').pop();
            const rawInput = document.getElementById('edit_price_raw_' + id);

            input.addEventListener('input', function() {
                let value = this.value.replace(/\D/g, '');
                rawInput.value = value;
                this.value = value ? new Intl.NumberFormat('id-ID').format(value) : '';
            });

            // 🔥 INIT (penting!)
            let initial = rawInput.value;
            if (initial) {
                input.value = new Intl.NumberFormat('id-ID').format(initial);
            }
        });

        document.querySelectorAll('[id^="form_edit_tool_"]').forEach(function(form) {
            form.addEventListener('submit', function() {
                const id = this.id.split('_').pop();
                const display = document.getElementById('edit_price_display_' + id);
                const raw = document.getElementById('edit_price_raw_' + id);

                if (display && raw && !raw.value) {
                    raw.value = display.value.replace(/\D/g, '');
                }
            });
        });
    </script>
    <!--end::Javascript-->
</body>
<!--end::Body-->

<!-- Mirrored from preview.keenthemes.com/bold-html-pro/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 06 Mar 2026 08:44:48 GMT -->

</html>
