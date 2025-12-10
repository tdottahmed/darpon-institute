@extends('layouts.admin')

@section('content')
  <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
    <div class="p-6 text-gray-900">
      <h2 class="mb-4 text-2xl font-bold">Admin Dashboard</h2>
      <p class="text-gray-600">Welcome to the admin panel, {{ Auth::user()->name }}!</p>

      <div class="mt-6 grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
        <div class="rounded-lg bg-blue-50 p-4">
          <h3 class="text-lg font-semibold text-blue-900">Total Users</h3>
          <p class="mt-2 text-3xl font-bold text-blue-600">{{ \App\Models\User::count() }}</p>
        </div>
        <div class="rounded-lg bg-green-50 p-4">
          <h3 class="text-lg font-semibold text-green-900">Admin Users</h3>
          <p class="mt-2 text-3xl font-bold text-green-600">{{ \App\Models\User::where('user_type', 'admin')->count() }}
          </p>
        </div>
        <div class="rounded-lg bg-purple-50 p-4">
          <h3 class="text-lg font-semibold text-purple-900">Customers</h3>
          <p class="mt-2 text-3xl font-bold text-purple-600">
            {{ \App\Models\User::where('user_type', 'customer')->count() }}</p>
        </div>
      </div>
    </div>
  </div>
@endsection
