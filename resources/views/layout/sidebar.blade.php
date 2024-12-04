<nav class="sidebar">
  <div class="sidebar-header">
    <a href="#" class="sidebar-brand">
      <img src="{{ asset('/logo.png') }}" alt="">
    </a>
    <div class="sidebar-toggler not-active">
      <span></span>
      <span></span>
      <span></span>
    </div>
  </div>
    <div class="sidebar-body">
        <ul class="nav">
            <li class="nav-item nav-category">Main</li>
            @if(Auth::check() && Auth::user()->role == 'admin')
            <li class="nav-item {{ active_class(['dashboard']) }}">
                <a href="{{ route('dashboard.index') }}" class="nav-link">
                <i class="link-icon" data-feather="box"></i>
                <span class="link-title">Dashboard</span>
                </a>
            </li>
            <li class="nav-item {{ active_class(['hilirasasi-inovasi']) }}">
                <a href="{{ route('hilirasasi-inovasi.index') }}" class="nav-link">
                <i class="link-icon" data-feather="file"></i>
                <span class="link-title">Proposal Data</span>
                </a>
            </li>
            <li class="nav-item nav-category">Apps</li>
            <li class="nav-item {{ active_class(['']) }}">
                <a href="{{ route('hilirasasi-inovasi.index') }}" class="nav-link">
                <i class="link-icon" data-feather="archive"></i>
                <span class="link-title">Arsip Data</span>
                </a>
            </li>
            <li class="nav-item {{ active_class(['']) }}">
                <a href="{{ route('hilirasasi-inovasi.index') }}" class="nav-link">
                <i class="link-icon" data-feather="user"></i>
                <span class="link-title">Data Dosen</span>
                </a>
            </li>
            <li class="nav-item {{ active_class(['']) }}">
                <a href="{{ route('hilirasasi-inovasi.index') }}" class="nav-link">
                <i class="link-icon" data-feather="database"></i>
                <span class="link-title">Data Mitra</span>
                </a>
            </li>
            <li class="nav-item {{ active_class(['']) }}">
                <a href="{{ route('hilirasasi-inovasi.index') }}" class="nav-link">
                <i class="link-icon" data-feather="settings"></i>
                <span class="link-title">Setting</span>
                </a>
            </li>
            @endif
            @if(Auth::check() && Auth::user()->role == 'user')
            <li class="nav-item {{ active_class(['dashboard']) }}">
                <a href="{{ route('dashboard.index') }}" class="nav-link">
                <i class="link-icon" data-feather="box"></i>
                <span class="link-title">Dashboard</span>
                </a>
            </li>
            <li class="nav-item {{ active_class(['proposals']) }}">
                <a href="{{ route('proposals.index') }}" class="nav-link">
                <i class="link-icon" data-feather="file"></i>
                <span class="link-title">Pengajuan Proposal</span>
                </a>
            </li>
            @endif
            @if(Auth::check() && Auth::user()->role == 'reviewer')
            <li class="nav-item {{ active_class(['dashboard']) }}">
                <a href="{{ route('dashboard.index') }}" class="nav-link">
                <i class="link-icon" data-feather="box"></i>
                <span class="link-title">Dashboard</span>
                </a>
            </li>
            <li class="nav-item {{ active_class(['proposals']) }}">
                <a href="{{ route('hilirasasi-inovasi.index') }}" class="nav-link">
                <i class="link-icon" data-feather="file"></i>
                <span class="link-title">Data Proposal</span>
                </a>
            </li>
            <li class="nav-item {{ active_class(['pemenang']) }}">
                <a href="{{ route('pemenang.index') }}" class="nav-link">
                <i class="link-icon" data-feather="award"></i>
                <span class="link-title">Data Pemenang</span>
                </a>
            </li>
            @endif
        </ul>
    </div>
</nav>
<style>
  a.sidebar-brand {
    max-width: 130px;
  }

  a.sidebar-brand img{
    width: 100%;
  }
</style>