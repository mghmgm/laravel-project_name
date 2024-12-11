<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

        <!-- Styles -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
        
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="antialiased">
        <header>
            <nav class="navbar navbar-expand-lg bg-body-tertiary">
                <div class="container-fluid">
                    <a class="navbar-brand" href="/">Navbar</a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                            <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="/articles">Посты</a>
                            </li>
                            @can('update')
                            <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="/articles/create">Создать пост</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="/comment/index">All comments</a>
                            </li>
                            @endcan
                            <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="/about">О нас</a>
                            </li>
                            <li class="nav-item">
                            <a class="nav-link" href="/contacts">Контакты</a>
                            </li>
                            @auth
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    Notifications {{ auth()->user()->unreadNotifications->count() }}
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    @foreach(auth()->user()->unreadNotifications as $notification)
                                    <li><a class="dropdown-item" href="{{route('articles.show', ['article'=>$notification->data['article']['id'], 'notify'=>$notification->id])}}">{{$notification->data['article']['name']}}</a></li>
                                    @endforeach
                                </ul>
                            </li>
                            @endauth
                        </ul>
                        @guest
                            <a href="/auth/signup" class="btn btn-outline-success me-3" role="button">SignUp</a>
                            <a href="/auth/login" class="btn btn-outline-success me-3" role="button">SignIn</a>
                        @endguest
                        @auth
                            <a href="/auth/logout" class="btn btn-outline-success " role="button">Logout</a>
                        @endauth
                        </div>
                </div>
            </nav>
        </header>
        <div class='container mt-3'>
            <main>
                <div id="app"></div>
                @yield('content')
            </main>
        </div>
    </body>
</html>
