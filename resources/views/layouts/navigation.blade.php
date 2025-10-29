<nav x-data="{ open: false }" class="bg-white border-b border-gray-200 shadow-sm">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <div class="flex items-center space-x-8">
                <!-- Enhanced Logo -->
                <div class="shrink-0">
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center group transition-all duration-200 hover:scale-105">
                        <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg flex items-center justify-center shadow-md group-hover:shadow-xl group-hover:from-blue-600 group-hover:to-blue-700 transition-all duration-200">
                        </div>
                        <div class="ml-3 hidden sm:block">
                            <div class="text-lg font-bold text-gray-900 group-hover:text-blue-600 transition-colors duration-200">DG Computer</div>
                            <div class="text-xs text-blue-600 font-medium -mt-1 group-hover:text-blue-700 transition-colors duration-200">EMS</div>
                        </div>
                    </a>
                </div>

                <!-- Enhanced Navigation Links -->
                <div class="hidden md:flex md:space-x-2">
                    @auth
                        @if(auth()->user()->canManageEmployees())
                            <a href="{{ route('admin.dashboard') }}" class="nav-link-compact {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                                Dashboard
                            </a>
                            <a href="{{ route('admin.employees.index') }}" class="nav-link-compact {{ request()->routeIs('admin.employees.*') ? 'active' : '' }}">
                                Employees
                            </a>
                            <a href="{{ route('admin.attendance.index') }}" class="nav-link-compact {{ request()->routeIs('admin.attendance.*') ? 'active' : '' }}">
                                Attendance
                            </a>
                            <a href="{{ route('admin.leave-requests.index') }}" class="nav-link-compact {{ request()->routeIs('admin.leave-requests.*') ? 'active' : '' }}">
                                Leave Requests
                            </a>
                            <a href="{{ route('admin.reports.index') }}" class="nav-link-compact {{ request()->routeIs('admin.reports.*') ? 'active' : '' }}">
                                Reports
                            </a>
                        @elseif(auth()->user()->isEmployee())
                            <a href="{{ route('employee.dashboard') }}" class="nav-link {{ request()->routeIs('employee.dashboard') ? 'active' : '' }}">
                                Dashboard
                            </a>
                            <a href="{{ route('employee.attendance.index') }}" class="nav-link {{ request()->routeIs('employee.attendance.*') ? 'active' : '' }}">
                                My Attendance
                            </a>
                            <a href="{{ route('employee.leave-requests.index') }}" class="nav-link {{ request()->routeIs('employee.leave-requests.*') ? 'active' : '' }}">
                                Leave Requests
                            </a>
                        @endif
                    @endauth
                </div>
            </div>

            <!-- Enhanced User Dropdown -->
            @auth
                <div class="hidden sm:flex sm:items-center sm:ml-6">


                    <x-dropdown align="right" width="56">
                        <x-slot name="trigger">
                            <button class="flex items-center px-4 py-2 bg-gray-50 hover:bg-blue-50 rounded-lg transition-all duration-200 hover:shadow-lg hover:scale-102 group">
                                <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg flex items-center justify-center text-white font-semibold text-sm mr-3 group-hover:from-blue-600 group-hover:to-blue-700 group-hover:shadow-md transition-all duration-200">
                                    {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                                </div>
                                <div class="text-left">
                                    <div class="text-sm font-semibold text-gray-900 group-hover:text-blue-700 transition-colors duration-200">{{ Auth::user()->name }}</div>
                                    <div class="text-xs text-gray-500 group-hover:text-blue-600 transition-colors duration-200">
                                        @if(auth()->user()->canManageEmployees())
                                            Administrator
                                        @elseif(auth()->user()->isEmployee())
                                            Employee
                                        @else
                                            User
                                        @endif
                                    </div>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <div class="px-4 py-3 border-b border-gray-100">
                                <div class="font-semibold text-gray-900">{{ Auth::user()->name }}</div>
                                <div class="text-sm text-gray-500">{{ Auth::user()->email }}</div>
                            </div>
                            
                            <div class="py-2">
                                <x-dropdown-link :href="route('profile.edit')" class="flex items-center">
                                    Profile Settings
                                </x-dropdown-link>
                                
                                <div class="border-t border-gray-100 my-2"></div>
                                
                                <!-- Authentication -->
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <x-dropdown-link :href="route('logout')" class="flex items-center text-red-600 hover:bg-red-50"
                                            onclick="event.preventDefault(); this.closest('form').submit();">
                                        Sign Out
                                    </x-dropdown-link>
                                </form>
                            </div>
                        </x-slot>
                    </x-dropdown>
                </div>
            @endauth

            <!-- Hamburger -->
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            @auth
                @if(auth()->user()->canManageEmployees())
                    <x-responsive-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
                        {{ __('Dashboard') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('admin.employees.index')" :active="request()->routeIs('admin.employees.*')">
                        {{ __('Employees') }}
                    </x-responsive-nav-link>
                @elseif(auth()->user()->isEmployee())
                    <x-responsive-nav-link :href="route('employee.dashboard')" :active="request()->routeIs('employee.dashboard')">
                        {{ __('Dashboard') }}
                    </x-responsive-nav-link>
                @endif
            @endauth
        </div>

        <!-- Responsive Settings Options -->
        @auth
            <div class="pt-4 pb-1 border-t border-gray-200">
                <div class="px-4">
                    <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                </div>

                <div class="mt-3 space-y-1">
                    <x-responsive-nav-link :href="route('profile.edit')">
                        {{ __('Profile') }}
                    </x-responsive-nav-link>

                    <!-- Authentication -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-responsive-nav-link :href="route('logout')"
                                onclick="event.preventDefault();
                                            this.closest('form').submit();">
                            {{ __('Log Out') }}
                        </x-responsive-nav-link>
                    </form>
                </div>
            </div>
        @endauth
    </div>
</nav>