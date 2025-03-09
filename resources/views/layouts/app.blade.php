<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Connect Commerce') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased min-h-screen flex flex-col bg-gray-50">
    <!-- Navbar -->
    <nav class="bg-gradient-to-r from-primary-700 to-primary-600 shadow-md sticky top-0 z-50" x-data="{ open: false }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex">
                    <!-- Logo -->
                    <div class="flex-shrink-0 flex items-center">
                        <a href="{{ url('/') }}" class="text-white font-bold text-xl flex items-center group">
                            <div class="mr-2 bg-white/15 p-1.5 rounded-lg group-hover:bg-white/25 transition-all duration-200 shadow-sm">
                                <x-icon name="shopping-cart" class="h-5 w-5 text-white" />
                            </div>
                            <div class="font-semibold tracking-tight">
                                Connect<span class="font-light opacity-90">Commerce</span>
                            </div>
                        </a>
                    </div>
                    
                    <!-- Primary Navigation Menu (Desktop) -->
                    <div class="hidden sm:ml-8 sm:flex sm:items-center sm:space-x-1">
                        <a href="{{ url('/') }}" class="text-white/90 hover:text-white px-3 py-2 rounded-lg text-sm font-medium transition-all duration-150 hover:bg-white/10 {{ request()->is('/') ? 'bg-white/20 text-white shadow-sm' : '' }}">Home</a>
                        
                        <a href="#" class="text-white/90 hover:text-white px-3 py-2 rounded-lg text-sm font-medium transition-all duration-150 hover:bg-white/10">Features</a>
                        
                        <a href="#" class="text-white/90 hover:text-white px-3 py-2 rounded-lg text-sm font-medium transition-all duration-150 hover:bg-white/10">Pricing</a>
                        
                        @auth
                            <a href="{{ route('home') }}" class="text-white/90 hover:text-white px-3 py-2 rounded-lg text-sm font-medium transition-all duration-150 hover:bg-white/10 {{ request()->routeIs('home') ? 'bg-white/20 text-white shadow-sm' : '' }}">
                                <x-icon name="home" class="h-4 w-4 inline-block mr-1 -mt-0.5" />
                                Dashboard
                            </a>
                            
                            @if(Auth::user()->isStoreOwner())
                                <a href="{{ route('stores.index') }}" class="text-white/90 hover:text-white px-3 py-2 rounded-lg text-sm font-medium transition-all duration-150 hover:bg-white/10 {{ request()->routeIs('stores.index') ? 'bg-white/20 text-white shadow-sm' : '' }}">
                                    <x-icon name="users" class="h-4 w-4 inline-block mr-1 -mt-0.5" />
                                    My Stores
                                </a>
                            @endif
                            
                            @if(Auth::user()->isAdmin())
                                <a href="{{ route('stores.index') }}" class="text-white/90 hover:text-white px-3 py-2 rounded-lg text-sm font-medium transition-all duration-150 hover:bg-white/10 {{ request()->routeIs('stores.index') ? 'bg-white/20 text-white shadow-sm' : '' }}">
                                    <x-icon name="database" class="h-4 w-4 inline-block mr-1 -mt-0.5" />
                                    All Stores
                                </a>
                            @endif
                        @endauth
                    </div>
                </div>
                
                <!-- Right Navigation -->
                <div class="hidden sm:flex sm:items-center">
                    @guest
                        <a href="{{ route('login') }}" class="text-white/90 hover:text-white px-3 py-2 hover:bg-white/10 rounded-lg text-sm font-medium transition-all duration-150">Log in</a>
                        <a href="{{ route('register') }}" class="ml-3 bg-white text-primary-700 hover:bg-white/90 px-4 py-2 rounded-lg text-sm font-medium shadow-md transition-all duration-150 hover:translate-y-[-1px]">Get Started</a>
                    @else
                        <x-dropdown align="right" width="56">
                            <x-slot name="trigger">
                                <button class="flex items-center text-sm font-medium text-white/90 hover:text-white transition-all duration-150 ease-in-out hover:bg-white/10 px-3 py-1.5 rounded-lg">
                                    <div class="flex items-center space-x-3">
                                        <div class="h-8 w-8 rounded-full bg-white/15 flex items-center justify-center text-white text-sm font-medium border border-white/5 shadow-sm">
                                            {{ substr(Auth::user()->name, 0, 1) }}
                                        </div>
                                        <div class="flex flex-col items-start">
                                            <span class="font-medium">{{ Auth::user()->name }}</span>
                                            <span class="text-xs text-white/70">{{ Auth::user()->email }}</span>
                                        </div>
                                    </div>
                                    <x-icon name="chevron-down" class="ml-2 h-4 w-4 text-white/70" />
                                </button>
                            </x-slot>

                            <x-slot name="content">
                                <div class="px-4 py-3 border-b border-gray-100 bg-gray-50">
                                    <p class="text-xs text-gray-500">Signed in as</p>
                                    <p class="text-sm font-medium text-gray-900 truncate">{{ Auth::user()->email }}</p>
                                </div>
                                
                                <div class="py-1">
                                    <a href="{{ route('home') }}" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-primary-600 group transition-colors">
                                        <x-icon name="home" class="mr-2 h-4 w-4 text-gray-500 group-hover:text-primary-500" />
                                        Dashboard
                                    </a>
                                    
                                    <a href="#" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-primary-600 group transition-colors">
                                        <x-icon name="user" class="mr-2 h-4 w-4 text-gray-500 group-hover:text-primary-500" />
                                        Profile
                                    </a>
                                    
                                    <a href="#" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-primary-600 group transition-colors">
                                        <x-icon name="settings" class="mr-2 h-4 w-4 text-gray-500 group-hover:text-primary-500" />
                                        Settings
                                    </a>
                                </div>
                                
                                <div class="border-t border-gray-100">
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="flex w-full items-center px-4 py-2 text-sm text-gray-700 hover:bg-red-50 group transition-colors">
                                            <x-icon name="log-out" class="mr-2 h-4 w-4 text-gray-500 group-hover:text-red-500" />
                                            <span class="group-hover:text-red-600">Logout</span>
                                        </button>
                                    </form>
                                </div>
                            </x-slot>
                        </x-dropdown>
                    @endguest
                </div>
                
                <!-- Hamburger -->
                <div class="flex items-center sm:hidden">
                    <button @click="open = !open" class="p-2 rounded-md text-gray-400 hover:text-white hover:bg-indigo-600 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white">
                        <x-icon name="menu" :class="{'hidden': open, 'inline-flex': !open }" class="h-6 w-6" />
                        <x-icon name="x" :class="{'inline-flex': open, 'hidden': !open }" class="h-6 w-6" />
                    </button>
                </div>
            </div>
        </div>
        
        <!-- Responsive Navigation Menu (Mobile) -->
        <div x-show="open" 
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 transform -translate-y-4"
             x-transition:enter-end="opacity-100 transform translate-y-0"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100 transform translate-y-0"
             x-transition:leave-end="opacity-0 transform -translate-y-4"
             class="sm:hidden bg-primary-700 border-t border-primary-800/50">
            <div class="px-2 pt-2 pb-3 space-y-1">
                <a href="{{ url('/') }}" class="flex items-center text-white/90 hover:text-white px-3 py-2 rounded-lg text-base font-medium transition-all duration-150 hover:bg-white/10 {{ request()->is('/') ? 'bg-white/10 text-white' : '' }}">
                    <x-icon name="home" class="h-5 w-5 mr-3" />
                    Home
                </a>
                <a href="#" class="flex items-center text-white/90 hover:text-white px-3 py-2 rounded-lg text-base font-medium transition-all duration-150 hover:bg-white/10">
                    <x-icon name="star" class="h-5 w-5 mr-3" />
                    Features
                </a>
                <a href="#" class="flex items-center text-white/90 hover:text-white px-3 py-2 rounded-lg text-base font-medium transition-all duration-150 hover:bg-white/10">
                    <x-icon name="dollar-sign" class="h-5 w-5 mr-3" />
                    Pricing
                </a>
                
                @auth
                    <a href="{{ route('home') }}" class="flex items-center text-white/90 hover:text-white px-3 py-2 rounded-lg text-base font-medium transition-all duration-150 hover:bg-white/10 {{ request()->routeIs('home') ? 'bg-white/10 text-white' : '' }}">
                        <x-icon name="bar-chart-2" class="h-5 w-5 mr-3" />
                        Dashboard
                    </a>
                    @if(Auth::user()->isStoreOwner())
                        <a href="{{ route('stores.index') }}" class="flex items-center text-white/90 hover:text-white px-3 py-2 rounded-lg text-base font-medium transition-all duration-150 hover:bg-white/10 {{ request()->routeIs('stores.index') ? 'bg-white/10 text-white' : '' }}">
                            <x-icon name="users" class="h-5 w-5 mr-3" />
                            My Stores
                        </a>
                    @endif
                    @if(Auth::user()->isAdmin())
                        <a href="{{ route('stores.index') }}" class="flex items-center text-white/90 hover:text-white px-3 py-2 rounded-lg text-base font-medium transition-all duration-150 hover:bg-white/10 {{ request()->routeIs('stores.index') ? 'bg-white/10 text-white' : '' }}">
                            <x-icon name="database" class="h-5 w-5 mr-3" />
                            All Stores
                        </a>
                    @endif
                @endauth
            </div>
        </div>
    </nav>

    <!-- Flash Messages -->
    @if(session('success'))
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
            <div class="bg-green-50 border-l-4 border-green-400 p-4 rounded-lg shadow-sm flex items-center justify-between">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <x-icon name="check-circle" class="h-5 w-5 text-green-500" />
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-green-800">
                            {{ session('success') }}
                        </p>
                    </div>
                </div>
                <button type="button" class="text-green-500 hover:text-green-700" onclick="this.parentElement.remove()">
                    <x-icon name="x" class="h-4 w-4" />
                </button>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
            <div class="bg-red-50 border-l-4 border-red-400 p-4 rounded-lg shadow-sm flex items-center justify-between">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <x-icon name="x-circle" class="h-5 w-5 text-red-500" />
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-red-800">
                            {{ session('error') }}
                        </p>
                    </div>
                </div>
                <button type="button" class="text-red-500 hover:text-red-700" onclick="this.parentElement.remove()">
                    <x-icon name="x" class="h-4 w-4" />
                </button>
            </div>
        </div>
    @endif

    @if(session('warning'))
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
            <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded-lg shadow-sm flex items-center justify-between">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <x-icon name="alert-triangle" class="h-5 w-5 text-yellow-500" />
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-yellow-800">
                            {{ session('warning') }}
                        </p>
                    </div>
                </div>
                <button type="button" class="text-yellow-500 hover:text-yellow-700" onclick="this.parentElement.remove()">
                    <x-icon name="x" class="h-4 w-4" />
                </button>
            </div>
        </div>
    @endif

    @if(session('info'))
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
            <div class="bg-blue-50 border-l-4 border-blue-400 p-4 rounded-lg shadow-sm flex items-center justify-between">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <x-icon name="info" class="h-5 w-5 text-blue-500" />
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-blue-800">
                            {{ session('info') }}
                        </p>
                    </div>
                </div>
                <button type="button" class="text-blue-500 hover:text-blue-700" onclick="this.parentElement.remove()">
                    <x-icon name="x" class="h-4 w-4" />
                </button>
            </div>
        </div>
    @endif

    <!-- Page Content -->
    <main class="py-6 flex-grow">
        @hasSection('header')
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-6">
                <h1 class="text-2xl font-semibold text-gray-900 flex items-center">
                    @yield('header-icon')
                    <span>@yield('header')</span>
                </h1>
                @hasSection('header-subtitle')
                    <p class="mt-1 text-sm text-gray-600">
                        @yield('header-subtitle')
                    </p>
                @endif
            </div>
        @endif

        <div class="@hasSection('full-width') w-full @else max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 @endif">
            @yield('content')
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-gray-200 py-12 mt-auto">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-5 gap-8">
                <div class="md:col-span-2">
                    <a href="{{ url('/') }}" class="text-primary-600 font-bold text-xl flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 mr-2 text-primary-500" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3zM16 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM6.5 18a1.5 1.5 0 100-3 1.5 1.5 0 000 3z" />
                        </svg>
                        Connect<span class="text-primary-400">Commerce</span>
                    </a>
                    <p class="mt-4 text-gray-500 text-sm">
                        Create beautiful online stores in minutes. ConnectCommerce provides everything you need to start, run, and grow your e-commerce business.
                    </p>
                    <div class="mt-6">
                        <p class="text-sm text-gray-500">
                            &copy; {{ date('Y') }} ConnectCommerce. All rights reserved.
                        </p>
                    </div>
                </div>
                
                <div>
                    <h3 class="text-sm font-semibold text-gray-600 tracking-wider uppercase mb-4">Product</h3>
                    <ul class="space-y-3">
                        <li><a href="#" class="text-sm text-gray-500 hover:text-primary-600 transition duration-150">Features</a></li>
                        <li><a href="#" class="text-sm text-gray-500 hover:text-primary-600 transition duration-150">Pricing</a></li>
                        <li><a href="#" class="text-sm text-gray-500 hover:text-primary-600 transition duration-150">Security</a></li>
                        <li><a href="#" class="text-sm text-gray-500 hover:text-primary-600 transition duration-150">Enterprise</a></li>
                    </ul>
                </div>
                
                <div>
                    <h3 class="text-sm font-semibold text-gray-600 tracking-wider uppercase mb-4">Resources</h3>
                    <ul class="space-y-3">
                        <li><a href="#" class="text-sm text-gray-500 hover:text-primary-600 transition duration-150">Documentation</a></li>
                        <li><a href="#" class="text-sm text-gray-500 hover:text-primary-600 transition duration-150">Help Center</a></li>
                        <li><a href="#" class="text-sm text-gray-500 hover:text-primary-600 transition duration-150">API Guide</a></li>
                        <li><a href="#" class="text-sm text-gray-500 hover:text-primary-600 transition duration-150">Community</a></li>
                    </ul>
                </div>
                
                <div>
                    <h3 class="text-sm font-semibold text-gray-600 tracking-wider uppercase mb-4">Connect</h3>
                    <ul class="space-y-3">
                        <li><a href="#" class="text-sm text-gray-500 hover:text-primary-600 transition duration-150">Contact Us</a></li>
                        <li><a href="#" class="text-sm text-gray-500 hover:text-primary-600 transition duration-150">Twitter</a></li>
                        <li><a href="#" class="text-sm text-gray-500 hover:text-primary-600 transition duration-150">LinkedIn</a></li>
                        <li><a href="#" class="text-sm text-gray-500 hover:text-primary-600 transition duration-150">Facebook</a></li>
                    </ul>
                </div>
            </div>
            
            <div class="mt-12 pt-8 border-t border-gray-100">
                <div class="flex flex-col md:flex-row md:justify-between md:items-center">
                    <div class="flex space-x-6">
                        <a href="#" class="text-gray-400 hover:text-primary-500 transition duration-150">
                            <span class="sr-only">Facebook</span>
                            <x-icon name="facebook" class="h-6 w-6" />
                        </a>
                        <a href="#" class="text-gray-400 hover:text-primary-500 transition duration-150">
                            <span class="sr-only">Twitter</span>
                            <x-icon name="twitter" class="h-6 w-6" />
                        </a>
                        <a href="#" class="text-gray-400 hover:text-primary-500 transition duration-150">
                            <span class="sr-only">GitHub</span>
                            <x-icon name="github" class="h-6 w-6" />
                        </a>
                        <a href="#" class="text-gray-400 hover:text-primary-500 transition duration-150">
                            <span class="sr-only">Instagram</span>
                            <x-icon name="instagram" class="h-6 w-6" />
                        </a>
                    </div>
                    
                    <div class="mt-6 md:mt-0">
                        <ul class="flex space-x-6 md:justify-end text-xs text-gray-500">
                            <li><a href="#" class="hover:text-primary-600 transition duration-150">Privacy Policy</a></li>
                            <li><a href="#" class="hover:text-primary-600 transition duration-150">Terms of Service</a></li>
                            <li><a href="#" class="hover:text-primary-600 transition duration-150">Cookies</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- Toast Notifications Container -->
    <div id="toast-container" class="fixed bottom-4 right-4 z-50 space-y-2"></div>

    <!-- AlpineJS -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Custom JS -->
    <script>
        // Function to show a toast notification
        window.showToast = function(message, type = 'info', duration = 5000) {
            const container = document.getElementById('toast-container');
            const toast = document.createElement('div');
            
            const typeClasses = {
                success: 'bg-green-500',
                error: 'bg-red-500',
                warning: 'bg-yellow-500',
                info: 'bg-blue-500'
            };

            const icons = {
                success: 'check-circle',
                error: 'x-circle',
                warning: 'alert-triangle',
                info: 'info'
            };
            
            const bgClass = typeClasses[type] || typeClasses.info;
            const icon = icons[type] || icons.info;
            
            toast.className = `${bgClass} text-white px-4 py-3 rounded-lg shadow-lg flex items-center transform transition-all duration-300 opacity-0 translate-y-2`;
            toast.innerHTML = `
                <div class="mr-3">
                    <i data-feather="${icon}" class="h-5 w-5"></i>
                </div>
                <p>${message}</p>
                <button class="ml-auto" onclick="this.parentElement.remove()">
                    <i data-feather="x" class="h-4 w-4"></i>
                </button>
            `;
            
            container.appendChild(toast);
            feather.replace();
            
            // Trigger animation after a short delay
            setTimeout(() => {
                toast.classList.remove('opacity-0', 'translate-y-2');
            }, 10);
            
            // Remove the toast after duration
            setTimeout(() => {
                toast.classList.add('opacity-0', 'translate-y-2');
                setTimeout(() => {
                    toast.remove();
                }, 300);
            }, duration);
        }
    </script>
</body>
</html> 