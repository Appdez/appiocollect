<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="{{ url('/') }}">{{ config('app.name', 'Dashboard') }}</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="{{ url('/') }}">BIOSP</a>
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
                    @if (Route::is('province.*')) active @endif ">
                    <a class=" nav-link" href="{{ route('province.index') }}"><i class="fas fa-city"></i>
                    <span>Províncias</span></a>
                </li>
            </ul>
            <ul class="sidebar-menu">
                <li class="
                    @if (Route::is('document_type.*')) active @endif ">
                    <a class=" nav-link" href="{{ route('document_type.index') }}"><i class="fas fa-id-card "></i>
                    <span>Documentos necessários</span></a>
                </li>
            </ul>

            <ul class="sidebar-menu">
                <li class="
                    @if (Route::is('bairro.*')) active @endif ">
                    <a class=" nav-link" href="{{ route('bairro.index') }}"><i class="fas fa-map-marker-alt"></i>
                    <span>Bairros</span></a>
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
                    @if (Route::is('provenace.*')) active @endif ">
                    <a class=" nav-link" href="{{ route('provenace.index') }}"><i class="fas fa-road "></i>
                    <span>Proviniências</span></a>
                </li>
            </ul>
            <ul class="sidebar-menu">
                <li class="
                    @if (Route::is('forwarded_service.*')) active @endif ">
                    <a class=" nav-link" href="{{ route('forwarded_service.index') }}"><i class="fas fa-forward "></i>
                    <span>Serviços encaminhados</span></a>
                </li>
            </ul>
            <ul class="sidebar-menu">
                <li class="
                    @if (Route::is('purpose_of_visit.*')) active @endif ">
                    <a class=" nav-link" href="{{ route('purpose_of_visit.index') }}"><i class="fas fa-warehouse "></i>
                    <span>Objectivo das visitas</span></a>
                </li>
            </ul>
            <ul class="sidebar-menu">
                <li class="
                    @if (Route::is('reason_opening_case.*')) active @endif ">
                    <a class=" nav-link" href="{{ route('reason_opening_case.index') }}"><i class="fas fa-file-contract "></i>
                    <span>Abertura de processo</span></a>
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
