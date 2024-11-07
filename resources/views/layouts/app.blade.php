<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bibliothèque AJM - @yield('title')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <header>
        <nav>
            <div class="logo">Bibliothèque AJM</div>
            <ul>
                <li>
                    <a href="{{ route('home') }}" 
                       class="{{ request()->routeIs('home') ? 'active' : '' }}">
                        Accueil
                    </a>
                </li>
                <li>
                    <a href="{{ route('nouveautes') }}" 
                       class="{{ request()->routeIs('nouveautes') ? 'active' : '' }}">
                        Nouveautés
                    </a>
                </li>
                <li>
                    <a href="{{ route('contact') }}" 
                       class="{{ request()->routeIs('contact') ? 'active' : '' }}">
                        Contactez-Nous
                    </a>
                </li>
                <li>
                    <a href="{{ route('messages') }}" 
                       class="{{ request()->routeIs('messages') ? 'active' : '' }}">
                        Messages
                    </a>
                </li>
            </ul>
        </nav>
    </header>

    <main>
        @if(session('success'))
            <div class="alert success">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert error">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')
    </main>

    <footer>
        <p>© {{ date('Y') }} Bibliothèque AJM. Tous droits réservés.</p>
    </footer>
</body>
</html>