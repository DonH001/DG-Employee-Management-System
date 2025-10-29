<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Welcome Section -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-8">
                <div class="p-6 bg-gradient-to-r from-blue-500 to-blue-600 text-white">
                    <div class="flex justify-between items-center">
                        <div>
                            <h2 class="text-2xl font-bold mb-1">Welcome back, {{ auth()->user()->name }}!</h2>
                            <p class="text-blue-100">{{ now()->format('l, F j, Y') }}</p>
                        </div>
                        <div class="text-right">
                            <div class="text-2xl font-bold">{{ now()->format('g:i A') }}</div>
                            <div class="text-blue-200 text-sm">{{ now()->format('T') }}</div>
                        </div>
                    </div>
                </div>
            </div>
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
</x-app-layout>