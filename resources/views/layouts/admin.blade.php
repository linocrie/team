<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>


    <!-- Fonts -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"
          integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w=="
          crossorigin="anonymous"/>
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/pagination.css') }}" rel="stylesheet">

</head>

<body>
@yield('admin_navbar')
    <nav class="navbar navbar-expand-md bg-dark shadow-sm">
        <div class="container">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav mr-auto">

                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ml-auto">
                    <!-- Authentication Links -->
                    @yield('navbar')
                    <li class="nav-item">
                        <a id="users" class="nav-link font-weight-bold text-danger"
                           href="{{ route('admin.users.index') }}" role="button" aria-haspopup="true"
                           aria-expanded="false" v-pre>
                            {{ __('Users') }}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a id="posts" class="nav-link font-weight-bold text-danger"
                           href="{{ route('admin.posts.index') }}" role="button" aria-haspopup="true"
                           aria-expanded="false" v-pre>
                            {{ __('Posts') }}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a id="galleries" class="nav-link font-weight-bold text-danger"
                           href="{{ route('admin.galleries.index') }}" role="button" aria-haspopup="true"
                           aria-expanded="false" v-pre>
                            {{ __('Galleries') }}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a id="professions" class="nav-link font-weight-bold text-danger"
                           href="{{ route('admin.professions.index') }}" role="button" aria-haspopup="true"
                           aria-expanded="false" v-pre>
                            {{ __('Professions') }}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a id="home" class="nav-link font-weight-bold text-danger"
                           href="{{ route('feed') }}" role="button" aria-haspopup="true"
                           aria-expanded="false" v-pre>
                            {{ __('Home') }}
                        </a>
                    </li>

                </ul>
            </div>
        </div>
    </nav>
@yield('admin_content')
</body>


