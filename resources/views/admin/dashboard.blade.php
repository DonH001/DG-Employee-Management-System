<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>{{ config('app.name', 'DG Computer EMS') }}</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net" crossorigin>
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600&display=swap" rel="stylesheet" />
    
    <!-- Scripts -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
</head>
<body class="font-sans antialiased bg-gradient-to-br from-blue-600 to-blue-800 min-h-screen">
    @include('layouts.navigation')
    
    <!-- Full Width Blue Background Dashboard -->
    <div class="py-8">
        <!-- Header Section -->
        <div class="px-6 pb-8">
            <div class="max-w-7xl mx-auto flex justify-between items-center">
                <div>
                    <h2 class="text-3xl font-bold text-white mb-2">
                        Admin Dashboard
                    </h2>
                    <p class="text-blue-100">
                        Welcome back, {{ auth()->user()->name }} • {{ now()->format('l, F j, Y') }}
                    </p>
                </div>
                <div class="text-right">
                    <div class="text-white text-2xl font-bold">{{ now()->format('g:i A') }}</div>
                    <div class="text-blue-200 text-sm">{{ now()->format('T') }}</div>
                </div>
            </div>
        </div>
        
        <!-- Content Section -->
        <div class="px-6">
            <div class="max-w-7xl mx-auto">
            <!-- Enhanced Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <!-- Total Employees Card -->
                <div class="card p-0 overflow-hidden group hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                    <div class="bg-gradient-to-br from-blue-500 to-blue-600 p-1">
                        <div class="bg-white p-6 rounded-lg">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-semibold text-gray-600 uppercase tracking-wide">Total Employees</p>
                                    <p class="text-3xl font-bold text-gray-900 mt-2">{{ $stats['total_employees'] ?? 0 }}</p>
                                    <div class="flex items-center mt-2">
                                        <span class="text-xs font-medium text-green-600 bg-green-100 px-2 py-1 rounded-full">
                                            +{{ $stats['new_hires_this_month'] ?? 0 }} this month
                                        </span>
                                    </div>
                                </div>
                                <div class="w-16 h-16 bg-blue-100 rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Attendance Today Card -->
                <div class="card p-0 overflow-hidden group hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                    <div class="bg-gradient-to-br from-green-500 to-green-600 p-1">
                        <div class="bg-white p-6 rounded-lg">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-semibold text-gray-600 uppercase tracking-wide">Present Today</p>
                                    <p class="text-3xl font-bold text-gray-900 mt-2">{{ ($stats['present_today'] ?? 0) + ($stats['late_today'] ?? 0) }}</p>
                                    <div class="flex items-center mt-2 space-x-2">
                                        <span class="text-xs font-medium text-green-600 bg-green-100 px-2 py-1 rounded-full">
                                            {{ $stats['present_today'] ?? 0 }} On time
                                        </span>
                                        @if(($stats['late_today'] ?? 0) > 0)
                                            <span class="text-xs font-medium text-yellow-600 bg-yellow-100 px-2 py-1 rounded-full">
                                                {{ $stats['late_today'] ?? 0 }} Late
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="w-16 h-16 bg-green-100 rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                                    <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Leave Requests Card -->
                <div class="card p-0 overflow-hidden group hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                    <div class="bg-gradient-to-br from-purple-500 to-purple-600 p-1">
                        <div class="bg-white p-6 rounded-lg">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-semibold text-gray-600 uppercase tracking-wide">Leave Requests</p>
                                    <p class="text-3xl font-bold text-gray-900 mt-2">{{ $stats['total_this_year'] ?? 0 }}</p>
                                    <div class="flex items-center mt-2">
                                        <span class="text-xs font-medium text-orange-600 bg-orange-100 px-2 py-1 rounded-full">
                                            {{ $stats['pending_requests'] ?? 0 }} Pending
                                        </span>
                                    </div>
                                </div>
                                <div class="w-16 h-16 bg-purple-100 rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                                    <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- System Health Card -->
                <div class="card p-0 overflow-hidden group hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                    <div class="bg-gradient-to-br from-indigo-500 to-indigo-600 p-1">
                        <div class="bg-white p-6 rounded-lg">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-semibold text-gray-600 uppercase tracking-wide">System Health</p>
                                    <p class="text-3xl font-bold text-green-600 mt-2">99.9%</p>
                                    <div class="flex items-center mt-2">
                                        <span class="text-xs font-medium text-green-600 bg-green-100 px-2 py-1 rounded-full">
                                            All systems operational
                                        </span>
                                    </div>
                                </div>
                                <div class="w-16 h-16 bg-indigo-100 rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                                    <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Enhanced Content Cards -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Recent Employees -->
                <div class="lg:col-span-2">
                    <div class="card overflow-hidden">
                        <div class="bg-gradient-to-r from-blue-50 to-indigo-50 px-6 py-5 border-b border-gray-200">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h3 class="text-xl font-bold text-gray-900">Recent Employees</h3>
                                    <p class="text-sm text-gray-600 mt-1">Latest team members who joined</p>
                                </div>
                                <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                        <div class="p-6">
                            <div class="space-y-4">
                                @forelse($recentEmployees as $employee)
                                    <div class="flex items-center p-4 bg-gray-50 rounded-xl hover:bg-gray-100 transition-colors duration-200">
                                        <div class="w-12 h-12 bg-gradient-to-br from-blue-400 to-blue-600 rounded-xl flex items-center justify-center text-white font-semibold">
                                            {{ strtoupper(substr($employee->first_name, 0, 1) . substr($employee->last_name, 0, 1)) }}
                                        </div>
                                        <div class="ml-4 flex-1">
                                            <p class="font-semibold text-gray-900">{{ $employee->full_name }}</p>
                                            <p class="text-sm text-gray-600">{{ $employee->position->title ?? 'Position not set' }}</p>
                                        </div>
                                        <div class="text-right">
                                            <div class="flex items-center space-x-2 mb-1">
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                    {{ $employee->employee_id }}
                                                </span>
                                            </div>
                                            <p class="text-xs text-gray-500">{{ $employee->hire_date ? $employee->hire_date->format('M d, Y') : 'Not set' }}</p>
                                        </div>
                                    </div>
                                @empty
                                    <div class="text-center py-12">
                                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                                        </svg>
                                        <h3 class="mt-2 text-sm font-medium text-gray-900">No employees found</h3>
                                        <p class="mt-1 text-sm text-gray-500">Get started by adding new team members.</p>
                                    </div>
                                @endforelse
                            </div>
                            
                            <div class="mt-6 pt-4 border-t border-gray-200">
                                <a href="{{ route('admin.employees.index') }}" class="btn btn-secondary w-full">
                                    View All Employees
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Today's Attendance & Quick Actions -->
                <div class="space-y-8">
                    <!-- Today's Attendance -->
                    <div class="card overflow-hidden">
                        <div class="bg-gradient-to-r from-green-50 to-emerald-50 px-6 py-5 border-b border-gray-200">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h3 class="text-lg font-bold text-gray-900">Today's Attendance</h3>
                                    <p class="text-sm text-gray-600 mt-1">Current status</p>
                                </div>
                                <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                        <div class="p-6">
                            <div class="space-y-3">
                                @forelse($attendanceStats as $attendance)
                                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                        <div class="flex items-center">
                                            <div class="w-8 h-8 bg-gradient-to-br from-green-400 to-green-600 rounded-lg flex items-center justify-center text-white text-xs font-semibold">
                                                {{ strtoupper(substr($attendance->employee->user->name, 0, 2)) }}
                                            </div>
                                            <div class="ml-3">
                                                <p class="text-sm font-medium text-gray-900">{{ $attendance->employee->user->name }}</p>
                                                <p class="text-xs text-gray-500">{{ $attendance->employee->employee_id }}</p>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            @if($attendance->time_in)
                                                <span class="inline-flex items-center px-2 py-1 rounded-md text-xs font-medium bg-green-100 text-green-800 mb-1">
                                                    In: {{ \Carbon\Carbon::createFromFormat('H:i:s', $attendance->time_in)->format('g:i A') }}
                                                </span>
                                            @endif
                                            @if($attendance->time_out)
                                                <span class="inline-flex items-center px-2 py-1 rounded-md text-xs font-medium bg-blue-100 text-blue-800">
                                                    Out: {{ \Carbon\Carbon::createFromFormat('H:i:s', $attendance->time_out)->format('g:i A') }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                @empty
                                    <div class="text-center py-8">
                                        <svg class="mx-auto h-8 w-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        <p class="mt-2 text-sm text-gray-500">No attendance today</p>
                                    </div>
                                @endforelse
                            </div>
                            
                            <div class="mt-4 pt-4 border-t border-gray-200">
                                <a href="{{ route('admin.attendance.index') }}" class="btn btn-secondary w-full">
                                    Manage Attendance
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="card overflow-hidden">
                        <div class="bg-gradient-to-r from-purple-50 to-pink-50 px-6 py-5 border-b border-gray-200">
                            <h3 class="text-lg font-bold text-gray-900">Quick Actions</h3>
                            <p class="text-sm text-gray-600 mt-1">Common tasks</p>
                        </div>
                        <div class="p-6 space-y-3">
                            <a href="{{ route('admin.employees.create') }}" class="btn btn-primary w-full">
                                Add New Employee
                            </a>
                            <a href="{{ route('admin.leave-requests.index') }}" class="btn btn-secondary w-full">
                                Review Leave Requests
                            </a>
                            <a href="{{ route('admin.reports.index') }}" class="btn btn-secondary w-full">
                                Generate Reports
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>