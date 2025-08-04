<x-admin-layout>
    <div class="admin-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h1 class="h3 mb-0">System Settings</h1>
                    </div>
                </div>
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
                    <div class="card border-left-success shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                        Total Customers</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['total_customers'] }}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-users fa-2x text-gray-300"></i>
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
                                    <i class="fas fa-user-check fa-2x text-gray-300"></i>
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
                                        Monthly Revenue</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">${{ number_format($stats['monthly_revenue'], 2) }}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Settings Sections -->
            <div class="row">
                <!-- System Information -->
                <div class="col-lg-6 mb-4">
                    <div class="card shadow">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">System Information</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-borderless">
                                    <tbody>
                                        <tr>
                                            <td><strong>Laravel Version:</strong></td>
                                            <td>{{ app()->version() }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>PHP Version:</strong></td>
                                            <td>{{ phpversion() }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Database:</strong></td>
                                            <td>{{ config('database.default') }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Environment:</strong></td>
                                            <td><span class="badge badge-{{ app()->environment() === 'production' ? 'success' : 'warning' }}">{{ app()->environment() }}</span></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Debug Mode:</strong></td>
                                            <td><span class="badge badge-{{ config('app.debug') ? 'danger' : 'success' }}">{{ config('app.debug') ? 'Enabled' : 'Disabled' }}</span></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="col-lg-6 mb-4">
                    <div class="card shadow">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Quick Actions</h6>
                        </div>
                        <div class="card-body">
                            <div class="d-grid gap-2">
                                <a href="{{ route('bookings.export') }}" class="btn btn-outline-primary">
                                    <i class="fas fa-download me-2"></i>Export Bookings (CSV)
                                </a>
                                <a href="{{ route('customers.export') }}" class="btn btn-outline-success">
                                    <i class="fas fa-download me-2"></i>Export Customers (CSV)
                                </a>
                                <button class="btn btn-outline-info" onclick="refreshStats()">
                                    <i class="fas fa-sync-alt me-2"></i>Refresh Statistics
                                </button>
                                <button class="btn btn-outline-warning" onclick="clearCache()">
                                    <i class="fas fa-broom me-2"></i>Clear Cache
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Database Statistics -->
            <div class="row">
                <div class="col-12">
                    <div class="card shadow">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Database Statistics</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3 text-center mb-3">
                                    <div class="border rounded p-3">
                                        <h4 class="text-primary">{{ $stats['total_bookings'] }}</h4>
                                        <p class="text-muted mb-0">Total Bookings</p>
                                    </div>
                                </div>
                                <div class="col-md-3 text-center mb-3">
                                    <div class="border rounded p-3">
                                        <h4 class="text-success">{{ $stats['total_customers'] }}</h4>
                                        <p class="text-muted mb-0">Total Customers</p>
                                    </div>
                                </div>
                                <div class="col-md-3 text-center mb-3">
                                    <div class="border rounded p-3">
                                        <h4 class="text-info">{{ $stats['total_staff'] }}</h4>
                                        <p class="text-muted mb-0">Total Staff</p>
                                    </div>
                                </div>
                                <div class="col-md-3 text-center mb-3">
                                    <div class="border rounded p-3">
                                        <h4 class="text-warning">{{ $stats['total_services'] }}</h4>
                                        <p class="text-muted mb-0">Total Services</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function refreshStats() {
            fetch('{{ route("dashboard.stats") }}')
                .then(response => response.json())
                .then(data => {
                    // Update statistics on the page
                    console.log('Statistics refreshed:', data);
                    showAlert('success', 'Statistics refreshed successfully!');
                })
                .catch(error => {
                    console.error('Error refreshing stats:', error);
                    showAlert('danger', 'Failed to refresh statistics');
                });
        }

        function clearCache() {
            if (confirm('Are you sure you want to clear the application cache?')) {
                fetch('/admin/clear-cache', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showAlert('success', 'Cache cleared successfully!');
                    } else {
                        showAlert('danger', 'Failed to clear cache');
                    }
                })
                .catch(error => {
                    console.error('Error clearing cache:', error);
                    showAlert('danger', 'Failed to clear cache');
                });
            }
        }
    </script>
</x-admin-layout> 