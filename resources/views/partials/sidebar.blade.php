<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
  <div class="app-brand demo">
    <a href="index.html" class="app-brand-link">
      <span class="app-brand-logo demo">
       <img src="{{ asset('assets/img/SIPAKSI (2).png') }}" alt="Logo" style="width: 300px; height: 220px;" class="img-fluid mt-5 mb-5">
      </span>
    </a>

    <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
      <i class="bx bx-chevron-left d-block d-xl-none align-middle"></i>
    </a>
  </div>

  <div class="menu-divider mt-0"></div>

  <div class="menu-inner-shadow"></div>

<ul class="menu-inner py-1">
  @can('admin')
    
      <li class="menu-item {{ Request::routeIs('dashboard') ? 'active' : '' }}">
          <a href="{{ route('dashboard') }}" class="menu-link">
              <i class="menu-icon tf-icons bx bx-home-alt"></i>
              <div class="text-truncate">Dashboard</div>
          </a>
      </li>

      <li class="menu-header small text-uppercase"><span class="menu-header-text">Manajemen Data Master</span></li>
      
      <li class="menu-item {{ Request::routeIs('gejala') ? 'active' : '' }}">
          <a href="{{ route('gejala') }}" class="menu-link">
              <i class="menu-icon tf-icons bx bx-list-ul"></i>
              <div class="text-truncate">Data Gejala</div>
          </a>
      </li>

      <li class="menu-item {{ Request::routeIs('penyakit') ? 'active' : '' }}">
          <a href="{{ route('penyakit') }}" class="menu-link">
              <i class="menu-icon tf-icons bx bx-bug"></i>
              <div class="text-truncate">Data Penyakit</div>
          </a>
      </li>

      <li class="menu-item {{ Request::routeIs('rules') ? 'active' : '' }}">
          <a href="{{ route('rules') }}" class="menu-link">
              <i class="menu-icon tf-icons bx bx-git-branch"></i>
              <div class="text-truncate">Basis Aturan (Rules)</div>
          </a>
      </li>

    

  @endcan

    <li class="menu-header small text-uppercase"><span class="menu-header-text">Layanan Diagnosa</span></li>

    <li class="menu-item {{ Request::routeIs('diagnosa.index') ? 'active' : '' }}">
        <a href="{{ route('diagnosa.index') }}" class="menu-link">
            <i class="menu-icon tf-icons bx bx-clipboard"></i>
            <div class="text-truncate">Diagnosa Sapi</div>
        </a>
    </li>

    <li class="menu-item {{ request()->routeIs('diagnosa.riwayat*') ? 'active' : '' }}">
        <a href="{{ route('diagnosa.riwayat') }}" class="menu-link">
            <i class="menu-icon tf-icons bx bx-history"></i>
            <div class="text-truncate">Riwayat Medis</div>
        </a>
    </li>

</ul>
    
  </ul>
</aside>