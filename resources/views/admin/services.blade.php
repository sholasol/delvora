<x-admin-layout>
    <div class="admin-content">
        <div class="container-fluid">
            <!-- Page Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0">Services Management</h1>
                <div class="d-flex gap-2">
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addServiceModal">
                        <i class="fas fa-plus me-2"></i>Add Service
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
                                <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Category</label>
                            <select name="category" class="form-select">
                                <option value="">All Categories</option>
                                @foreach($services->pluck('category')->unique() as $category)
                                <option value="{{ $category }}" {{ request('category') == $category ? 'selected' : '' }}>{{ $category }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Featured</label>
                            <select name="featured" class="form-select">
                                <option value="">All Services</option>
                                <option value="1" {{ request('featured') == '1' ? 'selected' : '' }}>Featured Only</option>
                                <option value="0" {{ request('featured') == '0' ? 'selected' : '' }}>Not Featured</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Search</label>
                            <input type="text" name="search" class="form-control" placeholder="Name, Description..." value="{{ request('search') }}">
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary">Filter</button>
                            <a href="{{ route('services') }}" class="btn btn-secondary">Clear</a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Services Table -->
            <div class="card shadow">
                <div class="card-body">
                    @if($services->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Service</th>
                                        <th>Details</th>
                                        <th>Pricing</th>
                                        <th>Category</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($services as $service)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="me-3">
                                                    @if($service->image)
                                                        <img src="{{ asset('asset/image/' . $service->image) }}" alt="{{ $service->name }}" class="rounded" style="width: 60px; height: 60px; object-fit: cover;">
                                                    @else
                                                        <div class="bg-primary text-white rounded d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                                            <i class="fas fa-broom fa-2x"></i>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div>
                                                    <h6 class="mb-1">{{ $service->name }}</h6>
                                                    <small class="text-muted">{{ Str::limit($service->description, 80) }}</small>
                                                    @if($service->featured)
                                                    <div class="mt-1">
                                                        <span class="badge bg-warning"><i class="fas fa-star"></i> Featured</span>
                                                    </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div>
                                                <div><strong>Duration:</strong> {{ $service->duration }}</div>
                                                <div><strong>Category:</strong> {{ $service->category }}</div>
                                                <div><strong>Sort Order:</strong> {{ $service->sort_order }}</div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="text-center">
                                                <h5 class="text-success mb-1">{{ $service->formatted_price }}</h5>
                                                <small class="text-muted">Base Price</small>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge bg-info">{{ $service->category }}</span>
                                        </td>
                                        <td>
                                            @php
                                                $stus = '';
                                                switch ($service->status) {
                                                    case 'active':
                                                        $stus = 'primary';
                                                        break;
                                                    case 'inactive':
                                                        $stus = 'info';

                                                    case 'draft':
                                                        $stus = 'warning';
                                                        break;
                                                    default:
                                                        $stus = 'danger';
                                                }
                                            @endphp
                                            <span class="text-{{ $stus }}">
                                                {{ ucfirst($service->status) }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#viewServiceModal{{ $service->id }}">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                                <button type="button" class="btn btn-sm btn-outline-success" data-bs-toggle="modal" data-bs-target="#editServiceModal{{ $service->id }}">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button type="button" class="btn btn-sm btn-outline-info" onclick="toggleFeatured({{ $service->id }})">
                                                    <i class="fas fa-star"></i>
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
                            {{ $services->links() }}
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-broom fa-3x text-gray-300 mb-3"></i>
                            <h5 class="text-gray-500">No services found</h5>
                            <p class="text-gray-400">There are no services matching your criteria.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Add Service Modal -->
    <div class="modal fade" id="addServiceModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New Service</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST" action="{{route('services.store')}}" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Service Name *</label>
                                <input type="text" class="form-control" name="name" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Category</label>
                                <select name="category" class="form-select">
                                    <option value="">Select Category</option>
                                    <option value="Residential">Residential</option>
                                    <option value="Commercial">Commercial</option>
                                    <option value="Specialty">Specialty</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Description *</label>
                            <textarea class="form-control" name="description" rows="3" required></textarea>
                        </div>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Price *</label>
                                <div class="input-group">
                                    <span class="input-group-text">$</span>
                                    <input type="number" class="form-control" name="price" step="0.01" min="0" required>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Duration</label>
                                <input type="text" class="form-control" name="duration" placeholder="e.g., 2-3 hours">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Sort Order</label>
                                <input type="number" class="form-control" name="sort_order" value="0" min="0">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">What's Included</label>
                                <textarea class="form-control" name="include" rows="3" placeholder="List what's included in this service"></textarea>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">What's Not Included</label>
                                <textarea class="form-control" name="exclude" rows="3" placeholder="List what's not included in this service"></textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Status *</label>
                                <select name="status" class="form-select" required>
                                    <option value="active">Active</option>
                                    <option value="inactive">Inactive</option>
                                    <option value="draft">Draft</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Service Image</label>
                                <input type="file" class="form-control" name="image" accept="image/*">
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="featured" id="featured">
                                <label class="form-check-label" for="featured">
                                    Mark as Featured Service
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Add Service</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Service Detail Modals -->
    @foreach($services as $service)
    <div class="modal fade" id="viewServiceModal{{ $service->id }}" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ $service->name }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-4">
                            @if($service->image)
                                <img src="{{ asset('asset/image/' . $service->image) }}" alt="{{ $service->name }}" class="img-fluid rounded">
                            @else
                                <div class="bg-primary text-white rounded d-flex align-items-center justify-content-center" style="height: 200px;">
                                    <i class="fas fa-broom fa-3x"></i>
                                </div>
                            @endif
                        </div>
                        <div class="col-md-8">
                            <h4>{{ $service->name }}</h4>
                            <p class="text-muted">{{ $service->description }}</p>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <h6>Service Details</h6>
                                    <p><strong>Category:</strong> {{ $service->category }}</p>
                                    <p><strong>Duration:</strong> {{ $service->duration }}</p>
                                    <p><strong>Price:</strong> {{ $service->formatted_price }}</p>
                                    <p><strong>Status:</strong> <span class="badge {{ $service->status_badge }}">{{ ucfirst($service->status) }}</span></p>
                                </div>
                                <div class="col-md-6">
                                    <h6>Settings</h6>
                                    <p><strong>Featured:</strong> {{ $service->featured ? 'Yes' : 'No' }}</p>
                                    <p><strong>Sort Order:</strong> {{ $service->sort_order }}</p>
                                    <p><strong>Created:</strong> {{ $service->created_at->format('M j, Y') }}</p>
                                </div>
                            </div>
                            
                            @if($service->include)
                            <div class="mt-3">
                                <h6>What's Included</h6>
                                <p>{{ $service->include }}</p>
                            </div>
                            @endif
                            
                            @if($service->exclude)
                            <div class="mt-3">
                                <h6>What's Not Included</h6>
                                <p>{{ $service->exclude }}</p>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Service Modal -->
    <div class="modal fade" id="editServiceModal{{ $service->id }}" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Service - {{ $service->name }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST" action="{{route('services.update', ['id' => $service->id])}}" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')

                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Service Name *</label>
                                <input type="text" class="form-control" name="name" value="{{ $service->name }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Category</label>
                                <select name="category" class="form-select">
                                    <option value="">Select Category</option>
                                    <option value="Residential" {{ $service->category == 'Residential' ? 'selected' : '' }}>Residential</option>
                                    <option value="Commercial" {{ $service->category == 'Commercial' ? 'selected' : '' }}>Commercial</option>
                                    <option value="Specialty" {{ $service->category == 'Specialty' ? 'selected' : '' }}>Specialty</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Description *</label>
                            <textarea class="form-control" name="description" rows="3" required>{{ $service->description }}</textarea>
                        </div>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Price *</label>
                                <div class="input-group">
                                    <span class="input-group-text">$</span>
                                    <input type="number" class="form-control" name="price" step="0.01" min="0" value="{{ $service->price }}" required>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Duration</label>
                                <input type="text" class="form-control" name="duration" value="{{ $service->duration }}" placeholder="e.g., 2-3 hours">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Sort Order</label>
                                <input type="number" class="form-control" name="sort_order" value="{{ $service->sort_order }}" min="0">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">What's Included</label>
                                <textarea class="form-control" name="include" rows="3" placeholder="List what's included in this service">{{ $service->include }}</textarea>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">What's Not Included</label>
                                <textarea class="form-control" name="exclude" rows="3" placeholder="List what's not included in this service">{{ $service->exclude }}</textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Status *</label>
                                <select name="status" class="form-select" required>
                                    <option value="active" {{ $service->status == 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="inactive" {{ $service->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                    <option value="draft" {{ $service->status == 'draft' ? 'selected' : '' }}>Draft</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Service Image</label>
                                <input type="file" class="form-control" name="image" accept="image/*">
                                <small class="text-muted">Leave empty to keep current image</small>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="featured" id="featured{{ $service->id }}" {{ $service->featured ? 'checked' : '' }}>
                                <label class="form-check-label" for="featured{{ $service->id }}">
                                    Mark as Featured Service
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Update Service</button>
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
                    <h5 class="modal-title">Export Services</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Export services data in various formats:</p>
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
        // Handle add service form submission
        document.getElementById('addServiceForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            
            fetch('{{ route("services.store") }}', {
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

        // Handle edit service form submissions
        @foreach($services as $service)
        document.getElementById('editServiceForm{{ $service->id }}').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            
            fetch('{{ route("services.update", $service->id) }}', {
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

        // Toggle featured status
        function toggleFeatured(serviceId) {
            fetch(`/admin/services/${serviceId}/toggle-featured`, {
                method: 'PATCH',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json',
                }
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
        }
    </script>
</x-admin-layout> 