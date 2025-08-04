<x-admin-layout>
    <div class="admin-content">
        <div class="container-fluid">
            <!-- Page Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0">Customers Management</h1>
                <div class="d-flex gap-2">
                    <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#exportModal">
                        <i class="fas fa-download me-2"></i>Export
                    </button>
                </div>
            </div>

            <!-- Filters -->
            <div class="card shadow mb-4">
                <div class="card-body">
                    <form method="GET" class="row g-3">
                        <div class="col-md-3">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-select">
                                <option value="">All Status</option>
                                <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                <option value="blocked" {{ request('status') == 'blocked' ? 'selected' : '' }}>Blocked</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Search</label>
                            <input type="text" name="search" class="form-control" placeholder="Name, Email, Phone..." value="{{ request('search') }}">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Sort By</label>
                            <select name="sort" class="form-select">
                                <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Latest</option>
                                <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Oldest</option>
                                <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>Name</option>
                                <option value="bookings" {{ request('sort') == 'bookings' ? 'selected' : '' }}>Most Bookings</option>
                                <option value="spent" {{ request('sort') == 'spent' ? 'selected' : '' }}>Highest Spent</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary">Filter</button>
                            <a href="{{ route('customers') }}" class="btn btn-secondary">Clear</a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Customers Table -->
            <div class="card shadow">
                <div class="card-body">
                    @if($customers->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Customer</th>
                                        <th>Contact Info</th>
                                        <th>Bookings</th>
                                        <th>Total Spent</th>
                                        <th>Last Booking</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($customers as $customer)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                                    <span class="fw-bold">{{ strtoupper(substr($customer->name, 0, 1)) }}</span>
                                                </div>
                                                <div>
                                                    <h6 class="mb-1">{{ $customer->name }}</h6>
                                                    <small class="text-muted">{{ $customer->customer_reference }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div>
                                                <div><i class="fas fa-envelope text-muted me-2"></i>{{ $customer->email }}</div>
                                                <div><i class="fas fa-phone text-muted me-2"></i>{{ $customer->phone }}</div>
                                                @if($customer->address)
                                                <div><i class="fas fa-map-marker-alt text-muted me-2"></i>{{ Str::limit($customer->address, 50) }}</div>
                                                @endif
                                            </div>
                                        </td>
                                        <td>
                                            <div class="text-center">
                                                <h5 class="mb-0 text-primary">{{ $customer->bookings_count }}</h5>
                                                <small class="text-muted">bookings</small>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="text-center">
                                                <h5 class="mb-0 text-success">${{ number_format($customer->bookings_sum_total_amount ?? 0, 2) }}</h5>
                                                <small class="text-muted">total spent</small>
                                            </div>
                                        </td>
                                        <td>
                                            @if($customer->last_booking_date)
                                                <div class="text-center">
                                                    <div class="fw-bold">{{ $customer->last_booking_date->format('M j, Y') }}</div>
                                                    <small class="text-muted">{{ $customer->last_booking_date->diffForHumans() }}</small>
                                                </div>
                                            @else
                                                <span class="text-muted">No bookings</span>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="badge {{ $customer->status_badge }}">
                                                {{ ucfirst($customer->status) }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('customers.details', $customer->id) }}" class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <button type="button" class="btn btn-sm btn-outline-success" data-bs-toggle="modal" data-bs-target="#editCustomerModal{{ $customer->id }}">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button type="button" class="btn btn-sm btn-outline-info" data-bs-toggle="modal" data-bs-target="#customerStatsModal{{ $customer->id }}">
                                                    <i class="fas fa-chart-bar"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="d-flex justify-content-center mt-4">
                            {{ $customers->links() }}
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-users fa-3x text-gray-300 mb-3"></i>
                            <h5 class="text-gray-500">No customers found</h5>
                            <p class="text-gray-400">There are no customers matching your criteria.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Customer Detail Modals -->
    @foreach($customers as $customer)
    <div class="modal fade" id="editCustomerModal{{ $customer->id }}" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Customer - {{ $customer->name }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="editCustomerForm{{ $customer->id }}">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Name</label>
                                <input type="text" class="form-control" name="name" value="{{ $customer->name }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-control" name="email" value="{{ $customer->email }}" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Phone</label>
                                <input type="tel" class="form-control" name="phone" value="{{ $customer->phone }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Status</label>
                                <select name="status" class="form-select" required>
                                    <option value="active" {{ $customer->status == 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="inactive" {{ $customer->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                    <option value="blocked" {{ $customer->status == 'blocked' ? 'selected' : '' }}>Blocked</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Address</label>
                            <textarea class="form-control" name="address" rows="3">{{ $customer->address }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Notes</label>
                            <textarea class="form-control" name="message" rows="3">{{ $customer->message }}</textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Update Customer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Customer Stats Modal -->
    <div class="modal fade" id="customerStatsModal{{ $customer->id }}" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Customer Statistics - {{ $customer->name }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="card text-center">
                                <div class="card-body">
                                    <h3 class="text-primary">{{ $customer->bookings_count }}</h3>
                                    <p class="mb-0">Total Bookings</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="card text-center">
                                <div class="card-body">
                                    <h3 class="text-success">${{ number_format($customer->bookings_sum_total_amount ?? 0, 2) }}</h3>
                                    <p class="mb-0">Total Spent</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="card text-center">
                                <div class="card-body">
                                    <h3 class="text-info">{{ $customer->last_booking_date ? $customer->last_booking_date->format('M j, Y') : 'N/A' }}</h3>
                                    <p class="mb-0">Last Booking</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="card text-center">
                                <div class="card-body">
                                    <h3 class="text-warning">{{ $customer->created_at->format('M j, Y') }}</h3>
                                    <p class="mb-0">Member Since</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach

    <!-- Export Modal -->
    <div class="modal fade" id="exportModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Export Customers</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Export customers data in various formats:</p>
                    <div class="d-grid gap-2">
                        <button class="btn btn-outline-primary">Export to Excel</button>
                        <button class="btn btn-outline-secondary">Export to PDF</button>
                        <button class="btn btn-outline-success">Export to CSV</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout> 