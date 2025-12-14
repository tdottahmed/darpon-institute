@extends('layouts.admin')

@section('content')
    <div class="sm:flex sm:items-center sm:justify-between">
        <div class="sm:flex-auto">
            <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">Enrollment #{{ $courseRegistration->id }}</h1>
            <p class="mt-2 text-sm text-gray-700 dark:text-gray-300">
                Registered on {{ $courseRegistration->created_at->format('F d, Y h:i A') }}
            </p>
        </div>
        <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none">
            <a href="{{ route('admin.course-registrations.index') }}"
               class="inline-flex items-center justify-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 sm:w-auto dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-700">
                Back to List
            </a>
        </div>
    </div>

    <div class="mt-8 grid grid-cols-1 gap-6 lg:grid-cols-3">
        <!-- Enrollment Information -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Course Details -->
             <div class="overflow-hidden bg-white shadow sm:rounded-lg dark:bg-gray-800">
                <div class="px-4 py-5 sm:px-6">
                    <h3 class="text-lg font-medium leading-6 text-gray-900 dark:text-white">Course Details</h3>
                </div>
                <div class="border-t border-gray-200 dark:border-gray-700">
                    <div class="px-4 py-5 sm:p-6">
                        <div class="flex items-center space-x-4">
                             <div class="flex-shrink-0 h-16 w-16 bg-gray-100 rounded overflow-hidden">
                                @if($courseRegistration->course->thumbnail)
                                    <img src="{{ Storage::url($courseRegistration->course->thumbnail) }}" alt="" class="h-full w-full object-cover">
                                @else
                                    <div class="flex items-center justify-center h-full w-full text-xs text-gray-400">No Img</div>
                                @endif
                            </div>
                            <div class="flex-1 min-w-0">
                                <h4 class="text-lg font-bold text-gray-900 dark:text-white">
                                    {{ $courseRegistration->course->title }}
                                </h4>
                                <p class="text-sm text-gray-500 dark:text-gray-400">
                                    {{ $courseRegistration->course->duration }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Student Details -->
            <div class="overflow-hidden bg-white shadow sm:rounded-lg dark:bg-gray-800">
                <div class="px-4 py-5 sm:px-6">
                    <h3 class="text-lg font-medium leading-6 text-gray-900 dark:text-white">Student Information</h3>
                </div>
                <div class="border-t border-gray-200 px-4 py-5 dark:border-gray-700 sm:p-0">
                    <dl class="sm:divide-y sm:divide-gray-200 dark:sm:divide-gray-700">
                        <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:py-5 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Full Name</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-white sm:col-span-2 sm:mt-0">{{ $courseRegistration->name }}</dd>
                        </div>
                        <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:py-5 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Email Address</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-white sm:col-span-2 sm:mt-0">{{ $courseRegistration->email }}</dd>
                        </div>
                        <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:py-5 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Phone Number</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-white sm:col-span-2 sm:mt-0">{{ $courseRegistration->phone }}</dd>
                        </div>
                        <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:py-5 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Address</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-white sm:col-span-2 sm:mt-0 whitespace-pre-wrap">{{ $courseRegistration->address }}</dd>
                        </div>
                    </dl>
                </div>
            </div>
        </div>

        <!-- Actions -->
        <div class="lg:col-span-1 space-y-6">
            <div class="overflow-hidden bg-white shadow sm:rounded-lg dark:bg-gray-800">
                <div class="px-4 py-5 sm:px-6">
                    <h3 class="text-lg font-medium leading-6 text-gray-900 dark:text-white">Enrollment Status</h3>
                </div>
                <div class="border-t border-gray-200 dark:border-gray-700 px-4 py-5 sm:p-6">
                    <form action="{{ route('admin.course-registrations.update', $courseRegistration) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Status</label>
                            <select id="status" name="status" class="mt-1 block w-full rounded-md border-gray-300 py-2 pl-3 pr-10 text-base focus:border-primary-500 focus:outline-none focus:ring-primary-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                <option value="pending" {{ $courseRegistration->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="confirmed" {{ $courseRegistration->status == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                                <option value="completed" {{ $courseRegistration->status == 'completed' ? 'selected' : '' }}>Completed</option>
                                <option value="cancelled" {{ $courseRegistration->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                        </div>
                        <div class="mt-4">
                            <button type="submit" class="inline-flex w-full justify-center rounded-md border border-transparent bg-primary-600 px-4 py-2 text-base font-medium text-white shadow-sm hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 sm:text-sm">
                                Update Status
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="overflow-hidden bg-white shadow sm:rounded-lg dark:bg-gray-800">
                <div class="px-4 py-5 sm:px-6">
                     <h3 class="text-lg font-medium leading-6 text-red-600 dark:text-red-400">Danger Zone</h3>
                </div>
                <div class="border-t border-gray-200 dark:border-gray-700 px-4 py-5 sm:p-6">
                     <form action="{{ route('admin.course-registrations.destroy', $courseRegistration) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this enrollment? This action cannot be undone.');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="inline-flex w-full justify-center rounded-md border border-red-300 bg-white px-4 py-2 text-base font-medium text-red-700 shadow-sm hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 sm:text-sm dark:bg-gray-700 dark:border-red-500 dark:text-red-400 dark:hover:bg-gray-600">
                            Delete Enrollment
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
