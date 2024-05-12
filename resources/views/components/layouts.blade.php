<!DOCTYPE html>
<html lang="pt-BR" class="h-full bg-gray-100">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>App Futebol</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" href="{{ URL::to('/assets/images/bola.png') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body class="h-full">
    <div class="min-h-full">
        <nav class="bg-gray-800">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="flex h-16 items-center justify-between">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <img class="h-8 w-8" src="{{ URL::to('/assets/images/bola.png') }}" alt="Your Company">
                        </div>
                        <div class="hidden md:block">
                            <div class="ml-10 flex items-baseline space-x-4">
                                <!-- Current: "bg-gray-900 text-white", Default: "text-gray-300 hover:bg-gray-700 hover:text-white" -->
                                <a href="{{ route('home') }}"
                                    class="{{ request()->is('/') ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }} rounded-md px-3 py-2 text-sm font-medium"
                                    aria-current="page">Home</a>
                                <a href="{{ route('players.index') }}"
                                    class="{{ request()->is('players') ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }} rounded-md px-3 py-2 text-sm font-medium">Jogadores</a>
                                <a href="{{ route('games.index') }}"
                                    class="{{ request()->is('games') ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }} rounded-md px-3 py-2 text-sm font-medium">Partidas</a>

                            </div>
                        </div>
                    </div>
                    <div class="hidden md:block">
                        @if (Route::has('login'))
                            <div class="ml-4 flex items-center md:ml-6">
                                @auth
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit"
                                            class="text-gray-300 hover:bg-gray-700 hover:text-white rounded-md px-3 py-2 text-sm font-medium">
                                            Sair
                                        </button>
                                    </form>

                                    <!-- Profile dropdown -->
                                    <div class="relative ml-3">
                                        <div>
                                            <button type="button"
                                                class="relative flex max-w-xs items-center rounded-full bg-gray-800 text-sm focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800"
                                                id="user-menu-button" aria-expanded="false" aria-haspopup="true">
                                                <span class="absolute -inset-1.5"></span>
                                                <span class="sr-only">Open user menu</span>
                                                <img class="h-8 w-8 rounded-full"
                                                    src="{{ URL::to('/assets/images/soccer-player.png') }}" alt="">
                                            </button>
                                        </div>

                                    </div>
                                @else
                                    <a href="{{ route('login') }}"
                                        class="{{ request()->is('login') ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white ' }} rounded-md px-3 py-2 text-sm font-medium">Entrar</a>
                                    @if (Route::has('register'))
                                        <a href="{{ route('register') }}"
                                            class="{{ request()->is('register') ? 'bg-gray-900 text-white' : 'text-green-300 hover:bg-gray-700 hover:text-white ' }} rounded-md px-3 py-2 text-sm font-medium">Cadastre-se</a>
                                    @endif
                                @endauth
                            </div>
                        @endif
                    </div>
                    <div class="-mr-2 flex md:hidden">
                        <!-- Mobile menu button -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="text-gray-300 hover:bg-gray-700 hover:text-white rounded-md px-3 py-2 text-sm font-medium">
                                Sair
                            </button>
                        </form>
                        <button type="button"
                            class="relative inline-flex items-center justify-center rounded-md bg-gray-800 p-2 text-gray-400 hover:bg-gray-700 hover:text-white focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800"
                            aria-controls="mobile-menu" aria-expanded="false">
                            <span class="absolute -inset-0.5"></span>
                            <span class="sr-only">Open main menu</span>
                            <!-- Menu open: "hidden", Menu closed: "block" -->
                            <svg class="block h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                            </svg>
                            <!-- Menu open: "block", Menu closed: "hidden" -->
                            <svg class="hidden h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Mobile menu, show/hide based on menu state. -->
            <div class="md:hidden" id="mobile-menu">
                <div class="space-y-1 px-2 pb-3 pt-2 sm:px-3">
                    <!-- Current: "bg-gray-900 text-white", Default: "text-gray-300 hover:bg-gray-700 hover:text-white" -->
                    <a href="{{ route('home') }}"
                        class="{{ request()->is('/') ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }} rounded-md px-3 py-2 text-sm font-medium"
                        aria-current="page">Home</a>
                    <a href="{{ route('players.index') }}"
                        class="{{ request()->is('players') ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }} rounded-md px-3 py-2 text-sm font-medium">Jogadores</a>
                    <a href="{{ route('games.index') }}"
                        class="{{ request()->is('games') ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }} rounded-md px-3 py-2 text-sm font-medium">Partidas</a>

                </div>
                @if (Route::has('login'))
                    <div class="border-t border-gray-700 pb-3 pt-4">
                        @auth
                            <div class="flex items-center px-5">
                                <div class="flex-shrink-0">
                                    <img class="h-10 w-10 rounded-full"
                                        src="{{ URL::to('/assets/images/soccer-player.png') }}" alt="">
                                </div>
                                <div class="ml-3">
                                    <div class="text-base font-medium leading-none text-white">{{ Auth::user()->nickname }}
                                    </div>
                                    <div class="text-sm font-medium leading-none text-gray-400">{{ Auth::user()->name }}
                                    </div>
                                </div>
                                <button type="button"
                                    class="relative ml-auto flex-shrink-0 rounded-full bg-gray-800 p-1 text-gray-400 hover:text-white focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800">
                                    <!-- logout -->
                                </button>
                            </div>
                        @else
                            <a href="{{ route('login') }}"
                                class="{{ request()->is('/login') ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white rounded-md px-3 py-2 text-sm font-medium' }} ">Entrar</a>

                            @if (Route::has('register'))
                                <a href="{{ route('register') }}"
                                    class="{{ request()->is('/register') ? 'bg-gray-900 text-white' : 'text-green-300 hover:bg-gray-700 hover:text-white rounded-md px-3 py-2 text-sm font-medium' }}">Cadastre-se</a>
                            @endif
                        @endauth
                    </div>
                @endif
            </div>
        </nav>

        <header class="bg-white shadow">
            <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
                <h1 class="text-3xl font-bold tracking-tight text-gray-900">{{ $header }}</h1>
            </div>
        </header>
        <main>
            <div class="mx-auto max-w-7xl py-6 sm:px-6 lg:px-8">
                {{ $slot }}
            </div>
        </main>
    </div>

</body>

</html>
