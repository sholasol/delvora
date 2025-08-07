<x-admin-layout>
    <div class="admin-content">
        <div class="container-fluid">
            <!-- Page Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0">Bookings Management</h1>
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
                                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                                <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                                <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Date Range</label>
                            <input type="date" name="date_from" class="form-control" value="{{ request('date_from') }}">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">&nbsp;</label>
                            <input type="date" name="date_to" class="form-control" value="{{ request('date_to') }}">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Search</label>
                            <input type="text" name="search" class="form-control" placeholder="Reference, Customer, Service..." value="{{ request('search') }}">
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary">Filter</button>
                            <a href="{{ route('bookings') }}" class="btn btn-secondary">Clear</a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Bookings Table -->
            <div class="card shadow">
                <div class="card-body">
                    @if($bookings->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Reference</th>
                                        <th>Customer</th>
                                        {{-- <th>Service</th> --}}
                                        <th>Date</th>
                                        <th>Status</th>
                                        {{-- <th>Payment</th> --}}
                                        <th>Amount</th>
                                        <th>Staff</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($bookings as $booking)
                                    <tr>
                                        <td>
                                            <span>{{ $booking->booking_reference }}</span>
                                            <br>
                                            <small class="text-muted">{{ $booking->created_at->format('M j, Y') }}</small>
                                            <hr class="text-primary"/>
                                            <strong>{{ $booking->service_name }}</strong>
                                            @if($booking->service)
                                                <br>
                                                <small class="text-muted">{{ $booking->service->duration }}</small>
                                            @endif

                                            @php
                                            $stus = '';
                                            switch ($booking->payment_status_badge) {
                                                case 'badge-success':
                                                    $stus = 'success';
                                                    break;
                                                case ' badge-warning':
                                                    $stus = 'warning';
                                                    break;
                                                default:
                                                    $stus = 'danger';
                                            }
                                        @endphp
                                        <br/>
                                        <span class="text-{{ $stus }}">
                                           Payment:  {{ ucfirst($booking->payment_status) }}
                                        </span>
                                        </td>
                                        <td>
                                            <div>
                                                <strong>{{ $booking->customer->name ?? $booking->name }}</strong>
                                                <br>
                                                <small class="text-muted">{{ $booking->email }}</small>
                                                <br>
                                                <small class="text-muted">{{ $booking->phone }}</small>
                                            </div>
                                        </td>
                                        {{-- <td>
                                            <strong>{{ $booking->service_name }}</strong>
                                            @if($booking->service)
                                                <br>
                                                <small class="text-muted">{{ $booking->service->duration }}</small>
                                            @endif
                                        </td> --}}
                                        <td>
                                            <div>
                                                <strong>{{ $booking->preferred_date ? $booking->preferred_date->format('M j, Y') : 'N/A' }}</strong>
                                                <br>
                                                <small class="text-muted">{{ $booking->preferred_time }}</small>
                                            </div>
                                        </td>
                                        <td>
                                            @php
                                                $status = '';
                                                switch ($booking->status) {
                                                    case 'in_progress':
                                                        $status = 'warning';
                                                        break;
                                                    case 'confirmed':
                                                        $status = 'primary';
                                                        break;
                                                    case 'completed':
                                                        $status = 'success';
                                                        break;
                                                    case 'cancelled':
                                                        $status = 'danger';
                                                        break;
                                                    case 'pending':
                                                        $status = 'danger';
                                                        break;
                                                    default:
                                                        $status = 'dark';
                                                }
                                            @endphp

                                            <span class="text-{{ $status }}">
                                                {{ ucfirst(str_replace('_', ' ', $booking->status)) }}
                                            </span>
                                        </td>
                                        {{-- <td>
                                            @php
                                                $stus = '';
                                                switch ($booking->payment_status_badge) {
                                                    case 'badge-success':
                                                        $stus = 'success';
                                                        break;
                                                    case ' badge-warning':
                                                        $stus = 'warning';
                                                        break;
                                                    default:
                                                        $stus = 'danger';
                                                }
                                            @endphp
                                            <span class="text-{{ $stus }}">
                                                {{ ucfirst($booking->payment_status) }}
                                            </span>
                                        </td> --}}
                                        <td>
                                            <strong>${{ number_format($booking->total_amount, 2) }}</strong>
                                        </td>
                                        <td>
                                            @if($booking->assignedStaff)
                                                <div>
                                                    <strong>{{ $booking->assignedStaff->name }}</strong>
                                                    <br>
                                                    <small class="text-muted">{{ $booking->assignedStaff->position }}</small>
                                                </div>
                                            @else
                                                <span class="text-muted">Not assigned</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#bookingModal{{ $booking->id }}">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                                <button type="button" class="btn btn-sm btn-outline-success" data-bs-toggle="modal" data-bs-target="#statusModal{{ $booking->id }}">
                                                    <i class="fas fa-edit"></i>
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
                            {{ $bookings->links() }}
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-calendar fa-3x text-gray-300 mb-3"></i>
                            <h5 class="text-gray-500">No bookings found</h5>
                            <p class="text-gray-400">There are no bookings matching your criteria.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Booking Detail Modals -->
    @foreach($bookings as $booking)
    <div class="modal fade" id="bookingModal{{ $booking->id }}" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Booking Details - {{ $booking->booking_reference }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6>Customer Information</h6>
                            <p><strong>Name:</strong> {{ $booking->customer->name ?? $booking->name }}</p>
                            <p><strong>Email:</strong> {{ $booking->email }}</p>
                            <p><strong>Phone:</strong> {{ $booking->phone }}</p>
                            <p><strong>Address:</strong> {{ $booking->address }}</p>
                        </div>
                        <div class="col-md-6">
                            <h6>Booking Information</h6>
                            <p><strong>Service:</strong> {{ $booking->service_name }}</p>
                            <p><strong>Date:</strong> {{ $booking->preferred_date ? $booking->preferred_date->format('l, F j, Y') : 'N/A' }}</p>
                            <p><strong>Time:</strong> {{ $booking->preferred_time }}</p>
                            <p><strong>Amount:</strong> ${{ number_format($booking->total_amount, 2) }}</p>
                        </div>
                    </div>
                    @if($booking->message)
                    <div class="mt-3">
                        <h6>Message</h6>
                        <p>{{ $booking->message }}</p>
                    </div>
                    @endif
                    @if($booking->special_instructions)
                    <div class="mt-3">
                        <h6>Special Instructions</h6>
                        <p>{{ $booking->special_instructions }}</p>
                    </div>
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Status Update Modal -->
    <div class="modal fade" id="statusModal{{ $booking->id }}" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Update Booking Status</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST" action="{{route('bookings.update-status', ['id' => $booking->id])}}">
                    @csrf
                    @method('PATCH')

                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-select" required>
                                <option value="pending" {{ $booking->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="confirmed" {{ $booking->status == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                                <option value="in_progress" {{ $booking->status == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                <option value="completed" {{ $booking->status == 'completed' ? 'selected' : '' }}>Completed</option>
                                <option value="cancelled" {{ $booking->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Assign Staff</label>
                            <select name="assigned_staff_id" class="form-select">
                                <option value="">Select Staff</option>
                                @foreach($staff as $member)
                                <option value="{{ $member->id }}" {{ $booking->assigned_staff_id == $member->id ? 'selected' : '' }}>
                                    {{ $member->name }} - {{ $member->position }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Update Status</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endforeach

    <!-- Export Modal -->
    <div class="modal fade" id="exportModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Export Bookings</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Export bookings data in various formats:</p>
                    <div class="d-grid gap-2">
                        <button class="btn btn-outline-primary">Export to Excel</button>
                        <button class="btn btn-outline-secondary">Export to PDF</button>
                        <button class="btn btn-outline-success">Export to CSV</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Handle status form submissions
        @foreach($bookings as $booking)
        document.getElementById('statusForm{{ $booking->id }}').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            
            fetch('{{ route("bookings.update-status", $booking->id) }}', {
                method: 'PATCH',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    status: formData.get('status'),
                    assigned_staff_id: formData.get('assigned_staff_id')
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    alert('Error updating booking status');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error updating booking status');
            });
        });
        @endforeach
    </script>
</x-admin-layout>