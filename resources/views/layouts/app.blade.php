<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Your company name here') }}</title>

        <!-- Styles -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <link href="{{ asset('css/extra.css') }}" rel="stylesheet">
        <link href="{{ asset('css/simplemde.min.css') }}" rel="stylesheet">

        <!-- Scripts -->
        <script>
            window.Laravel = {!! json_encode([
                'csrfToken' => csrf_token(),
            ]) !!};
        </script>

        <script src="{{ asset('js/app.js') }}"></script>
    </head>
    <body>
        <nav class="navbar navbar-default navbar-fixed-top">
            <div class="container">
                <div class="navbar-header">

                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <!-- Branding Image -->
                    <a class="navbar-brand" href="{{ url('/') }}">
                        {{ config('app.name', 'Laravel') }}
                    </a>
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav">
                        &nbsp;
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Authentication Links -->
                        <li><a href="/">Home</a></li>
                        <li><a href="/properties">Find a property</a></li>
                        <li><a href="/contact/message">Send us a message</a></li>
                        <li><a href="/contact/chat/other">Online chat</a></li>
                        @if (Auth::guest())
                            <li><a href="{{ route('login') }}">Login</a></li>
                            <li><a href="{{ route('register') }}">Register</a></li>
                        @else
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    User: {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu" role="menu">
                                    <li class="dropdown-header">My account</li>
                                    <li><a href="/property/saved">My saved properties</a></li>
                                    <li><a href="/properties/searches">My saved searches</a></li>
                                    @if (Gate::allows('can-manage-properties'))
                                        <li class="dropdown-header">Staff functions</li>
                                        <li><a href="/property/create">Add a new property</a></li>
                                        <li><a href="/content/list">Manage content pages</a></li>
                                        <li><a href="/contact/chat/admin">Handle chat conversations</a></li>
                                    @endif
                                    @if (Gate::allows('can-manage-accounts'))
                                        <li class="dropdown-header">Superuser functions</li>
                                        <li><a href="/admin/user">Manage user accounts</a></li>
                                    @endif
                                    <li role="separator" class="divider"></li>
                                    <li>
                                        <a href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            Logout
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </nav>

        @yield('content')

        <footer>
            <div class="container">
                <p>Joe's estate agency</p>
                <p>
                    Built with &quot;online estate agency&quot; software, using <a href="http://laravel.com/">Laravel</a> and
                    <a href="http://getbootstrap.com/">Bootstrap</a>.
                </p>
            </div>
        </footer>
    </body>
</html>
