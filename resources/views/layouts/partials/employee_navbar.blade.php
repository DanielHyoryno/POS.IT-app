@if(Auth::check() && Auth::user()->role === 'employee')
<nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
    <div class="container-fluid">

        {{-- Logo --}}
        <a class="navbar-brand fw-bold" href="{{ route('employee.dashboard') }}">
            POS.it
        </a>

        {{-- Toggle button (mobile) --}}
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#employeeNavbar"
            aria-controls="employeeNavbar" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        {{-- Navbar menu --}}
        <div class="collapse navbar-collapse" id="employeeNavbar">

            {{-- Left Side: Employee Menus --}}
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">

                {{-- 1. Dashboard --}}
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('employee.dashboard') ? 'active' : '' }}"
                        href="{{ route('employee.dashboard') }}">
                        {{ __('Dashboard') }}
                    </a>
                </li>

                {{-- 2. Cart (Keranjang) --}}
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('employee.sales.catalog') ? 'active' : '' }}"
                        href="{{ route('employee.sales.cart.show') }}">
                        {{ __('Cart') }}
                    </a>
                </li>

                {{-- 3. Products (Cek Stok) --}}
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('employee.items.index') ? 'active' : '' }}"
                        href="{{ route('employee.sales.catalog') }}">
                        {{ __('Products') }}
                    </a>
                </li>

                {{-- 4. History (Riwayat) --}}
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('employee.sales.history.index') ? 'active' : '' }}"
                        href="{{ route('employee.sales.history.index') }}">
                        {{ __('History') }}
                    </a>
                </li>

            </ul>

            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                {{-- Toggle Dark Mode  --}}
                <li class="nav-item me-2">
                    <button type="button" @click="darkMode = !darkMode" class="btn btn-sm btn-outline-secondary"
                        :title="darkMode ? 'Light Mode' : 'Dark Mode'">

                        <span x-show="!darkMode">🌙</span>
                        <span x-show="darkMode">☀️</span>
                    </button>
                </li>

                {{-- Language Dropdown --}}
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                        {{ strtoupper(app()->getLocale()) }}
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <a class="dropdown-item {{ app()->getLocale() == 'en' ? 'active' : '' }}"
                                href="{{ route('switch.lang', 'en') }}">
                                🇺🇸 {{ __('English') }}
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item {{ app()->getLocale() == 'id' ? 'active' : '' }}"
                                href="{{ route('switch.lang', 'id') }}">
                                🇮🇩 {{ __('Indonesia') }}
                            </a>
                        </li>
                    </ul>
                </li>

                {{-- User Profile Dropdown --}}
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        {{ Auth::user()->name }}
                    </a>

                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                        <li>
                            <div class="px-3 py-2 border-bottom">
                                <div class="fw-semibold text-dark">{{ Auth::user()->name }}</div>
                                <div class="text-muted small">{{ Auth::user()->email }}</div>
                            </div>
                        </li>

                        <li>
                            <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                {{ __('Profile') }}
                            </a>
                        </li>

                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item">
                                    {{ __('Log Out') }}
                                </button>
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>

        </div>
    </div>
</nav>
@endif