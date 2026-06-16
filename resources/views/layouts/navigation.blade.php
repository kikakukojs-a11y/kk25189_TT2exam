<nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom">
    <div class="container">
        <a class="navbar-brand fw-bold align-items-center" href="{{ route('animals.index') }}">
            <span>{{ __('Pet Adoption') }}</span>
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">

            <ul class="navbar-nav me-auto align-items-lg-center">
                <li class="nav-item">
                    <a class="btn btn-sm my-1 my-lg-0 me-1 {{ request()->routeIs('animals.index') ? 'btn-primary' : 'btn-outline-secondary' }}" href="{{ route('animals.index') }}">
                        {{ __('Find Pets') }}
                    </a>
                </li>
                
                @auth
                    @if(auth()->user()->role === 'Admin')
                        <li class="nav-item"><a href="{{ route('admin.animals.create') }}" class="btn btn-sm my-1 my-lg-0 me-1 {{ request()->routeIs('admin.animals.create') ? 'btn-primary' : 'btn-outline-secondary' }}">{{ __('Create Profile') }}</a></li>
                        <li class="nav-item"><a href="{{ route('admin.categories.index') }}" class="btn btn-sm my-1 my-lg-0 me-1 {{ request()->routeIs('admin.categories.index') ? 'btn-primary' : 'btn-outline-secondary' }}">{{ __('Categories') }}</a></li>
                        <li class="nav-item"><a href="{{ route('admin.applications.index') }}" class="btn btn-sm my-1 my-lg-0 me-1 {{ request()->routeIs('admin.applications.index') ? 'btn-primary' : 'btn-outline-secondary' }}">{{ __('Applications') }}</a></li>
                        <li class="nav-item"><a href="{{ route('admin.trash.index') }}" class="btn btn-sm my-1 my-lg-0 me-1 {{ request()->routeIs('admin.trash.index') ? 'btn-primary' : 'btn-outline-secondary' }}">{{ __('Trash') }}</a></li>
                    @endif
                @endauth
            </ul>

            <div class="dropdown">
                <button class="btn btn-outline-secondary dropdown-toggle btn-sm" type="button" data-bs-toggle="dropdown">
                    {{ strtoupper(App::getLocale()) }}
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-menu-item p-2 d-block text-decoration-none text-dark" href="{{ route('lang.switch', 'en') }}">{{ __('English') }}</a></li>
                    <li><a class="dropdown-menu-item p-2 d-block text-decoration-none text-dark" href="{{ route('lang.switch', 'lv') }}">{{ __('Latviešu') }}</a></li>
                    <li><a class="dropdown-menu-item p-2 d-block text-decoration-none text-dark" href="{{ route('lang.switch', 'es') }}">{{ __('Español') }}</a></li>
                    <li><a class="dropdown-menu-item p-2 d-block text-decoration-none text-dark" href="{{ route('lang.switch', 'de') }}">{{ __('Deutsch') }}</a></li>
                </ul>
            </div>

            <ul class="navbar-nav ms-auto align-items-center">
                @auth
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-dark" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                           {{ __('Logged in as:') }} {{ Auth::user()->name }} ({{ Auth::user()->role }})
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li class="dropdown-header">
                                <div class="fw-bold text-dark">{{ Auth::user()->name }}</div>
                                <div class="small text-muted">{{ Auth::user()->email }}</div>
                            </li>
                           
                            <li>
                                <a class="dropdown-item align-items-center {{ request()->routeIs('profile.edit') ? 'active' : '' }}" href="{{ route('profile.edit') }}">
                                  {{ __('My Profile') }}
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item align-items-center {{ request()->routeIs('applications.index') ? 'active' : '' }}" href="{{ route('applications.index') }}">
                                    {{ __('Applications') }}
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}" id="logout-form-nav">
                                    @csrf
                                    <a class="dropdown-item align-items-center" href="{{ route('logout') }}" 
                                       onclick="event.preventDefault(); document.getElementById('logout-form-nav').submit();">
                                       {{ __('Log Out') }}
                                    </a>
                                </form>
                            </li>
                        </ul>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="btn btn-primary text-white mx-1" href="{{ route('login') }}">{{ __('Sign in') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-primary text-white" href="{{ route('register') }}">{{ __('Register') }}</a>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>