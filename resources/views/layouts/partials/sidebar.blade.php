<div class="navbar-bg" style="background:#CD5C5C;"></div>
<nav class="navbar navbar-expand-lg main-navbar">
    <form class="form-inline mr-auto">
        <ul class="navbar-nav mr-3">
            <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>
            <li><a href="#" data-toggle="search" class="nav-link nav-link-lg d-sm-none"><i
                        class="fas fa-search"></i></a></li>
        </ul>
    </form>
    <ul class="navbar-nav navbar-right">
        <li class="dropdown"><a href="#" data-toggle="dropdown"
                class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                <img alt="image" src="{{asset('assets/img/avatar/avatar-1.png')}}" class="rounded-circle mr-1">
                <div class="d-sm-none d-lg-inline-block">Hi, {{ Auth::user()->name }}</div>
            </a>
            <div class="dropdown-menu dropdown-menu-right">
                <!-- <div class="dropdown-title">Logged in 5 min ago</div>
                <a href="features-profile.html" class="dropdown-item has-icon">
                    <i class="far fa-user"></i> Profile
                </a>
                <a href="features-activities.html" class="dropdown-item has-icon">
                    <i class="fas fa-bolt"></i> Activities
                </a>
                <a href="features-settings.html" class="dropdown-item has-icon">
                    <i class="fas fa-cog"></i> Settings
                </a> -->
                <div class="dropdown-divider"></div>
                <a href="{{ route('logout') }}" class="dropdown-item has-icon text-danger" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt"></i>
                    {{ __('Logout') }}
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </a>
            </div>
        </li>
    </ul>
