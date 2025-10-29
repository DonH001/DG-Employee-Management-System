<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Employee Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Welcome Message -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900">Welcome back, {{ $employee->full_name }}!</h3>
                    <p class="text-gray-600">{{ $employee->position->title ?? 'Employee' }} - ID: {{ $employee->employee_id }}</p>
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <svg class="h-8 w-8 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                </svg>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">Attendance This Month</dt>
                                    <dd class="text-lg font-medium text-gray-900">{{ $stats['total_attendance_this_month'] }}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <svg class="h-8 w-8 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">Hours This Month</dt>
                                    <dd class="text-lg font-medium text-gray-900">{{ number_format($stats['total_hours_this_month'], 1) }}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <svg class="h-8 w-8 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">Pending Leave Requests</dt>
                                    <dd class="text-lg font-medium text-gray-900">{{ $stats['pending_leave_requests'] }}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <svg class="h-8 w-8 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">Approved Upcoming Leaves</dt>
                                    <dd class="text-lg font-medium text-gray-900">{{ $stats['approved_leave_requests'] }}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Activities and Projects -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Recent Time Entries -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-medium text-gray-900">Recent Attendance</h3>
                            <a href="{{ route('employee.attendance.index') }}" class="text-blue-600 hover:text-blue-800 text-sm">View All</a>
                        </div>
                        <div class="space-y-4">
                            @forelse($recentAttendance as $attendance)
                                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                    <div>
                                        <p class="font-medium text-gray-900">{{ $attendance->date->format('M d, Y') }}</p>
                                        <p class="text-sm text-gray-500">
                                            @if($attendance->time_in && $attendance->time_out)
                                                {{ \Carbon\Carbon::createFromFormat('H:i:s', $attendance->time_in)->format('g:i A') }} - {{ \Carbon\Carbon::createFromFormat('H:i:s', $attendance->time_out)->format('g:i A') }}
                                                ({{ number_format($attendance->total_hours, 2) }} hours)
                                            @elseif($attendance->time_in)
                                                Clocked in at {{ \Carbon\Carbon::createFromFormat('H:i:s', $attendance->time_in)->format('g:i A') }}
                                            @else
                                                No time recorded
                                            @endif
                                        </p>
                                        @if($attendance->notes)
                                            <p class="text-xs text-gray-400">{{ Str::limit($attendance->notes, 50) }}</p>
                                        @endif
                                    </div>
                                    <div class="text-sm">
                                        <span class="px-2 py-1 rounded-full text-xs font-medium
                                            @if($attendance->status === 'present') bg-green-100 text-green-800
                                            @elseif($attendance->status === 'absent') bg-red-100 text-red-800
                                            @elseif($attendance->status === 'late') bg-yellow-100 text-yellow-800
                                            @else bg-blue-100 text-blue-800 @endif">
                                            {{ ucfirst($attendance->status) }}
                                        </span>
                                    </div>
                                </div>
                            @empty
                                <p class="text-gray-500 text-center py-4">No attendance records yet</p>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Active Projects -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-medium text-gray-900">Leave Requests</h3>
                            <a href="{{ route('employee.leave-requests.index') }}" class="text-blue-600 hover:text-blue-800 text-sm">View All</a>
                        </div>
                        <div class="space-y-4">
                            @forelse($recentLeaveRequests as $request)
                                <div class="p-3 bg-blue-50 rounded-lg">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <p class="font-medium text-gray-900">{{ ucfirst($request->leave_type) }} Leave</p>
                                            <p class="text-sm text-gray-500">
                                                {{ $request->start_date->format('M d, Y') }} - {{ $request->end_date->format('M d, Y') }}
                                            </p>
                                        </div>
                                        <div class="text-right text-sm">
                                            <p class="text-gray-600">
                                                {{ \Carbon\Carbon::parse($request->start_date)->diffInDays(\Carbon\Carbon::parse($request->end_date)) + 1 }} days
                                            </p>
                                            <span class="px-2 py-1 rounded-full text-xs font-medium
                                                @if($request->status === 'approved') bg-green-100 text-green-800
                                                @elseif($request->status === 'rejected') bg-red-100 text-red-800
                                                @else bg-yellow-100 text-yellow-800 @endif">
                                                {{ ucfirst($request->status) }}
                                            </span>
                                        </div>
                                    </div>
                                    @if($request->reason)
                                        <p class="text-xs text-gray-400 mt-2">{{ Str::limit($request->reason, 100) }}</p>
                                    @endif
                                </div>
                            @empty
                                <p class="text-gray-500 text-center py-4">No leave requests found</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="mt-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Quick Actions</h3>
                        <div class="flex flex-wrap gap-4">
                            <a href="{{ route('employee.attendance.index') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                My Attendance
                            </a>
                            <a href="{{ route('employee.leave-requests.create') }}" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 active:bg-green-900 focus:outline-none focus:border-green-900 focus:ring ring-green-300 disabled:opacity-25 transition ease-in-out duration-150">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                Request Leave
                            </a>
                            <a href="{{ route('profile.edit') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                Update Profile
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>