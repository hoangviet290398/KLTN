<!-- Page Wrapper -->
<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('manageAllUsers') }}">

        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Admin <sup>TS</sup></div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
        <a class="nav-link" href="{{ route('manageAllUsers') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="/">
            <i class="fas fa-fw fa-home"></i>
            <span>Trang chủ</span></a>
    </li>
    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        QUẢN LÝ
    </div>

    <!-- Nav Item - Charts -->
    <li class="nav-item">
        <a class="nav-link" href="{{ route('manageAllUsers') }}">
            <i class="fas fa-fw fa-user"></i>
            <span>Người dùng</span></a>
    </li>

    <!-- Nav Item - Tables -->
    <li class="nav-item">
        <a class="nav-link" href="{{ route('manageAllQuestions') }}">
            <i class="fas fa-fw fa-question"></i>
            <span>Câu hỏi</span></a>
    </li>

    {{-- <!-- Nav Item - Tables -->
        <li class="nav-item">
            <a class="nav-link" href="tables.html">
                <i class="fas fa-fw fa-comment"></i>
                <span>Answers</span></a>
        </li> --}}
    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">



</ul>

<!-- End of Sidebar -->