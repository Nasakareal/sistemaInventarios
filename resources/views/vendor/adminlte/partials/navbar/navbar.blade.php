@inject('layoutHelper', 'JeroenNoten\LaravelAdminLte\Helpers\LayoutHelper')

<nav class="main-header navbar
    {{ config('adminlte.classes_topnav_nav', 'navbar-expand') }}
    {{ config('adminlte.classes_topnav', 'navbar-white navbar-light') }}">

    {{-- Navbar left links --}}
    <ul class="navbar-nav">
        {{-- Left sidebar toggler link --}}
        @include('adminlte::partials.navbar.menu-item-left-sidebar-toggler')

        {{-- Configured left links --}}
        @each('adminlte::partials.navbar.menu-item', $adminlte->menu('navbar-left'), 'item')

        {{-- Custom left links --}}
        @yield('content_top_nav_left')
    </ul>

    {{-- Navbar right links --}}
    <ul class="navbar-nav ml-auto">
        {{-- Custom right links --}}
        @yield('content_top_nav_right')

            {{-- Alerta personalizada 🔔 --}}
            @php
                $alertas = \DB::table('alerts')->where('leido', 0)->get();
            @endphp

            <li class="nav-item dropdown">
                <a class="nav-link" data-toggle="dropdown" href="#">
                    <i class="fas fa-bell"></i>
                    @if($alertas->count() > 0)
                        <span class="badge badge-danger navbar-badge">{{ $alertas->count() }}</span>
                    @endif
                </a>

                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                    <span class="dropdown-item dropdown-header">{{ $alertas->count() }} Alertas sin leer</span>
                    <div class="dropdown-divider"></div>

                    @foreach($alertas as $alerta)
                        <a href="{{ route('alerta.show', $alerta->id) }}" class="dropdown-item">
                            <i class="fas fa-exclamation-circle mr-2"></i>
                            {{ Str::limit($alerta->mensaje, 40) }}
                            <span class="float-right text-muted text-sm">
                                {{ \Carbon\Carbon::parse($alerta->created_at)->diffForHumans() }}
                            </span>
                        </a>
                        <div class="dropdown-divider"></div>
                    @endforeach

                    <a href="{{ route('alerta.index') }}" class="dropdown-item dropdown-footer">Ver todas las alertas</a>
                </div>
            </li>


        {{-- Configured right links --}}
        @each('adminlte::partials.navbar.menu-item', $adminlte->menu('navbar-right'), 'item')

        {{-- User menu link --}}
        @if(Auth::user())
            @if(config('adminlte.usermenu_enabled'))
                @include('adminlte::partials.navbar.menu-item-dropdown-user-menu')
            @else
                @include('adminlte::partials.navbar.menu-item-logout-link')
            @endif
        @endif

        {{-- Right sidebar toggler link --}}
        @if($layoutHelper->isRightSidebarEnabled())
            @include('adminlte::partials.navbar.menu-item-right-sidebar-toggler')
        @endif
    </ul>

</nav>