</nav>
<div class="main-sidebar">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="index.html"><img src="{{asset('assets/img/tester.png')}}" alt=""></a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="index.html">St</a>
        </div>
        <ul class="sidebar-menu">
            <li class="menu-header">Dashboard</li>
            <li><a class="nav-link" href="{{route('home')}}"><i class="fas fa-home"></i> <span>Dashboard</span></a>
            </li>
            <!-- <li class="nav-item dropdown">
                <a href="#" class="nav-link has-dropdown"><i class="fas fa-fire"></i><span>Dashboard</span></a>
                <ul class="dropdown-menu">
                    <li><a class="nav-link" href="index-0.html">General Dashboard</a></li>
                    <li><a class="nav-link" href="index.html">Ecommerce Dashboard</a></li>
                </ul>
            </li> -->
            @can('role-list')
            <li class="menu-header">Role & Permission</li>

            <li class="@if(Request::is('roles')) active @endif"><a class="nav-link active"
                    href="{{route('roles.index')}}"><i class="fas fa-user-lock"></i> <span>Role & permission</span></a>
            </li>
            @endcan
            @if(Auth::user()->type_user == 1)
            <li class="menu-header">Master</li>

            <li class="dropdown">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-database"></i>
                    <span>Master Data</span></a>
            @else
            @endif
                <ul class="dropdown-menu">
                    @can('akun-bank-list')
                    <li class="@if(Request::is('akun-bank')) active @endif"><a class="nav-link active"
                            href="{{route('akun-bank.index')}}"> <span>Akun Bank</span></a>
                    </li>
                    @endcan
                    <!-- <li class="@if(Request::is('mbranch')) active @endif"><a class="nav-link active" href="{{route('mbranch.index')}}"><i class="fas fa-code-branch"></i> <span>Branch</span></a>
            </li> -->
                    @can('user-list')
                    <li class="@if(Request::is('user')) active @endif"><a class="nav-link active"
                            href="{{route('user.index')}}"><span>User</span></a>
                    </li>
                    @endcan
                    @can('klasifikasi-list')
                    <li class="@if(Request::is('klasifikasi')) active @endif"><a class="nav-link"
                            href="{{route('klasifikasi.index')}}">
                            <span>Klasifikasi-Akun</span></a>
                    </li>
                    @endcan
                    @can('jabatan-list')
                    <li class="@if(Request::is('jabatan')) active @endif"><a class="nav-link"
                            href="{{route('jabatan.index')}}">
                            <span>Jabatan</span></a>
                    </li>
                    @endcan
                    @can('pemeriksa-kas-list')
                    <li class="@if(Request::is('pemeriksa-kas')) active @endif"><a class="nav-link"
                            href="{{route('pemeriksa-kas.index')}}">
                            <span>Pemeriksa Kas</span></a>
                    </li>
                    @endcan
                    @can('jkas-list')
                    <li class="@if(Request::is('jenis-kas')) active @endif"><a class="nav-link"
                            href="{{route('jenis-kas.index')}}">
                            <span>Jenis Kas</span></a>
                    </li>
                    @endcan
                    <!-- <li class="menu-header">Stisla</li> -->
                </ul>
            </li>

            <li class="menu-header">Transaksi</li>
            <li class="dropdown">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-cash-register"></i>
                    <span>Transaksi</span></a>
                <ul class="dropdown-menu">
                    @can('pemakaian-list')
                    <li class="@if(Request::is('pemakaian-kas')) active @endif"><a class="nav-link"
                            href="{{route('pemakaian-kas.index')}}">
                            <span>Pemakaian Kas</span></a>
                    </li>
                    @endcan
                    @can('pengisian-list')
                    <li class="@if(Request::is('pemasukkan-kas')) active @endif"><a class="nav-link"
                            href="{{route('pemasukkan-kas.index')}}"> <span>Pengisian
                                Kas</span></a>
                    </li>
                    @endcan
                    @can('posting-list')
                    <li class="@if(Request::is('posting')) active @endif"><a class="nav-link"
                            href="{{route('posting.index')}}"> <span>Posting Kas</span></a>
                    </li>
                    @endcan
                    @can('cashbon-list')
                    <li class="@if(Request::is('kasbon')) active @endif"><a class="nav-link"
                            href="{{route('kasbon.index')}}"> <span>Kas Bon</span></a>
                    </li>
                    @endcan
                    @can('pertanggungjawaban-list')
                    <li class="@if(Request::is('kas-opname')) active @endif"><a class="nav-link"
                            href="{{route('pertanggungjawaban.index')}}"> <span>Pertanggungjawaban</span></a>
                    </li>
                    @endcan
                </ul>
            </li>

            <li class="menu-header">Kas Opname</li>
            <li class="dropdown">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i
                        class="fas fa-check-double"></i><span>Kas Opname</span></a>
                <ul class="dropdown-menu">
                    @can('cashopname-list')
                    <li class="@if(Request::is('kas-opname')) active @endif"><a class="nav-link"
                            href="{{route('kas-opname.index')}}"> <span>Kas
                                Opname</span></a>
                    </li>
                    @endcan
                    <!-- <li class="@if(Request::is('kas-opname')) active @endif"><a class="nav-link" href="/develops">
                            <span>Kas
                                Opname</span></a>
                    </li> -->
                    @can('efilling-list')
                    <li class="@if(Request::is('efilling-cashopname')) active @endif"><a class="nav-link"
                            href="{{route('efilling-cashopname.index')}}">
                            <span>Efilling Kas
                                Opname</span></a>
                    </li>
                    @endcan
                </ul>
            </li>
            <li class="menu-header">Report Kas</li>
            @can('report-operasional-list')
            <li class="@if(Request::is('report-kas-operasional')) active @endif"><a class="nav-link"
                    href="{{route('report-kas-operasional.index')}}"><i class="fas fa-file"></i> <span>Report Kas
                        Operaional</span></a>
            </li>
            @endcan
            @can('report-nasional-list')
            <li class="@if(Request::is('report.nasional')) active @endif"><a class="nav-link"
                    href="{{route('report.nasional.index')}}"><i class="fas fa-file"></i> <span>Report Kas Nasional
                        Nasional</span></a>
            </li>
            @endcan
            @can('report-lpj-list')
            <li class="@if(Request::is('report-kasbon-lpj')) active @endif"><a class="nav-link"
                    href="{{route('report-kasbon-lpj.index')}}"><i class="fas fa-file"></i> <span>Report Kas LPJ
                    </span></a>
            </li>
            @endcan
        </ul>
        </ul>


    </aside>
</div>
