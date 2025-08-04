<x-admin-layout>
    <div class="admin-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h1 class="h3 mb-0">Customer Details</h1>
                        <div>
                            <a href="{{ route('customers') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Back to Customers
                            </a>
                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editCustomerModal">
                                <i class="fas fa-edit me-2"></i>Edit Customer
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- Customer Information -->
                <div class="col-lg-8">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Customer Information</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <h5>{{ $customer->name }}</h5>
                                    <p class="text-muted">{{ $customer->email }}</p>
                                    
                                    <div class="mb-3">
                                        <strong>Phone:</strong> {{ $customer->phone ?? 'Not provided' }}
                                    </div>
                                    
                                    <div class="mb-3">
                                        <strong>Address:</strong> {{ $customer->address ?? 'Not provided' }}
                                    </div>
                                    
                                    <div class="mb-3">
                                        <strong>Status:</strong> 
                                        <span class="badge {{ $customer->status_badge }}">{{ ucfirst($customer->status) }}</span>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <strong>Customer Reference:</strong> {{ $customer->customer_reference }}
                                    </div>
                                    
                                    <div class="mb-3">
                                        <strong>Member Since:</strong> {{ $customer->created_at->format('M d, Y') }}
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="card bg-light">
                                        <div class="card-body text-center">
                                            <div class="mb-3">
                                                <h4 class="text-primary">{{ $stats['total_bookings'] }}</h4>
                                                <p class="text-muted mb-0">Total Bookings</p>
                                            </div>
                                            <div class="mb-3">
                                                <h4 class="text-success">{{ $stats['completed_bookings'] }}</h4>
                                                <p class="text-muted mb-0">Completed</p>
                                            </div>
                                            <div class="mb-3">
                                                <h4 class="text-warning">${{ number_format($stats['total_spent'], 2) }}</h4>
                                                <p class="text-muted mb-0">Total Spent</p>
                                            </div>
                                            <div>
                                                <h4 class="text-info">{{ $stats['pending_bookings'] }}</h4>
                                                <p class="text-muted mb-0">Pending</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Customer Bookings -->
                    <div class="card shadow">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Booking History</h6>
                        </div>
                        <div class="card-body">
                            @if($customer->bookings->count() > 0)
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Reference</th>
                                                <th>Service</th>
                                                <th>Date</th>
                                                <th>Status</th>
                                                <th>Amount</th>
                                                <th>Staff</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($customer->bookings as $booking)
                                                <tr>
                                                    <td>
                                                        <a href="#" class="text-decoration-none">{{ $booking->booking_reference }}</a>
                                                    </td>
                                                    <td>{{ $booking->service_name }}</td>
                                                    <td>{{ $booking->formatted_preferred_date }}</td>
                                                    <td>
                                                        <span class="badge {{ $booking->status_badge }}">
                                                            {{ ucfirst($booking->status) }}
                                                        </span>
                                                    </td>
                                                    <td>{{ $booking->formatted_total_amount }}</td>
                                                    <td>{{ $booking->assignedStaff->name ?? 'Unassigned' }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <p class="text-muted">No bookings found for this customer.</p>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Customer Statistics -->
                <div class="col-lg-4">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Customer Statistics</h6>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label">Total Bookings</label>
                                <h4 class="text-primary">{{ $stats['total_bookings'] }}</h4>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Completed Bookings</label>
                                <h4 class="text-success">{{ $stats['completed_bookings'] }}</h4>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Total Spent</label>
                                <h4 class="text-warning">${{ number_format($stats['total_spent'], 2) }}</h4>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Pending Bookings</label>
                                <h4 class="text-info">{{ $stats['pending_bookings'] }}</h4>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Last Booking</label>
                                <p class="text-muted">{{ $customer->formatted_last_booking_date }}</p>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Average Order Value</label>
                                <h4 class="text-success">
                                    ${{ $stats['total_bookings'] > 0 ? number_format($stats['total_spent'] / $stats['total_bookings'], 2) : '0.00' }}
                                </h4>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="card shadow">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Quick Actions</h6>
                        </div>
                        <div class="card-body">
                            <div class="d-grid gap-2">
                                <a href="{{ route('front.book') }}?customer_id={{ $customer->id }}" class="btn btn-outline-primary">
                                    <i class="fas fa-plus me-2"></i>Create New Booking
                                </a>
                                <button class="btn btn-outline-success" onclick="sendEmail()">
                                    <i class="fas fa-envelope me-2"></i>Send Email
                                </button>
                                <button class="btn btn-outline-info" onclick="viewHistory()">
                                    <i class="fas fa-history me-2"></i>View Full History
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Customer Modal -->
    <div class="modal fade" id="editCustomerModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Customer</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form class="ajax-form" action="{{ route('customers.update', $customer->id) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="name" class="form-label">Full Name</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ $customer->name }}" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address</label>
                            <input type="email" class="form-control" id="email" name="email" value="{{ $customer->email }}" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="phone" class="form-label">Phone Number</label>
                            <input type="text" class="form-control" id="phone" name="phone" value="{{ $customer->phone }}">
                        </div>
                        
                        <div class="mb-3">
                            <label for="address" class="form-label">Address</label>
                            <textarea class="form-control" id="address" name="address" rows="3">{{ $customer->address }}</textarea>
                        </div>
                        
                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-control" id="status" name="status" required>
                                <option value="active" {{ $customer->status === 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ $customer->status === 'inactive' ? 'selected' : '' }}>Inactive</option>
                                <option value="blocked" {{ $customer->status === 'blocked' ? 'selected' : '' }}>Blocked</option>
                            </select>
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

    <script>
        function sendEmail() {
            // Implement email functionality
            alert('Email functionality would be implemented here');
        }

        function viewHistory() {
            // Implement full history view
            alert('Full history view would be implemented here');
        }
    </script>
</x-admin-layout> 