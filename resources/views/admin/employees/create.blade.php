<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add New Employee') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="card">
                <div class="card-header">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-xl font-semibold text-gray-900">Add New Employee</h3>
                            <p class="mt-1 text-sm text-gray-600">Create a new employee profile with all necessary information</p>
                        </div>
                        <div class="text-sm text-gray-500">
                            Step 1 of 1
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.employees.store') }}" class="space-y-8">
                        @csrf

                        <!-- Personal Information -->
                        <div class="form-section">
                            <div class="form-section-header">
                                <div class="flex items-center">
                                    <div class="form-section-icon">
                                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="form-section-title">Personal Information</h3>
                                        <p class="form-section-description">Basic personal details and contact information</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-grid">
                                <div class="form-group">
                                    <label for="first_name" class="form-label required">
                                        <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                        </svg>
                                        First Name
                                    </label>
                                    <input id="first_name" type="text" name="first_name" value="{{ old('first_name') }}" 
                                           class="form-input {{ $errors->has('first_name') ? 'form-input-error' : '' }}" 
                                           placeholder="Enter first name" required autofocus>
                                    @error('first_name')
                                        <div class="form-error">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="last_name" class="form-label required">
                                        <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                        </svg>
                                        Last Name
                                    </label>
                                    <input id="last_name" type="text" name="last_name" value="{{ old('last_name') }}" 
                                           class="form-input {{ $errors->has('last_name') ? 'form-input-error' : '' }}" 
                                           placeholder="Enter last name" required>
                                    @error('last_name')
                                        <div class="form-error">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="middle_name" class="form-label">
                                        <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                        </svg>
                                        Middle Name
                                    </label>
                                    <input id="middle_name" type="text" name="middle_name" value="{{ old('middle_name') }}" 
                                           class="form-input {{ $errors->has('middle_name') ? 'form-input-error' : '' }}" 
                                           placeholder="Enter middle name (optional)">
                                    @error('middle_name')
                                        <div class="form-error">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="email" class="form-label required">
                                        <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path>
                                        </svg>
                                        Email Address
                                    </label>
                                    <input id="email" type="email" name="email" value="{{ old('email') }}" 
                                           class="form-input {{ $errors->has('email') ? 'form-input-error' : '' }}" 
                                           placeholder="Enter email address" required>
                                    @error('email')
                                        <div class="form-error">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="phone" class="form-label">
                                        <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                        </svg>
                                        Phone Number
                                    </label>
                                    <input id="phone" type="tel" name="phone" value="{{ old('phone') }}" 
                                           class="form-input {{ $errors->has('phone') ? 'form-input-error' : '' }}" 
                                           placeholder="Enter phone number">
                                    @error('phone')
                                        <div class="form-error">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="date_of_birth" class="form-label">
                                        <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a2 2 0 012-2h4a2 2 0 012 2v4m-6 0v1a3 3 0 006 0V7m-6 0a3 3 0 106 0m-6 0h6"></path>
                                        </svg>
                                        Date of Birth
                                    </label>
                                    <input id="date_of_birth" type="date" name="date_of_birth" value="{{ old('date_of_birth') }}" 
                                           class="form-input {{ $errors->has('date_of_birth') ? 'form-input-error' : '' }}">
                                    @error('date_of_birth')
                                        <div class="form-error">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="gender" class="form-label">
                                        <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                                        </svg>
                                        Gender
                                    </label>
                                    <select id="gender" name="gender" class="form-select {{ $errors->has('gender') ? 'form-input-error' : '' }}">
                                        <option value="">Select gender</option>
                                        <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                                        <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
                                        <option value="other" {{ old('gender') == 'other' ? 'selected' : '' }}>Other</option>
                                    </select>
                                    @error('gender')
                                        <div class="form-error">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            
                            <div class="form-group form-group-full">
                                <label for="address" class="form-label">
                                    <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    Address
                                </label>
                                <textarea id="address" name="address" rows="3" 
                                          class="form-textarea {{ $errors->has('address') ? 'form-input-error' : '' }}" 
                                          placeholder="Enter full address">{{ old('address') }}</textarea>
                                @error('address')
                                    <div class="form-error">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="form-grid form-grid-3">
                                <div class="form-group">
                                    <label for="city" class="form-label">
                                        <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5"></path>
                                        </svg>
                                        City
                                    </label>
                                    <input id="city" type="text" name="city" value="{{ old('city') }}" 
                                           class="form-input {{ $errors->has('city') ? 'form-input-error' : '' }}" 
                                           placeholder="Enter city">
                                    @error('city')
                                        <div class="form-error">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="state" class="form-label">
                                        <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                        </svg>
                                        State
                                    </label>
                                    <input id="state" type="text" name="state" value="{{ old('state') }}" 
                                           class="form-input {{ $errors->has('state') ? 'form-input-error' : '' }}" 
                                           placeholder="Enter state">
                                    @error('state')
                                        <div class="form-error">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="zip_code" class="form-label">
                                        <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                        </svg>
                                        ZIP Code
                                    </label>
                                    <input id="zip_code" type="text" name="zip_code" value="{{ old('zip_code') }}" 
                                           class="form-input {{ $errors->has('zip_code') ? 'form-input-error' : '' }}" 
                                           placeholder="Enter ZIP code">
                                    @error('zip_code')
                                        <div class="form-error">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Employment Information -->
                        <div class="form-section">
                            <div class="form-section-header">
                                <div class="flex items-center">
                                    <div class="form-section-icon">
                                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2-2v2m8 0H8m8 0v2a2 2 0 01-2 2H10a2 2 0 01-2-2V6"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="form-section-title">Employment Information</h3>
                                        <p class="form-section-description">Job-related details and system permissions</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-grid">
                                <div class="form-group">
                                    <label for="employee_id" class="form-label required">
                                        <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V4a2 2 0 012-2h4a2 2 0 012 2v2m-6 0a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V6a2 2 0 00-2-2H6z"></path>
                                        </svg>
                                        Employee ID
                                    </label>
                                    <input id="employee_id" type="text" name="employee_id" value="{{ old('employee_id') }}" 
                                           class="form-input {{ $errors->has('employee_id') ? 'form-input-error' : '' }}" 
                                           placeholder="Enter unique employee ID" required>
                                    @error('employee_id')
                                        <div class="form-error">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="position_id" class="form-label required">
                                        <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2-2v2m8 0H8m8 0v2a2 2 0 01-2 2H10a2 2 0 01-2-2V6"></path>
                                        </svg>
                                        Position
                                    </label>
                                    <select id="position_id" name="position_id" class="form-select {{ $errors->has('position_id') ? 'form-input-error' : '' }}" required>
                                        <option value="">Select position</option>
                                        @foreach($positions as $position)
                                            <option value="{{ $position->id }}" {{ old('position_id') == $position->id ? 'selected' : '' }}>
                                                {{ $position->title }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('position_id')
                                        <div class="form-error">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="hire_date" class="form-label required">
                                        <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a2 2 0 012-2h4a2 2 0 012 2v4m-6 0v1a3 3 0 006 0V7m-6 0a3 3 0 106 0m-6 0h6"></path>
                                        </svg>
                                        Hire Date
                                    </label>
                                    <input id="hire_date" type="date" name="hire_date" value="{{ old('hire_date') }}" 
                                           class="form-input {{ $errors->has('hire_date') ? 'form-input-error' : '' }}" required>
                                    @error('hire_date')
                                        <div class="form-error">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="salary" class="form-label">
                                        <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                                        </svg>
                                        Salary
                                    </label>
                                    <input id="salary" type="number" step="0.01" name="salary" value="{{ old('salary') }}" 
                                           class="form-input {{ $errors->has('salary') ? 'form-input-error' : '' }}" 
                                           placeholder="Enter annual salary">
                                    @error('salary')
                                        <div class="form-error">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="employment_type" class="form-label required">
                                        <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        Employment Type
                                    </label>
                                    <select id="employment_type" name="employment_type" class="form-select {{ $errors->has('employment_type') ? 'form-input-error' : '' }}" required>
                                        <option value="">Select employment type</option>
                                        <option value="full_time" {{ old('employment_type') == 'full_time' ? 'selected' : '' }}>Full Time</option>
                                        <option value="part_time" {{ old('employment_type') == 'part_time' ? 'selected' : '' }}>Part Time</option>
                                        <option value="contract" {{ old('employment_type') == 'contract' ? 'selected' : '' }}>Contract</option>
                                        <option value="intern" {{ old('employment_type') == 'intern' ? 'selected' : '' }}>Intern</option>
                                    </select>
                                    @error('employment_type')
                                        <div class="form-error">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="role" class="form-label required">
                                        <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                        </svg>
                                        System Role
                                    </label>
                                    <select id="role" name="role" class="form-select {{ $errors->has('role') ? 'form-input-error' : '' }}" required>
                                        <option value="">Select system role</option>
                                        <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Administrator</option>
                                        <option value="hr" {{ old('role') == 'hr' ? 'selected' : '' }}>HR Staff</option>
                                        <option value="employee" {{ old('role') == 'employee' ? 'selected' : '' }}>Employee</option>
                                    </select>
                                    @error('role')
                                        <div class="form-error">{{ $message }}</div>
                                    @enderror
                                    <div class="form-help">This determines what system features the employee can access</div>
                                </div>

                                <div class="form-group">
                                    <label for="status" class="form-label required">
                                        <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        Employment Status
                                    </label>
                                    <select id="status" name="status" class="form-select {{ $errors->has('status') ? 'form-input-error' : '' }}" required>
                                        <option value="active" {{ old('status', 'active') == 'active' ? 'selected' : '' }}>Active</option>
                                        <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                        <option value="terminated" {{ old('status') == 'terminated' ? 'selected' : '' }}>Terminated</option>
                                    </select>
                                    @error('status')
                                        <div class="form-error">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-buttons">
                            <a href="{{ route('admin.employees.index') }}" class="btn btn-secondary">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                                Cancel
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                                Create Employee
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


</x-app-layout>