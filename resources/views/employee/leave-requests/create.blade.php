<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Submit Leave Request') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-xl sm:rounded-lg overflow-hidden">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">New Leave Request</h3>
                    <p class="mt-1 text-sm text-gray-600">Please fill out all required fields to submit your leave request.</p>
                </div>

                <form method="POST" action="{{ route('employee.leave-requests.store') }}" class="p-6 space-y-6">
                    @csrf

                    <!-- Leave Type -->
                    <div>
                        <label for="leave_type" class="block text-sm font-medium text-gray-700 mb-2">
                            Leave Type <span class="text-red-500">*</span>
                        </label>
                        <select name="leave_type" id="leave_type" required
                                class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('leave_type') border-red-300 @enderror">
                            <option value="">Select leave type...</option>
                            <option value="sick" {{ old('leave_type') === 'sick' ? 'selected' : '' }}>Sick Leave</option>
                            <option value="vacation" {{ old('leave_type') === 'vacation' ? 'selected' : '' }}>Vacation</option>
                            <option value="personal" {{ old('leave_type') === 'personal' ? 'selected' : '' }}>Personal Leave</option>
                            <option value="maternity" {{ old('leave_type') === 'maternity' ? 'selected' : '' }}>Maternity Leave</option>
                            <option value="paternity" {{ old('leave_type') === 'paternity' ? 'selected' : '' }}>Paternity Leave</option>
                        </select>
                        @error('leave_type')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Date Range -->
                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                        <div>
                            <label for="start_date" class="block text-sm font-medium text-gray-700 mb-2">
                                Start Date <span class="text-red-500">*</span>
                            </label>
                            <input type="date" name="start_date" id="start_date" required
                                   min="{{ date('Y-m-d') }}"
                                   value="{{ old('start_date') }}"
                                   class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('start_date') border-red-300 @enderror">
                            @error('start_date')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="end_date" class="block text-sm font-medium text-gray-700 mb-2">
                                End Date <span class="text-red-500">*</span>
                            </label>
                            <input type="date" name="end_date" id="end_date" required
                                   min="{{ date('Y-m-d') }}"
                                   value="{{ old('end_date') }}"
                                   class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('end_date') border-red-300 @enderror">
                            @error('end_date')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Duration Display -->
                    <div id="duration-display" class="hidden bg-blue-50 border border-blue-200 rounded-md p-4">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-blue-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span class="text-sm font-medium text-blue-800">Duration: <span id="duration-text"></span></span>
                        </div>
                    </div>

                    <!-- Reason -->
                    <div>
                        <label for="reason" class="block text-sm font-medium text-gray-700 mb-2">
                            Reason for Leave <span class="text-red-500">*</span>
                        </label>
                        <textarea name="reason" id="reason" rows="4" required
                                  placeholder="Please provide a detailed reason for your leave request..."
                                  class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('reason') border-red-300 @enderror">{{ old('reason') }}</textarea>
                        <p class="mt-1 text-sm text-gray-500">Maximum 500 characters</p>
                        @error('reason')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Leave Policy Reminder -->
                    <div class="bg-yellow-50 border border-yellow-200 rounded-md p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.082 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-yellow-800">Leave Policy Reminder</h3>
                                <div class="mt-2 text-sm text-yellow-700">
                                    <ul class="list-disc pl-5 space-y-1">
                                        <li>Submit leave requests at least 2 weeks in advance when possible</li>
                                        <li>Emergency sick leave can be submitted on the same day</li>
                                        <li>All requests are subject to management approval</li>
                                        <li>You will receive notification once your request is reviewed</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-200">
                        <a href="{{ route('employee.leave-requests.index') }}" 
                           class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                            Cancel
                        </a>
                        <button type="submit" 
                                class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                            Submit Leave Request
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Calculate and display duration
        function calculateDuration() {
            const startDate = document.getElementById('start_date').value;
            const endDate = document.getElementById('end_date').value;
            
            if (startDate && endDate) {
                const start = new Date(startDate);
                const end = new Date(endDate);
                
                if (end >= start) {
                    const diffTime = Math.abs(end - start);
                    const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)) + 1;
                    
                    document.getElementById('duration-text').textContent = diffDays + ' day' + (diffDays !== 1 ? 's' : '');
                    document.getElementById('duration-display').classList.remove('hidden');
                } else {
                    document.getElementById('duration-display').classList.add('hidden');
                }
            } else {
                document.getElementById('duration-display').classList.add('hidden');
            }
        }

        // Update end date minimum when start date changes
        function updateEndDateMin() {
            const startDate = document.getElementById('start_date').value;
            const endDateInput = document.getElementById('end_date');
            
            if (startDate) {
                endDateInput.min = startDate;
                // Clear end date if it's before the new start date
                if (endDateInput.value && new Date(endDateInput.value) < new Date(startDate)) {
                    endDateInput.value = '';
                }
            }
            calculateDuration();
        }

        // Event listeners
        document.getElementById('start_date').addEventListener('change', updateEndDateMin);
        document.getElementById('end_date').addEventListener('change', calculateDuration);

        // Character count for reason textarea
        const reasonTextarea = document.getElementById('reason');
        const maxLength = 500;

        reasonTextarea.addEventListener('input', function() {
            const remaining = maxLength - this.value.length;
            const helpText = this.parentNode.querySelector('.text-gray-500');
            
            if (remaining < 0) {
                helpText.textContent = `${Math.abs(remaining)} characters over limit`;
                helpText.className = 'mt-1 text-sm text-red-500';
            } else {
                helpText.textContent = `${remaining} characters remaining`;
                helpText.className = 'mt-1 text-sm text-gray-500';
            }
        });
    </script>
</x-app-layout>