<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="@yield('meta_description', 'Angorenda - Plataforma de imóveis em Angola. Encontre casas, apartamentos e terrenos para venda e arrendamento.')">
    <title>@yield('title', 'Angorenda - Imóveis em Angola')</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    },
                    colors: {
                        brand: {
                            50: '#eff6ff',
                            100: '#dbeafe',
                            200: '#bfdbfe',
                            300: '#93c5fd',
                            400: '#60a5fa',
                            500: '#3b82f6',
                            600: '#2563eb',
                            700: '#1d4ed8',
                            800: '#1e40af',
                            900: '#1e3a5f',
                        },
                    },
                },
            },
        }
    </script>

    <style>
        [x-cloak] { display: none !important; }
    </style>

    @stack('styles')
</head>
<body class="font-sans bg-gray-50 text-gray-900 antialiased">

    <!-- Navbar -->
    <nav class="bg-white border-b border-gray-200 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <!-- Logo -->
                <a href="{{ route('home') }}" class="flex items-center gap-2 text-xl font-bold text-gray-900 hover:text-brand-600 transition-colors">
                    <svg class="w-7 h-7 text-brand-600" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z"/>
                    </svg>
                    Angorenda
                </a>

                <!-- Nav Links -->
                <div class="hidden md:flex items-center gap-6">
                    <a href="{{ route('home') }}" class="text-sm font-medium text-gray-600 hover:text-gray-900 transition-colors">Início</a>
                    <a href="{{ route('properties.index') }}" class="text-sm font-medium text-gray-600 hover:text-gray-900 transition-colors">Imóveis</a>
                    <a href="{{ route('properties.index', ['purpose' => 'sale']) }}" class="text-sm font-medium text-gray-600 hover:text-gray-900 transition-colors">Comprar</a>
                    <a href="{{ route('properties.index', ['purpose' => 'rent']) }}" class="text-sm font-medium text-gray-600 hover:text-gray-900 transition-colors">Arrendar</a>
                </div>

                <!-- Right Actions -->
                <div class="flex items-center gap-3">
                    @auth
                        @if(auth()->user()->role === 'admin')
                            <a href="/admin" class="hidden sm:inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-white bg-brand-600 rounded-lg hover:bg-brand-700 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                Painel Admin
                            </a>
                        @else
                            <a href="{{ route('owner.properties.create') }}" class="hidden sm:inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-white bg-brand-600 rounded-lg hover:bg-brand-700 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                Anunciar
                            </a>
                        @endif
                        <div class="relative group">
                            <button class="flex items-center gap-2 px-3 py-2 rounded-lg border border-gray-200 hover:bg-gray-50 transition-colors">
                                <div class="w-8 h-8 bg-brand-100 text-brand-600 rounded-full flex items-center justify-center text-sm font-semibold">
                                    {{ substr(auth()->user()->name, 0, 1) }}
                                </div>
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                            </button>
                            <div class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-lg border border-gray-100 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200">
                                @if(auth()->user()->role === 'admin')
                                    <a href="/admin" class="block px-4 py-3 text-sm text-gray-700 hover:bg-gray-50 rounded-t-xl">Painel Admin</a>
                                @else
                                    <a href="{{ route('owner.dashboard') }}" class="block px-4 py-3 text-sm text-gray-700 hover:bg-gray-50 rounded-t-xl">Minha Conta</a>
                                @endif
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="block w-full text-left px-4 py-3 text-sm text-red-600 hover:bg-red-50 rounded-b-xl">Sair</button>
                                </form>
                            </div>
                        </div>
                    @else
                        <a href="/login" class="px-4 py-2 text-sm font-medium text-gray-700 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">Entrar</a>
                    @endauth

                    <!-- Mobile Menu Toggle -->
                    <button id="mobile-menu-btn" class="md:hidden p-2 rounded-lg hover:bg-gray-100 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                    </button>
                </div>
            </div>

            <!-- Mobile Menu -->
            <div id="mobile-menu" class="md:hidden hidden pb-4 border-t border-gray-100 mt-2 pt-4 space-y-1">
                <a href="{{ route('home') }}" class="block px-3 py-2 text-base font-medium text-gray-600 hover:text-gray-900 hover:bg-gray-50 rounded-lg">Início</a>
                <a href="{{ route('properties.index') }}" class="block px-3 py-2 text-base font-medium text-gray-600 hover:text-gray-900 hover:bg-gray-50 rounded-lg">Imóveis</a>
                <a href="{{ route('properties.index', ['purpose' => 'sale']) }}" class="block px-3 py-2 text-base font-medium text-gray-600 hover:text-gray-900 hover:bg-gray-50 rounded-lg">Comprar</a>
                <a href="{{ route('properties.index', ['purpose' => 'rent']) }}" class="block px-3 py-2 text-base font-medium text-gray-600 hover:text-gray-900 hover:bg-gray-50 rounded-lg">Arrendar</a>
                
                <div class="border-t border-gray-100 my-2 pt-2"></div>
                
                @auth
                    @if(auth()->user()->role === 'admin')
                        <a href="/admin" class="block px-3 py-2 text-base font-medium text-brand-600 hover:bg-brand-50 rounded-lg">Painel Admin</a>
                    @else
                        <a href="{{ route('owner.dashboard') }}" class="block px-3 py-2 text-base font-medium text-brand-600 hover:bg-brand-50 rounded-lg">Minha Conta</a>
                        <a href="{{ route('owner.properties.create') }}" class="block px-3 py-2 text-base font-medium text-gray-600 hover:bg-gray-50 rounded-lg">Anunciar Imóvel</a>
                    @endif
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="block w-full text-left px-3 py-2 text-base font-medium text-red-600 hover:bg-red-50 rounded-lg">Sair</button>
                    </form>
                @else
                    <a href="/login" class="block px-3 py-2 text-base font-medium text-brand-600 hover:bg-brand-50 rounded-lg">Fazer Login</a>
                    <a href="/signup" class="block px-3 py-2 text-base font-medium text-gray-600 hover:bg-gray-50 rounded-lg">Criar Conta</a>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gray-900 text-gray-400 mt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <!-- Brand -->
                <div class="md:col-span-2">
                    <a href="{{ route('home') }}" class="flex items-center gap-2 text-xl font-bold text-white mb-4">
                        <svg class="w-7 h-7 text-brand-400" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z"/>
                        </svg>
                        Angorenda
                    </a>
                    <p class="text-sm leading-relaxed max-w-md">A plataforma de referência para encontrar imóveis em Angola. Encontre casas, apartamentos e terrenos para venda e arrendamento.</p>
                </div>

                <!-- Links -->
                <div>
                    <h4 class="text-white font-semibold text-sm mb-4">Navegação</h4>
                    <ul class="space-y-2">
                        <li><a href="{{ route('properties.index') }}" class="text-sm hover:text-white transition-colors">Todos os Imóveis</a></li>
                        <li><a href="{{ route('properties.index', ['purpose' => 'sale']) }}" class="text-sm hover:text-white transition-colors">Comprar</a></li>
                        <li><a href="{{ route('properties.index', ['purpose' => 'rent']) }}" class="text-sm hover:text-white transition-colors">Arrendar</a></li>
                    </ul>
                </div>

                <!-- Contact -->
                <div>
                    <h4 class="text-white font-semibold text-sm mb-4">Contacto</h4>
                    <ul class="space-y-2">
                        <li class="text-sm">Luanda, Angola</li>
                        <li><a href="mailto:info@angorenda.com" class="text-sm hover:text-white transition-colors">info@angorenda.com</a></li>
                    </ul>
                </div>
            </div>

            <div class="border-t border-gray-800 mt-10 pt-6 text-center">
                <p class="text-xs">&copy; {{ date('Y') }} Angorenda. Todos os direitos reservados.</p>
            </div>
        </div>
    </footer>

    <script>
        document.getElementById('mobile-menu-btn')?.addEventListener('click', function() {
            document.getElementById('mobile-menu')?.classList.toggle('hidden');
        });
    </script>

    @stack('scripts')
</body>
</html>
