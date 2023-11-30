<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav metismenu" id="side-menu">
            <li class="nav-header">
                <div class="dropdown profile-element">
                    <img alt="image" class="rounded-circle" src="{{ asset('build/assets') }}/img/profile_small.jpg" />
                    <div class="dropdown-toggle">
                        <span class="block m-t-xs font-bold text-white">Hai, {{ explode(" ", auth()->user()->name)[0] }}..</span>
                        <span class="text-muted text-xs block">{{ ucfirst(auth()->user()->role) }}</span>
                    </div>
                </div>
                <div class="logo-element">
                    HMD
                </div>
            </li>

            <li class="{{( request()->routeIs('dashboard')) ? 'active' : '' }}">
                <a href="{{ route('dashboard') }}"><i class="fa fa-th-large"></i> <span class="nav-label">Dashboard</span></a>
            </li>

            <li class="{{(    
            request()->routeIs('registration.index') OR 
            request()->routeIs('registration.create')) ? 'active' : '' }}">
                <a href="{{ route('registration.index') }}"><i class="fa fa-id-card"></i> <span class="nav-label">Registrasi</span></a>
            </li>

            <li class="{{(    
            request()->routeIs('checkup.index') OR 
            request()->routeIs('checkup.show') OR 
            request()->routeIs('checkup.create')) ? 'active' : '' }}">
                <a href="{{ route('checkup.index') }}"><i class="fa fa-file-text"></i> <span class="nav-label">Rekam Medis</span></a>
            </li>

            <li class="{{(    
            request()->routeIs('patient.index') OR 
            request()->routeIs('patient.create') OR 
            request()->routeIs('patient.show')) ? 'active' : '' }}">
                <a href="{{ route('patient.index') }}"><i class="fa fa-user"></i> <span class="nav-label">Pasien</span></a>
            </li>

            <li class="{{(    
            request()->routeIs('doctor-schedule.index') OR 
            request()->routeIs('doctor-schedule.show')) ? 'active' : '' }}">
                <a href="{{ route('doctor-schedule.index') }}"><i class="fa fa-calendar"></i> <span class="nav-label">Jadwal Dokter</span></a>
            </li>

            <li class="{{(    
            request()->routeIs('user.index') OR 
            request()->routeIs('poli.index') OR 
            request()->routeIs('service.index') OR 
            request()->routeIs('medicine.index') OR 
            request()->routeIs('icd10.index')) ? 'active' : '' }}">
                <a href="mailbox.html"><i class="fa fa-database"></i> <span class="nav-label">Master Data</span></a>
                <ul class="nav nav-second-level collapse">
                    <li class="{{request()->routeIs('user.index') ? 'active' : '' }}"><a href="{{ route('user.index') }}">Akun</a></li>
                    <li class="{{ request()->routeIs('poli.index') ? 'active' : '' }}"><a href="{{ route('poli.index') }}">Poliklinik</a></li>
                    <li class="{{ request()->routeIs('service.index') ? 'active' : '' }}"><a href="{{ route('service.index') }}">Layanan</a></li>
                    <li class="{{ request()->routeIs('medicine.index') ? 'active' : '' }}"><a href="{{ route('medicine.index') }}">Obat</a></li>
                    <li class="{{ request()->routeIs('icd10.index') ? 'active' : '' }}"><a href="{{ route('icd10.index') }}">ICD10</a></li>
                </ul>
            </li>

            <li class="special_link">
                <a href="javascript:void(0)" id="logout"><i class="fa fa-sign-out"></i> <span class="nav-label">Keluar</span></a>
            </li>
        </ul>

    </div>
</nav>