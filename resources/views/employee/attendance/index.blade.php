<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('My Attendance') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Clock In/Out Card -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="text-center">
                        <h3 class="text-2xl font-medium text-gray-900 mb-2">Today's Attendance</h3>
                        <p class="text-gray-600 mb-6">{{ now()->format('l, F j, Y') }}</p>
                        
                        <!-- Current Time -->
                        <div class="text-4xl font-bold text-blue-600 mb-8" id="currentTime">
                            {{ now()->format('g:i:s A') }}
                        </div>

                        @php
                            $todayAttendance = Auth::user()->employee->attendances()->where('date', today())->first();
                        @endphp

                        <!-- Clock In/Out Buttons -->
                        <div class="flex justify-center space-x-4 mb-8">
                            @if(!$todayAttendance || !$todayAttendance->time_in)
                                <form method="POST" action="{{ route('employee.attendance.clock-in') }}">
                                    @csrf
                                    <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-4 px-8 rounded-lg text-xl transition-colors">
                                        <svg class="w-6 h-6 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        Clock In
                                    </button>
                                </form>
                            @elseif(!$todayAttendance->time_out)
                                <form method="POST" action="{{ route('employee.attendance.clock-out') }}">
                                    @csrf
                                    <div class="text-center">
                                        <p class="text-sm text-gray-600 mb-4">
                                            Clocked in at: <span class="font-semibold">{{ \Carbon\Carbon::createFromFormat('H:i:s', $todayAttendance->time_in)->format('g:i A') }}</span>
                                        </p>
                                        <div class="mb-4">
                                            <label class="block text-sm font-medium text-gray-700 mb-2">Break Duration (hours)</label>
                                            <input type="number" name="break_duration" value="1" step="0.25" min="0" max="8" class="w-32 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        </div>
                                        <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-4 px-8 rounded-lg text-xl transition-colors">
                                            <svg class="w-6 h-6 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                            Clock Out
                                        </button>
                                    </div>
                                </form>
                            @else
                                <div class="text-center">
                                    <div class="bg-gray-100 p-6 rounded-lg">
                                        <h4 class="text-lg font-medium text-gray-900 mb-4">Today's Work Complete</h4>
                                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                                            <div>
                                                <p class="text-gray-600">Clock In</p>
                                                <p class="font-semibold">{{ \Carbon\Carbon::createFromFormat('H:i:s', $todayAttendance->time_in)->format('g:i A') }}</p>
                                            </div>
                                            <div>
                                                <p class="text-gray-600">Clock Out</p>
                                                <p class="font-semibold">{{ \Carbon\Carbon::createFromFormat('H:i:s', $todayAttendance->time_out)->format('g:i A') }}</p>
                                            </div>
                                            <div>
                                                <p class="text-gray-600">Total Hours</p>
                                                <p class="font-semibold">{{ $todayAttendance->total_hours ?? $todayAttendance->calculateTotalHours() }}h</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>

                        @if($todayAttendance)
                            <div class="text-center">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                                    {{ $todayAttendance->status === 'present' ? 'bg-green-100 text-green-800' : 
                                       ($todayAttendance->status === 'late' ? 'bg-yellow-100 text-yellow-800' : 
                                       ($todayAttendance->status === 'absent' ? 'bg-red-100 text-red-800' : 'bg-blue-100 text-blue-800')) }}">
                                    Status: {{ ucfirst(str_replace('_', ' ', $todayAttendance->status)) }}
                                </span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Weekly Summary -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">This Week's Summary</h3>
                    
                    @php
                        $weekStart = now()->startOfWeek();
                        $weekEnd = now()->endOfWeek();
                        $weekAttendances = Auth::user()->employee->attendances()
                            ->whereBetween('date', [$weekStart, $weekEnd])
                            ->get();
                        $totalHours = $weekAttendances->sum('total_hours');
                        $presentDays = $weekAttendances->where('status', '!=', 'absent')->count();
                        $lateDays = $weekAttendances->where('status', 'late')->count();
                    @endphp

                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                        <div class="text-center">
                            <div class="text-2xl font-bold text-blue-600">{{ $totalHours }}h</div>
                            <div class="text-sm text-gray-600">Total Hours</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-green-600">{{ $presentDays }}</div>
                            <div class="text-sm text-gray-600">Days Present</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-yellow-600">{{ $lateDays }}</div>
                            <div class="text-sm text-gray-600">Late Days</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-purple-600">{{ number_format($totalHours / max($presentDays, 1), 1) }}h</div>
                            <div class="text-sm text-gray-600">Avg Daily Hours</div>
                        </div>
                    </div>

                    <!-- Weekly Calendar View -->
                    <div class="grid grid-cols-7 gap-2">
                        @for($i = 0; $i < 7; $i++)
                            @php
                                $date = $weekStart->copy()->addDays($i);
                                $dayAttendance = $weekAttendances->where('date', $date->format('Y-m-d'))->first();
                            @endphp
                            <div class="text-center p-3 border rounded-lg {{ $date->isToday() ? 'bg-blue-50 border-blue-200' : 'bg-gray-50' }}">
                                <div class="text-xs font-medium text-gray-500">{{ $date->format('D') }}</div>
                                <div class="text-sm font-semibold">{{ $date->format('j') }}</div>
                                @if($dayAttendance)
                                    <div class="mt-1">
                                        <div class="w-3 h-3 mx-auto rounded-full 
                                            {{ $dayAttendance->status === 'present' ? 'bg-green-500' : 
                                               ($dayAttendance->status === 'late' ? 'bg-yellow-500' : 
                                               ($dayAttendance->status === 'absent' ? 'bg-red-500' : 'bg-blue-500')) }}">
                                        </div>
                                        @if($dayAttendance->total_hours)
                                            <div class="text-xs text-gray-600 mt-1">{{ $dayAttendance->total_hours }}h</div>
                                        @endif
                                    </div>
                                @elseif($date->isPast() && $date->isWeekday())
                                    <div class="mt-1">
                                        <div class="w-3 h-3 mx-auto rounded-full bg-gray-300"></div>
                                        <div class="text-xs text-gray-400 mt-1">N/A</div>
                                    </div>
                                @endif
                            </div>
                        @endfor
                    </div>
                </div>
            </div>

            <!-- Recent Attendance History -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Recent Attendance History</h3>
                    
                    @if($attendances->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Time In</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Time Out</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Hours</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Notes</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($attendances as $attendance)
                                        <tr class="{{ $attendance->date->isToday() ? 'bg-blue-50' : '' }}">
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                {{ $attendance->date->format('M d, Y') }}
                                                @if($attendance->date->isToday())
                                                    <span class="text-blue-600">(Today)</span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                {{ $attendance->time_in ? \Carbon\Carbon::createFromFormat('H:i:s', $attendance->time_in)->format('g:i A') : '-' }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                {{ $attendance->time_out ? \Carbon\Carbon::createFromFormat('H:i:s', $attendance->time_out)->format('g:i A') : '-' }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                {{ $attendance->total_hours ? $attendance->total_hours . 'h' : '-' }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                                    {{ $attendance->status === 'present' ? 'bg-green-100 text-green-800' : 
                                                       ($attendance->status === 'late' ? 'bg-yellow-100 text-yellow-800' : 
                                                       ($attendance->status === 'absent' ? 'bg-red-100 text-red-800' : 'bg-blue-100 text-blue-800')) }}">
                                                    {{ ucfirst(str_replace('_', ' ', $attendance->status)) }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 text-sm text-gray-500">
                                                {{ Str::limit($attendance->notes ?? '', 30) }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-6">
                            {{ $attendances->links() }}
                        </div>
                    @else
                        <div class="text-center py-8">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <h3 class="mt-4 text-lg font-medium text-gray-900">No attendance records yet</h3>
                            <p class="mt-2 text-gray-500">Your attendance history will appear here once you start clocking in.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
        // Update current time every second
        function updateTime() {
            const now = new Date();
            const timeString = now.toLocaleTimeString('en-US', {
                hour: 'numeric',
                minute: '2-digit',
                second: '2-digit',
                hour12: true
            });
            document.getElementById('currentTime').textContent = timeString;
        }

        // Update time immediately and then every second
        updateTime();
        setInterval(updateTime, 1000);
    </script>
</x-app-layout>