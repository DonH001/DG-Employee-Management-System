<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Employee Details') }}
            </h2>
            <div class="space-x-2">
                <a href="{{ route('admin.employees.edit', $employee) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Edit Employee
                </a>
                <a href="{{ route('admin.employees.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Back to List
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Employee Information Card -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex items-center space-x-6 mb-6">
                        <div class="w-24 h-24 bg-gray-300 rounded-full flex items-center justify-center">
                            <span class="text-2xl font-bold text-gray-600">
                                {{ strtoupper(substr($employee->user->name, 0, 2)) }}
                            </span>
                        </div>
                        <div>
                            <h3 class="text-2xl font-bold text-gray-900">{{ $employee->user->name }}</h3>
                            <p class="text-gray-600">{{ $employee->position->title ?? 'No Position' }}</p>
                            <p class="text-gray-600">{{ $employee->department->name ?? 'No Department' }}</p>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                {{ $employee->status === 'active' ? 'bg-green-100 text-green-800' : 
                                   ($employee->status === 'inactive' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                {{ ucfirst($employee->status) }}
                            </span>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <!-- Personal Information -->
                        <div class="bg-gray-50 p-6 rounded-lg">
                            <h4 class="text-lg font-medium text-gray-900 mb-4">Personal Information</h4>
                            <dl class="space-y-3">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Full Name</dt>
                                    <dd class="text-sm text-gray-900">{{ $employee->first_name }} {{ $employee->last_name }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Email</dt>
                                    <dd class="text-sm text-gray-900">{{ $employee->user->email }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Phone</dt>
                                    <dd class="text-sm text-gray-900">{{ $employee->phone_number ?? 'Not provided' }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Date of Birth</dt>
                                    <dd class="text-sm text-gray-900">{{ $employee->date_of_birth ? $employee->date_of_birth->format('M d, Y') : 'Not provided' }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Gender</dt>
                                    <dd class="text-sm text-gray-900">{{ $employee->gender ? ucfirst($employee->gender) : 'Not specified' }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Address</dt>
                                    <dd class="text-sm text-gray-900">{{ $employee->address ?? 'Not provided' }}</dd>
                                </div>
                            </dl>
                        </div>

                        <!-- Employment Information -->
                        <div class="bg-gray-50 p-6 rounded-lg">
                            <h4 class="text-lg font-medium text-gray-900 mb-4">Employment Information</h4>
                            <dl class="space-y-3">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Employee ID</dt>
                                    <dd class="text-sm text-gray-900">{{ $employee->employee_id }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Department</dt>
                                    <dd class="text-sm text-gray-900">{{ $employee->department->name ?? 'Not assigned' }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Position</dt>
                                    <dd class="text-sm text-gray-900">{{ $employee->position->title ?? 'Not assigned' }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Manager</dt>
                                    <dd class="text-sm text-gray-900">{{ $employee->manager->user->name ?? 'No manager assigned' }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Hire Date</dt>
                                    <dd class="text-sm text-gray-900">{{ $employee->hire_date->format('M d, Y') }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Employment Type</dt>
                                    <dd class="text-sm text-gray-900">{{ ucwords(str_replace('_', ' ', $employee->employment_type)) }}</dd>
                                </div>
                                @if($employee->salary)
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Salary</dt>
                                    <dd class="text-sm text-gray-900">${{ number_format($employee->salary, 2) }}</dd>
                                </div>
                                @endif
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h4 class="text-lg font-medium text-gray-900 mb-4">Recent Activity</h4>
                    
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                        <!-- Recent Time Entries -->
                        <div>
                            <h5 class="font-medium text-gray-700 mb-2">Recent Time Entries</h5>
                            @if($employee->timeEntries->count() > 0)
                                <div class="space-y-2">
                                    @foreach($employee->timeEntries->take(5) as $entry)
                                        <div class="bg-gray-50 p-3 rounded">
                                            <p class="text-sm font-medium">{{ $entry->project->name ?? 'No Project' }}</p>
                                            <p class="text-xs text-gray-500">{{ $entry->date->format('M d') }} - {{ $entry->hours_worked }}h</p>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-sm text-gray-500">No time entries recorded</p>
                            @endif
                        </div>

                        <!-- Current Projects -->
                        <div>
                            <h5 class="font-medium text-gray-700 mb-2">Current Projects</h5>
                            @if($employee->projectAssignments->where('status', 'active')->count() > 0)
                                <div class="space-y-2">
                                    @foreach($employee->projectAssignments->where('status', 'active')->take(5) as $assignment)
                                        <div class="bg-gray-50 p-3 rounded">
                                            <p class="text-sm font-medium">{{ $assignment->project->name }}</p>
                                            <p class="text-xs text-gray-500">{{ $assignment->role ?? 'Team Member' }}</p>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-sm text-gray-500">No active project assignments</p>
                            @endif
                        </div>

                        <!-- Leave Requests -->
                        <div>
                            <h5 class="font-medium text-gray-700 mb-2">Recent Leave Requests</h5>
                            @if($employee->leaveRequests->count() > 0)
                                <div class="space-y-2">
                                    @foreach($employee->leaveRequests->take(5) as $leave)
                                        <div class="bg-gray-50 p-3 rounded">
                                            <p class="text-sm font-medium">{{ ucfirst($leave->leave_type) }}</p>
                                            <p class="text-xs text-gray-500">
                                                {{ $leave->start_date->format('M d') }} - {{ $leave->end_date->format('M d') }}
                                                <span class="ml-2 px-1.5 py-0.5 text-xs rounded 
                                                    {{ $leave->status === 'approved' ? 'bg-green-100 text-green-800' : 
                                                       ($leave->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                                    {{ ucfirst($leave->status) }}
                                                </span>
                                            </p>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-sm text-gray-500">No leave requests</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>