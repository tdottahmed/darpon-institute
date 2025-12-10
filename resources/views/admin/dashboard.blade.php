@extends('layouts.admin')

@section('content')
  <div class="space-y-6">
    <!-- Welcome Section -->
    <x-card variant="elevated">
      <div class="flex flex-col items-start justify-between gap-4 sm:flex-row sm:items-center">
        <div class="flex-1">
          <h1 class="text-2xl font-bold text-gray-900">Welcome back, {{ Auth::user()->name }}!</h1>
          <p class="mt-2 text-sm text-gray-600">Here's what's happening with your platform today.</p>
        </div>
        <div class="w-full sm:w-auto">
          <x-button variant="primary" size="md" class="w-full sm:w-auto">
            View Reports
          </x-button>
        </div>
      </div>
    </x-card>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4">
      <x-stat-card title="Total Users" :value="\App\Models\User::count()" icon="users" color="primary" trend="+12% from last month" />
      <x-stat-card title="Admin Users" :value="\App\Models\User::where('user_type', 'admin')->count()" icon="users" color="secondary" trend="+2 this month" />
      <x-stat-card title="Customers" :value="\App\Models\User::where('user_type', 'customer')->count()" icon="users" color="accent" trend="+8% from last month" />
      <x-stat-card title="Active Courses" value="24" icon="courses" color="light" trend="3 new this week" />
    </div>

    <!-- Recent Activity & Quick Actions -->
    <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
      <!-- Recent Activity -->
      <x-card variant="elevated" padding="lg">
        <div class="mb-6 flex items-center justify-between">
          <h3 class="text-lg font-semibold text-gray-900">Recent Activity</h3>
          <a href="#" class="text-sm font-medium text-primary-600 transition-colors hover:text-primary-700">View
            all</a>
        </div>
        <div class="space-y-4">
          <div class="flex items-start gap-4 border-b border-gray-100 pb-4 last:border-0 last:pb-0">
            <div class="flex-shrink-0">
              <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-primary-100">
                <x-icon name="users" class="h-6 w-6 text-primary-600" />
              </div>
            </div>
            <div class="min-w-0 flex-1">
              <p class="text-sm font-semibold text-gray-900">New user registered</p>
              <p class="mt-1 text-xs text-gray-500">2 hours ago</p>
            </div>
          </div>
          <div class="flex items-start gap-4 border-b border-gray-100 pb-4 last:border-0 last:pb-0">
            <div class="flex-shrink-0">
              <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-secondary-100">
                <x-icon name="courses" class="h-6 w-6 text-secondary-600" />
              </div>
            </div>
            <div class="min-w-0 flex-1">
              <p class="text-sm font-semibold text-gray-900">New course created</p>
              <p class="mt-1 text-xs text-gray-500">5 hours ago</p>
            </div>
          </div>
          <div class="flex items-start gap-4 border-b border-gray-100 pb-4 last:border-0 last:pb-0">
            <div class="flex-shrink-0">
              <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-accent-100">
                <x-icon name="analytics" class="h-6 w-6 text-accent-600" />
              </div>
            </div>
            <div class="min-w-0 flex-1">
              <p class="text-sm font-semibold text-gray-900">Monthly report generated</p>
              <p class="mt-1 text-xs text-gray-500">1 day ago</p>
            </div>
          </div>
        </div>
      </x-card>

      <!-- Quick Actions -->
      <x-card variant="elevated" padding="lg">
        <h3 class="mb-6 text-lg font-semibold text-gray-900">Quick Actions</h3>
        <div class="space-y-3">
          <a href="#"
             class="group flex items-center justify-between rounded-xl border border-gray-200 bg-white p-4 transition-all hover:border-primary-200 hover:bg-primary-50 hover:shadow-sm">
            <div class="flex items-center gap-3">
              <div
                   class="flex h-12 w-12 items-center justify-center rounded-xl bg-primary-100 transition-colors group-hover:bg-primary-200">
                <x-icon name="users" class="h-6 w-6 text-primary-600" />
              </div>
              <span class="text-sm font-semibold text-gray-900">Manage Users</span>
            </div>
            <svg class="h-5 w-5 text-gray-400 transition-colors group-hover:text-primary-600" fill="none"
                 stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
          </a>
          <a href="#"
             class="group flex items-center justify-between rounded-xl border border-gray-200 bg-white p-4 transition-all hover:border-secondary-200 hover:bg-secondary-50 hover:shadow-sm">
            <div class="flex items-center gap-3">
              <div
                   class="flex h-12 w-12 items-center justify-center rounded-xl bg-secondary-100 transition-colors group-hover:bg-secondary-200">
                <x-icon name="courses" class="h-6 w-6 text-secondary-600" />
              </div>
              <span class="text-sm font-semibold text-gray-900">Manage Courses</span>
            </div>
            <svg class="h-5 w-5 text-gray-400 transition-colors group-hover:text-secondary-600" fill="none"
                 stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
          </a>
          <a href="#"
             class="group flex items-center justify-between rounded-xl border border-gray-200 bg-white p-4 transition-all hover:border-accent-200 hover:bg-accent-50 hover:shadow-sm">
            <div class="flex items-center gap-3">
              <div
                   class="flex h-12 w-12 items-center justify-center rounded-xl bg-accent-100 transition-colors group-hover:bg-accent-200">
                <x-icon name="analytics" class="h-6 w-6 text-accent-600" />
              </div>
              <span class="text-sm font-semibold text-gray-900">View Analytics</span>
            </div>
            <svg class="h-5 w-5 text-gray-400 transition-colors group-hover:text-accent-600" fill="none"
                 stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
          </a>
          <a href="#"
             class="group flex items-center justify-between rounded-xl border border-gray-200 bg-white p-4 transition-all hover:border-light-200 hover:bg-light-50 hover:shadow-sm">
            <div class="flex items-center gap-3">
              <div
                   class="flex h-12 w-12 items-center justify-center rounded-xl bg-light-100 transition-colors group-hover:bg-light-200">
                <x-icon name="settings" class="h-6 w-6 text-light-600" />
              </div>
              <span class="text-sm font-semibold text-gray-900">Settings</span>
            </div>
            <svg class="h-5 w-5 text-gray-400 transition-colors group-hover:text-light-600" fill="none"
                 stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
          </a>
        </div>
      </x-card>
    </div>
  </div>
@endsection
