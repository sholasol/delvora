<x-admin-layout>
    <div class="admin-content">
        <div class="container-fluid">
            <!-- Page Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0">Staff Management</h1>
                <div class="d-flex gap-2">
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addStaffModal">
                        <i class="fas fa-plus me-2"></i>Add Staff
                    </button>
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
                                <option value="on_leave" {{ request('status') == 'on_leave' ? 'selected' : '' }}>On Leave</option>
                                <option value="terminated" {{ request('status') == 'terminated' ? 'selected' : '' }}>Terminated</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Department</label>
                            <select name="department" class="form-select">
                                <option value="">All Departments</option>
                                <option value="Residential" {{ request('department') == 'Residential' ? 'selected' : '' }}>Residential</option>
                                <option value="Commercial" {{ request('department') == 'Commercial' ? 'selected' : '' }}>Commercial</option>
                                <option value="Specialty" {{ request('department') == 'Specialty' ? 'selected' : '' }}>Specialty</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Search</label>
                            <input type="text" name="search" class="form-control" placeholder="Name, Email, Position..." value="{{ request('search') }}">
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary">Filter</button>
                            <a href="{{ route('staff') }}" class="btn btn-secondary">Clear</a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Staff Table -->
            <div class="card shadow">
                <div class="card-body">
                    @if($staff->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Staff Member</th>
                                        <th>Contact Info</th>
                                        <th>Position & Department</th>
                                        <th>Performance</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($staff as $member)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="me-3">
                                                    @if($member->avatar)
                                                        <img src="{{ $member->avatar_url }}" alt="{{ $member->name }}" class="rounded-circle" style="width: 50px; height: 50px; object-fit: cover;">
                                                    @else
                                                        <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                                            <span class="fw-bold">{{ strtoupper(substr($member->name, 0, 1)) }}</span>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div>
                                                    <h6 class="mb-1">{{ $member->name }}</h6>
                                                    <small class="text-muted">{{ $member->employee_id }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div>
                                                <div><i class="fas fa-envelope text-muted me-2"></i>{{ $member->email }}</div>
                                                <div><i class="fas fa-phone text-muted me-2"></i>{{ $member->phone }}</div>
                                                <div><i class="fas fa-calendar text-muted me-2"></i>Hired: {{ $member->hire_date->format('M j, Y') }}</div>
                                            </div>
                                        </td>
                                        <td>
                                            <div>
                                                <div class="fw-bold">{{ $member->position }}</div>
                                                <div class="text-muted">{{ $member->department }}</div>
                                                <div class="text-success">{{ $member->formatted_hourly_rate }}</div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="text-center">
                                                <div class="row">
                                                    <div class="col-6">
                                                        <h6 class="mb-0 text-primary">{{ $member->bookings_count }}</h6>
                                                        <small class="text-muted">Total</small>
                                                    </div>
                                                    <div class="col-6">
                                                        <h6 class="mb-0 text-success">{{ $member->completed_bookings }}</h6>
                                                        <small class="text-muted">Completed</small>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge {{ $member->status_badge }}">
                                                {{ ucfirst(str_replace('_', ' ', $member->status)) }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#viewStaffModal{{ $member->id }}">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                                <button type="button" class="btn btn-sm btn-outline-success" data-bs-toggle="modal" data-bs-target="#editStaffModal{{ $member->id }}">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button type="button" class="btn btn-sm btn-outline-info" data-bs-toggle="modal" data-bs-target="#staffStatsModal{{ $member->id }}">
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
                            {{ $staff->links() }}
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-users fa-3x text-gray-300 mb-3"></i>
                            <h5 class="text-gray-500">No staff members found</h5>
                            <p class="text-gray-400">There are no staff members matching your criteria.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Add Staff Modal -->
    <div class="modal fade" id="addStaffModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New Staff Member</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="addStaffForm" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Full Name *</label>
                                <input type="text" class="form-control" name="name" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Email *</label>
                                <input type="email" class="form-control" name="email" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Phone *</label>
                                <input type="tel" class="form-control" name="phone" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Position *</label>
                                <input type="text" class="form-control" name="position" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Department</label>
                                <select name="department" class="form-select">
                                    <option value="">Select Department</option>
                                    <option value="Residential">Residential</option>
                                    <option value="Commercial">Commercial</option>
                                    <option value="Specialty">Specialty</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Hire Date *</label>
                                <input type="date" class="form-control" name="hire_date" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Hourly Rate *</label>
                                <input type="number" class="form-control" name="hourly_rate" step="0.01" min="0" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Avatar</label>
                                <input type="file" class="form-control" name="avatar" accept="image/*">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Address</label>
                            <textarea class="form-control" name="address" rows="2"></textarea>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Emergency Contact</label>
                                <input type="text" class="form-control" name="emergency_contact">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Skills</label>
                                <input type="text" class="form-control" name="skills" placeholder="e.g., Deep cleaning, Stain removal">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Add Staff Member</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Staff Detail Modals -->
    @foreach($staff as $member)
    <div class="modal fade" id="viewStaffModal{{ $member->id }}" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Staff Details - {{ $member->name }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-4 text-center">
                            @if($member->avatar)
                                <img src="{{ $member->avatar_url }}" alt="{{ $member->name }}" class="img-fluid rounded mb-3" style="max-width: 200px;">
                            @else
                                <div class="bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 200px; height: 200px;">
                                    <span class="fw-bold" style="font-size: 4rem;">{{ strtoupper(substr($member->name, 0, 1)) }}</span>
                                </div>
                            @endif
                        </div>
                        <div class="col-md-8">
                            <h4>{{ $member->name }}</h4>
                            <p class="text-muted">{{ $member->position }} - {{ $member->department }}</p>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <h6>Contact Information</h6>
                                    <p><strong>Email:</strong> {{ $member->email }}</p>
                                    <p><strong>Phone:</strong> {{ $member->phone }}</p>
                                    <p><strong>Employee ID:</strong> {{ $member->employee_id }}</p>
                                    <p><strong>Hire Date:</strong> {{ $member->hire_date->format('M j, Y') }}</p>
                                </div>
                                <div class="col-md-6">
                                    <h6>Employment Details</h6>
                                    <p><strong>Status:</strong> {{ ucfirst(str_replace('_', ' ', $member->status)) }}</p>
                                    <p><strong>Hourly Rate:</strong> {{ $member->formatted_hourly_rate }}</p>
                                    <p><strong>Total Bookings:</strong> {{ $member->bookings_count }}</p>
                                    <p><strong>Completed:</strong> {{ $member->completed_bookings }}</p>
                                </div>
                            </div>
                            
                            @if($member->address)
                            <div class="mt-3">
                                <h6>Address</h6>
                                <p>{{ $member->address }}</p>
                            </div>
                            @endif
                            
                            @if($member->emergency_contact)
                            <div class="mt-3">
                                <h6>Emergency Contact</h6>
                                <p>{{ $member->emergency_contact }}</p>
                            </div>
                            @endif
                            
                            @if($member->skills)
                            <div class="mt-3">
                                <h6>Skills</h6>
                                <p>{{ $member->skills }}</p>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Staff Modal -->
    <div class="modal fade" id="editStaffModal{{ $member->id }}" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Staff Member - {{ $member->name }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="editStaffForm{{ $member->id }}" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Full Name *</label>
                                <input type="text" class="form-control" name="name" value="{{ $member->name }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Email *</label>
                                <input type="email" class="form-control" name="email" value="{{ $member->email }}" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Phone *</label>
                                <input type="tel" class="form-control" name="phone" value="{{ $member->phone }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Position *</label>
                                <input type="text" class="form-control" name="position" value="{{ $member->position }}" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Department</label>
                                <select name="department" class="form-select">
                                    <option value="">Select Department</option>
                                    <option value="Residential" {{ $member->department == 'Residential' ? 'selected' : '' }}>Residential</option>
                                    <option value="Commercial" {{ $member->department == 'Commercial' ? 'selected' : '' }}>Commercial</option>
                                    <option value="Specialty" {{ $member->department == 'Specialty' ? 'selected' : '' }}>Specialty</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Status *</label>
                                <select name="status" class="form-select" required>
                                    <option value="active" {{ $member->status == 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="inactive" {{ $member->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                    <option value="on_leave" {{ $member->status == 'on_leave' ? 'selected' : '' }}>On Leave</option>
                                    <option value="terminated" {{ $member->status == 'terminated' ? 'selected' : '' }}>Terminated</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Hire Date *</label>
                                <input type="date" class="form-control" name="hire_date" value="{{ $member->hire_date->format('Y-m-d') }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Hourly Rate *</label>
                                <input type="number" class="form-control" name="hourly_rate" step="0.01" min="0" value="{{ $member->hourly_rate }}" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Avatar</label>
                                <input type="file" class="form-control" name="avatar" accept="image/*">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Emergency Contact</label>
                                <input type="text" class="form-control" name="emergency_contact" value="{{ $member->emergency_contact }}">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Address</label>
                            <textarea class="form-control" name="address" rows="2">{{ $member->address }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Skills</label>
                            <input type="text" class="form-control" name="skills" value="{{ $member->skills }}" placeholder="e.g., Deep cleaning, Stain removal">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Update Staff Member</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Staff Stats Modal -->
    <div class="modal fade" id="staffStatsModal{{ $member->id }}" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Staff Performance - {{ $member->name }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <div class="card text-center">
                                <div class="card-body">
                                    <h3 class="text-primary">{{ $member->bookings_count }}</h3>
                                    <p class="mb-0">Total Bookings</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="card text-center">
                                <div class="card-body">
                                    <h3 class="text-success">{{ $member->completed_bookings }}</h3>
                                    <p class="mb-0">Completed</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="card text-center">
                                <div class="card-body">
                                    <h3 class="text-info">{{ $member->hire_date->format('M j, Y') }}</h3>
                                    <p class="mb-0">Hire Date</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="card text-center">
                                <div class="card-body">
                                    <h3 class="text-warning">{{ $member->formatted_hourly_rate }}</h3>
                                    <p class="mb-0">Hourly Rate</p>
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
                    <h5 class="modal-title">Export Staff</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Export staff data in various formats:</p>
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
        // Handle add staff form submission
        document.getElementById('addStaffForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            
            fetch('{{ route("staff.store") }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    alert('Error: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred. Please try again.');
            });
        });

        // Handle edit staff form submissions
        @foreach($staff as $member)
        document.getElementById('editStaffForm{{ $member->id }}').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            
            fetch('{{ route("staff.update", $member->id) }}', {
                method: 'PATCH',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    alert('Error: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred. Please try again.');
            });
        });
        @endforeach
    </script>
</x-admin-layout> 