<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('Animal Adoption') }}</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
</head>
<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom">
    <div class="container">
        <a class="navbar-brand fw-strong align-items-center" href="{{ route('animals.index') }}">
            <span>{{ __('Pet Adoption') }}</span>
        </a>

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

            <ul class="navbar-nav ms-auto align-items-center">
                @auth
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-dark" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
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

    <main class="py-4">
        @yield('content')
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>