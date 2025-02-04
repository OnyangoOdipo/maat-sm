<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Dashboard') - {{ config('app.name') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased" x-data="{ isSidebarOpen: false }">
    <div class="min-h-screen bg-gray-100">
        <!-- Sidebar -->
        <aside class="fixed inset-y-0 left-0 bg-white shadow-lg max-h-screen w-64 hidden md:block">
            <div class="flex flex-col h-full">
                <!-- Logo -->
                <div class="flex items-center justify-center h-16 bg-gray-900">
                    <span class="text-white text-lg font-bold">{{ config('app.name') }}</span>
                </div>

                <!-- Sidebar Navigation -->
                <nav class="flex-1 overflow-y-auto py-4 text-sm">
                    <!-- Academic Section -->
                    <div x-data="{ open: true }" class="px-3">
                        <button @click="open = !open" class="flex items-center justify-between w-full px-4 py-2 text-gray-600 hover:bg-gray-100 rounded-lg">
                            <div class="flex items-center">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                </svg>
                                <span class="ml-3">Academic</span>
                            </div>
                            <svg class="w-4 h-4 transition-transform" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>

                        <!-- Academic Dropdown -->
                        <div x-show="open" class="mt-2 space-y-1 px-3">
                            <a href="{{ route('classes.index') }}" class="flex items-center px-4 py-2 text-gray-600 hover:bg-gray-100 rounded-lg {{ request()->routeIs('students.*') ? 'bg-gray-100' : '' }}">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                                <span class="ml-3">Classes</span>
                            </a>

                            <a href="{{ route('subjects.index') }}" class="flex items-center px-4 py-2 text-gray-600 hover:bg-gray-100 rounded-lg">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                </svg>
                                <span class="ml-3">Subjects</span>
                            </a>

                            <a href="{{ route('teachers.index') }}" class="flex items-center px-4 py-2 text-gray-600 hover:bg-gray-100 rounded-lg">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                <span class="ml-3">Teachers</span>
                            </a>

                            <a href="{{ route('students.index') }}" class="flex items-center px-4 py-2 text-gray-600 hover:bg-gray-100 rounded-lg">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                </svg>
                                <span class="ml-3">Students</span>
                            </a>
                        </div>
                    </div>

                    <!-- Educational Settings Section -->
                    <div x-data="{ open: true }" class="px-3 mt-4">
                        <button @click="open = !open" class="flex items-center justify-between w-full px-4 py-2 text-gray-600 hover:bg-gray-100 rounded-lg">
                            <div class="flex items-center">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                </svg>
                                <span class="ml-3">Educational Settings</span>
                            </div>
                            <svg class="w-4 h-4 transition-transform" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>

                        <!-- Educational Settings Dropdown -->
                        <div x-show="open" class="mt-2 space-y-1 px-3">
                            <!-- Day Section -->
                            <div x-data="{ open: false }" class="space-y-1">
                                <button @click="open = !open" class="bg-gray-100 hover:bg-gray-200 w-full text-left px-4 py-2 text-sm font-medium text-gray-900 rounded-md focus:outline-none">
                                    {{ __('Day Section') }}
                                    <svg class="float-right h-5 w-5" x-bind:class="{ 'transform rotate-180': open }" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </button>
                                
                                <div x-show="open" class="pl-4 space-y-1">
                                    <!-- Transport Management Section -->
                                    <div x-data="{ transportOpen: false }" class="space-y-1">
                                        <button @click="transportOpen = !transportOpen" class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 focus:outline-none">
                                            {{ __('Transport Management') }}
                                            <svg class="float-right h-4 w-4" x-bind:class="{ 'transform rotate-180': transportOpen }" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                            </svg>
                                        </button>
                                        
                                        <div x-show="transportOpen" class="pl-4 space-y-1">
                                            <a href="{{ route('transport.vehicles.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                                {{ __('Vehicles') }}
                                            </a>
                                            <a href="{{ route('transport.drivers.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                                {{ __('Drivers') }}
                                            </a>
                                            <a href="{{ route('transport.routes.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                                {{ __('Routes') }}
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Boarding Section -->
                            <div x-data="{ boardingOpen: false }" class="space-y-1">
                                <button @click="boardingOpen = !boardingOpen" class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 focus:outline-none">
                                    {{ __('Boarding Management') }}
                                    <svg class="float-right h-4 w-4" x-bind:class="{ 'transform rotate-180': boardingOpen }" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </button>
                                
                                <div x-show="boardingOpen" class="pl-4 space-y-1">
                                    <a href="{{ route('boarding.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        {{ __('Houses Overview') }}
                                    </a>
                                    <a href="{{ route('boarding.cubicles.create') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        {{ __('Cubicles') }}
                                    </a>
                                    <a href="{{ route('boarding.assignments.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        {{ __('Bed Assignments') }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Examination & Timetabling Section -->
                    <div x-data="{ open: false }" class="px-3 mt-4">
                        <button @click="open = !open" class="flex items-center justify-between w-full px-4 py-2 text-gray-600 hover:bg-gray-100 rounded-lg">
                            <div class="flex items-center">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                </svg>
                                <span class="ml-3">Examination & Timetabling</span>
                            </div>
                            <svg class="w-4 h-4 transition-transform" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>

                        <div x-show="open" class="mt-2 space-y-1 px-3">
                            <!-- Examination Section -->
                            <div x-data="{ examOpen: false }" class="space-y-1">
                                <button @click="examOpen = !examOpen" class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 focus:outline-none">
                                    {{ __('Examination') }}
                                    <svg class="float-right h-4 w-4" x-bind:class="{ 'transform rotate-180': examOpen }" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </button>
                                
                                <div x-show="examOpen" class="pl-4 space-y-1">
                                    <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">{{ __('Exam List') }}</a>
                                    <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">{{ __('Exam Types') }}</a>
                                    <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">{{ __('Exam Schedule') }}</a>
                                    <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">{{ __('Results') }}</a>
                                </div>
                            </div>

                            <!-- Timetabling Section -->
                            <div x-data="{ timetableOpen: false }" class="space-y-1">
                                <button @click="timetableOpen = !timetableOpen" class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 focus:outline-none">
                                    {{ __('Timetabling') }}
                                    <svg class="float-right h-4 w-4" x-bind:class="{ 'transform rotate-180': timetableOpen }" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </button>
                                
                                <div x-show="timetableOpen" class="pl-4 space-y-1">
                                    <a href="{{ route('timeslots.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">{{ __('Time Slots') }}</a>
                                    <a href="{{ route('timetables.create') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">{{ __('Generate Timetable') }}</a>
                                    <a href="{{ route('timetables.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">{{ __('View Timetables') }}</a>
                                    <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">{{ __('Constraints') }}</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Roles & Permissions Section -->
                    <div x-data="{ open: true }" class="px-3 mt-4">
                        <button @click="open = !open" class="flex items-center justify-between w-full px-4 py-2 text-gray-600 hover:bg-gray-100 rounded-lg">
                            <div class="flex items-center">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                </svg>
                                <span class="ml-3">Roles & Permissions</span>
                            </div>
                            <svg class="w-4 h-4 transition-transform" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>

                        <!-- Roles & Permissions Dropdown -->
                        <div x-show="open" class="mt-2 space-y-1 px-3">
                            <a href="{{ route('roles.permissions') }}" class="flex items-center px-4 py-2 text-gray-600 hover:bg-gray-100 rounded-lg">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                </svg>
                                <span class="ml-3">Roles & Permissions</span>
                            </a>              
                            @can('manage_users') <!-- Example of using Laravel's Authorization - Permissions -->              
                            <a href="{{ route('assign.permissions') }}" class="flex items-center px-4 py-2 text-gray-600 hover:bg-gray-100 rounded-lg">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                </svg>
                                <span class="ml-3">Assign Permissions</span>
                            </a>
                            @endcan
                        </div>
                    </div>
                </nav>

                <!-- User Profile -->
                <div class="p-4 border-t">
                    <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <img class="h-8 w-8 rounded-full" src="https://ui-avatars.com/api/?name={{ auth()->user()->name }}" alt="{{ auth()->user()->name }}">
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-gray-700">{{ auth()->user()->name }}</p>
                            <p class="text-xs text-gray-500">School Admin</p>
                        </div>
                        </div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="text-sm text-red-600 hover:text-red-800">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </aside>

        <!-- Mobile Sidebar Toggle -->
        <div class="fixed inset-0 z-20 transition-opacity bg-black opacity-50 lg:hidden" 
             x-show="isSidebarOpen" 
             x-transition:enter="transition ease-out duration-200" 
             x-transition:enter-start="opacity-0" 
             x-transition:enter-end="opacity-50"
             x-transition:leave="transition ease-in duration-200" 
             x-transition:leave-start="opacity-50" 
             x-transition:leave-end="opacity-0"
             style="display: none;"
             @click="isSidebarOpen = false">
        </div>

        <!-- Main Content -->
        <div class="md:pl-64">
            <!-- Top Navigation -->
            <nav class="bg-white shadow-sm">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16 items-center">
                        <h1 class="text-lg font-semibold text-gray-900">@yield('title', 'Dashboard')</h1>
                    </div>
                </div>
            </nav>

            <!-- Page Content -->
            <main class="py-6">
                @yield('content')
            </main>
        </div>
    </div>

    @stack('scripts')
    <script src="/js/preline.js"></script>
    <script src="/js/Sortable.min.js"></script>
    <script src="/js/jquery.min.js"></script>
    <script src="/js/dataTables.min.js"></script>
</body>
</html>