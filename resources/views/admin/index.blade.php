<x-admin-layout>
    <div class="admin-content">
        <div class="container-fluid">
            <!-- Page Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0">Dashboard</h1>
                <div class="text-muted">Welcome back, {{ Auth::user()->name }}!</div>
            </div>

            <!-- Statistics Cards -->
            <div class="row mb-4">
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                        Total Bookings</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['total_bookings'] }}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-calendar fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-warning shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                        Pending Bookings</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['pending_bookings'] }}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-clock fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-success shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                        Total Revenue</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">${{ number_format($stats['total_revenue'], 2) }}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-info shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                        Active Staff</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['active_staff'] }}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-users fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Content Row -->
            <div class="row">
                <!-- Recent Bookings -->
                <div class="col-xl-8 col-lg-7">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                            <h6 class="m-0 font-weight-bold text-primary">Recent Bookings</h6>
                            <a href="{{ route('bookings') }}" class="btn btn-sm btn-primary">View All</a>
                        </div>
                        <div class="card-body">
                            @if($recent_bookings->count() > 0)
                                <div class="table-responsive">
                                    <table class="table table-bordered" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>Reference</th>
                                                <th>Customer</th>
                                                <th>Service</th>
                                                <th>Date</th>
                                                <th>Status</th>
                                                <th>Amount</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($recent_bookings as $booking)
                                            <tr>
                                                <td>
                                                    <a href="{{ route('bookings') }}?search={{ $booking->booking_reference }}" class="text-primary">
                                                        {{ $booking->booking_reference }}
                                                    </a>
                                                </td>
                                                <td>{{ $booking->customer->name ?? $booking->name }}</td>
                                                <td>{{ $booking->service_name }}</td>
                                                <td>{{ $booking->preferred_date ? $booking->preferred_date->format('M j, Y') : 'N/A' }}</td>
                                                <td>
                                                    <span class="badge {{ $booking->status_badge }}">
                                                        {{ ucfirst(str_replace('_', ' ', $booking->status)) }}
                                                    </span>
                                                </td>
                                                <td>${{ number_format($booking->total_amount, 2) }}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="text-center py-4">
                                    <i class="fas fa-calendar fa-3x text-gray-300 mb-3"></i>
                                    <p class="text-gray-500">No recent bookings found.</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Recent Customers -->
                <div class="col-xl-4 col-lg-5">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                            <h6 class="m-0 font-weight-bold text-primary">Recent Customers</h6>
                            <a href="{{ route('customers') }}" class="btn btn-sm btn-primary">View All</a>
                        </div>
                        <div class="card-body">
                            @if($recent_customers->count() > 0)
                                @foreach($recent_customers as $customer)
                                <div class="d-flex align-items-center mb-3">
                                    <div class="flex-shrink-0">
                                        <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                            <span class="text-white font-weight-bold">{{ strtoupper(substr($customer->name, 0, 1)) }}</span>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h6 class="mb-0">{{ $customer->name }}</h6>
                                        <small class="text-muted">{{ $customer->email }}</small>
                                        <div class="mt-1">
                                            <small class="text-muted">
                                                {{ $customer->bookings_count ?? 0 }} bookings • 
                                                ${{ number_format($customer->bookings_sum_total_amount ?? 0, 2) }}
                                            </small>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            @else
                                <div class="text-center py-4">
                                    <i class="fas fa-users fa-3x text-gray-300 mb-3"></i>
                                    <p class="text-gray-500">No recent customers found.</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="row">
                <div class="col-12">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Quick Actions</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3 mb-3">
                                    <a href="{{ route('bookings') }}" class="btn btn-outline-primary btn-block">
                                        <i class="fas fa-calendar-plus mr-2"></i>
                                        Manage Bookings
                                    </a>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <a href="{{ route('customers') }}" class="btn btn-outline-success btn-block">
                                        <i class="fas fa-users mr-2"></i>
                                        View Customers
                                    </a>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <a href="{{ route('staff') }}" class="btn btn-outline-info btn-block">
                                        <i class="fas fa-user-check mr-2"></i>
                                        Manage Staff
                                    </a>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <a href="{{ route('gallery') }}" class="btn btn-outline-warning btn-block">
                                        <i class="fas fa-images mr-2"></i>
                                        Gallery
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>