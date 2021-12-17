<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="{{ url('/') }}">{{ config('app.name', 'Dashboard') }}</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="{{ url('/') }}">APP10</a>
        </div>
        <ul class="sidebar-menu">
            <li class="menu-header">Painel Administrativo</li>
            <li class="@if (Route::is('dashboard.index')) active @endif"><a
                    class="nav-link" href="{{ route('dashboard.index') }}"><i class="fas fa-chart-line"></i>
                    <span>
                        @if (auth()->user()->hasRole('admin'))
                        Estatísticas
                        @else
                        Relatórios
                        @endif</span></a></li>
        </ul>
        @role('admin')
            <ul class="sidebar-menu">
                <li class="
                    @if (Route::is('district.*')) active @endif ">
                    <a class=" nav-link" href="{{ route('district.index') }}"><i class="fas fa-city"></i>
                    <span>Distritos</span></a>
                </li>
            </ul>
            <ul class="sidebar-menu">
                <li class="
                    @if (Route::is('benefit.*')) active @endif ">
                    <a class=" nav-link" href="{{ route('benefit.index') }}"><i class="fas fa-shopping-basket"></i>
                    <span>Beneficio recibido</span></a>
                </li>
            </ul>
            <ul class="sidebar-menu">
                <li class="
                    @if (Route::is('project_area.*')) active @endif ">
                    <a class=" nav-link" href="{{ route('project_area.index') }}"><i class="fas fa-chart-area"></i>
                    <span>Area do projecto</span></a>
                </li>
            </ul>
            <ul class="sidebar-menu">
                <li class="
                    @if (Route::is('genre.*')) active @endif ">
                    <a class=" nav-link" href="{{ route('genre.index') }}"><i class="fas fa-transgender "></i>
                    <span>Gêneros</span></a>
                </li>
            </ul>

            <ul class="sidebar-menu">
                <li class="
                    @if (Route::is('sendMail.*')) active @endif ">
                    <a class=" nav-link" href="{{ route('sendMail.index') }}"><i class="fas fa-mail-bulk    "></i>
                    <span>Emails para relatórios</span></a>
                </li>
            </ul>

            <ul class="sidebar-menu">
                <li class="
                    @if (Route::is('user.*')) active @endif ">
                    <a class=" nav-link" href="{{ route('user.index') }}"><i class="fas fa-users-cog"></i>
                    <span>Usuários</span></a>
                </li>
            </ul>
        @endrole
    </aside>
</div>

@push('css')
    <style>
        .notification {
            width: 24px;
            padding: 0px;
            text-align: center;
            border-radius: 20px;
            height: 24px;
            text-align-last: center;
            float: right;
            color: #fff;
            font-size: 12px;
            font-weight: 800;
        }

    </style>
@endpush
