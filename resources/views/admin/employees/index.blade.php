<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Employees') }}
            </h2>
            <a href="{{ route('admin.employees.create') }}" class="btn btn-primary">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Add Employee
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Employee Search & Filter Panel -->
            <div class="bg-white shadow-sm border border-gray-200 rounded-lg mb-6 overflow-hidden">
                <form method="GET" action="{{ route('admin.employees.index') }}">
                    <!-- Filter Header -->
                    <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-6 py-4 border-b border-gray-200">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <div class="p-2 bg-blue-100 rounded-lg">
                                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900">Filter Employees</h3>
                                    <p class="text-sm text-gray-500">Search and filter employee records</p>
                                </div>
                            </div>
                            
                            @if(request()->hasAny(['search', 'department', 'status']))
                                <div class="flex items-center space-x-4">
                                    <div class="text-sm text-gray-600">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                            {{ $employees->total() }} {{ $employees->total() == 1 ? 'result' : 'results' }}
                                        </span>
                                        @if(request('search'))
                                            <span class="ml-2 text-gray-500">for</span>
                                            <span class="ml-1 font-medium text-gray-900">"{{ request('search') }}"</span>
                                        @endif
                                    </div>
                                    <a href="{{ route('admin.employees.index') }}" 
                                       class="inline-flex items-center text-sm text-gray-500 hover:text-gray-700">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                        </svg>
                                        Clear all
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                    
                    <!-- Filter Controls -->
                    <div class="p-6">
                        <!-- Mobile-Optimized Filter Layout -->
                        <div class="space-y-4 lg:space-y-0">
                            <!-- Mobile: Stack all filters vertically -->
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-12 gap-4 lg:items-end">
                                <!-- Search Input -->
                                <div class="md:col-span-2 lg:col-span-5">
                                    <label for="search" class="block text-sm font-medium text-gray-700 mb-2">
                                        Search Employees
                                    </label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                            </svg>
                                        </div>
                                        <input type="text" 
                                               name="search" 
                                               id="search" 
                                               value="{{ request('search') }}"
                                               class="block w-full pl-10 pr-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200"
                                               placeholder="Search by name, email, or employee ID...">
                                    </div>
                                </div>
                                
                                <!-- Department Filter -->
                                <div class="lg:col-span-3">
                                    <label for="department" class="block text-sm font-medium text-gray-700 mb-2">
                                        Department
                                    </label>
                                    <div class="relative">
                                        <select name="department" 
                                                id="department" 
                                                class="block w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 bg-white">
                                            <option value="">All Departments</option>
                                            @foreach($departments as $department)
                                                <option value="{{ $department->id }}" {{ request('department') == $department->id ? 'selected' : '' }}>
                                                    {{ $department->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <div class="absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none">
                                            <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Status Filter -->
                                <div class="lg:col-span-2">
                                    <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                                        Status
                                    </label>
                                    <div class="relative">
                                        <select name="status" 
                                                id="status" 
                                                class="block w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 bg-white">
                                            <option value="">All Status</option>
                                            <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                                            <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                            <option value="terminated" {{ request('status') == 'terminated' ? 'selected' : '' }}>Terminated</option>
                                            <option value="on_leave" {{ request('status') == 'on_leave' ? 'selected' : '' }}>On Leave</option>
                                        </select>
                                        <div class="absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none">
                                            <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Action Buttons - Mobile Full Width, Desktop Split -->
                                <div class="md:col-span-2 lg:col-span-2">
                                    <div class="flex flex-col sm:flex-row space-y-2 sm:space-y-0 sm:space-x-2">
                                        <button type="submit" 
                                                class="flex-1 inline-flex justify-center items-center px-4 py-2.5 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors duration-200">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                            </svg>
                                            <span class="sm:hidden">Apply Filters</span>
                                            <span class="hidden sm:inline">Filter</span>
                                        </button>
                                        @if(request()->hasAny(['search', 'department', 'status']))
                                            <a href="{{ route('admin.employees.index') }}" 
                                               class="flex-1 sm:flex-none inline-flex justify-center items-center px-3 py-2.5 border border-gray-300 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-50 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors duration-200"
                                               title="Clear all filters">
                                                <svg class="w-4 h-4 sm:mr-0 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                                </svg>
                                                <span class="sm:hidden">Clear All</span>
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Active Filters Display -->
                        @if(request()->hasAny(['search', 'department', 'status']))
                            <div class="mt-4 pt-4 border-t border-gray-200">
                                <div class="flex items-center space-x-2">
                                    <span class="text-sm font-medium text-gray-700">Active filters:</span>
                                    <div class="flex flex-wrap gap-2">
                                        @if(request('search'))
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                Search: "{{ request('search') }}"
                                                <a href="{{ request()->fullUrlWithQuery(['search' => null]) }}" class="ml-1.5 text-blue-600 hover:text-blue-800">
                                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                                    </svg>
                                                </a>
                                            </span>
                                        @endif
                                        @if(request('department'))
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                Department: {{ $departments->firstWhere('id', request('department'))->name ?? 'Unknown' }}
                                                <a href="{{ request()->fullUrlWithQuery(['department' => null]) }}" class="ml-1.5 text-green-600 hover:text-green-800">
                                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                                    </svg>
                                                </a>
                                            </span>
                                        @endif
                                        @if(request('status'))
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                                Status: {{ ucfirst(str_replace('_', ' ', request('status'))) }}
                                                <a href="{{ request()->fullUrlWithQuery(['status' => null]) }}" class="ml-1.5 text-purple-600 hover:text-purple-800">
                                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                                    </svg>
                                                </a>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </form>
            </div>

            <!-- Employee Directory -->
            <div class="card">
                <div class="card-header">
                    <div class="flex justify-between items-center">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">Employee Directory</h3>
                            <p class="text-sm text-gray-600 mt-1">Manage all employees and their information</p>
                        </div>
                        <div class="flex items-center space-x-3">
                            <span class="text-sm text-gray-500">Total: {{ $employees->total() }} employees</span>
                        </div>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    @forelse($employees as $employee)
                        @if($loop->first)
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Employee
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Department
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Position
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Status
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Hire Date
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Actions
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                        @endif
                        
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        <div class="h-10 w-10 rounded-full bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center">
                                            <span class="text-sm font-bold text-white">
                                                {{ strtoupper(substr($employee->first_name, 0, 1) . substr($employee->last_name, 0, 1)) }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">
                                            {{ $employee->full_name }}
                                        </div>
                                        <div class="text-sm text-gray-500">
                                            {{ $employee->employee_id ?? 'EMP0000' }} • {{ $employee->user->email }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($employee->department)
                                    <div class="text-sm text-gray-900">{{ $employee->department->name }}</div>
                                    @if($employee->department->code)
                                        <div class="text-sm text-gray-500">{{ $employee->department->code }}</div>
                                    @endif
                                @else
                                    <div class="text-sm text-gray-400">No Department</div>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($employee->position)
                                    <div class="text-sm text-gray-900">{{ $employee->position->title }}</div>
                                    <div class="text-sm text-gray-500 capitalize">{{ $employee->employment_type ?? 'full_time' }}</div>
                                @else
                                    <div class="text-sm text-gray-400">No Position</div>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($employee->employment_status === 'active')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        Active
                                    </span>
                                @elseif($employee->employment_status === 'inactive')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                        Inactive
                                    </span>
                                @elseif($employee->employment_status === 'terminated')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                        Terminated
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                        {{ ucfirst(str_replace('_', ' ', $employee->employment_status)) }}
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                @if($employee->hire_date)
                                    <div>{{ $employee->hire_date->format('M d, Y') }}</div>
                                    <div class="text-xs text-gray-500">{{ $employee->hire_date->diffForHumans() }}</div>
                                @else
                                    <span class="text-gray-400">Not set</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex items-center space-x-2">
                                    <a href="{{ route('admin.employees.show', $employee) }}" 
                                       class="text-blue-600 hover:text-blue-900">View</a>
                                    <a href="{{ route('admin.employees.edit', $employee) }}" 
                                       class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                    @if($employee->employment_status !== 'terminated')
                                        <form method="POST" 
                                              action="{{ route('admin.employees.destroy', $employee) }}" 
                                              class="inline"
                                              onsubmit="return confirm('Are you sure you want to terminate {{ $employee->full_name }}?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900">
                                                Terminate
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>

                        @if($loop->last)
                                </tbody>
                            </table>
                        @endif
                    @empty
                        <div class="text-center py-12">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/>
                            </svg>
                            <h3 class="mt-4 text-lg font-medium text-gray-900">No employees found</h3>
                            <p class="mt-2 text-gray-500">Get started by adding a new employee.</p>
                            <div class="mt-6">
                                <a href="{{ route('admin.employees.create') }}" class="btn btn-primary">
                                    Add Employee
                                </a>
                            </div>
                        </div>
                    @endforelse
                </div>

                @if($employees->hasPages())
                    <div class="px-6 py-4 border-t border-gray-200">
                        {{ $employees->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>