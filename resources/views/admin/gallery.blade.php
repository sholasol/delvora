<x-admin-layout>
    <div class="admin-content">
        <div class="container-fluid">
            <!-- Page Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0">Gallery Management</h1>
                <div class="d-flex gap-2">
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addGalleryModal">
                        <i class="fas fa-plus me-2"></i>Add Gallery Item
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
                                <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                                <option value="published" {{ request('status') == 'published' ? 'selected' : '' }}>Published</option>
                                <option value="archived" {{ request('status') == 'archived' ? 'selected' : '' }}>Archived</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Service Type</label>
                            <select name="service_type" class="form-select">
                                <option value="">All Services</option>
                                @foreach($galleries->pluck('service_type')->unique() as $serviceType)
                                <option value="{{ $serviceType }}" {{ request('service_type') == $serviceType ? 'selected' : '' }}>{{ $serviceType }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Featured</label>
                            <select name="featured" class="form-select">
                                <option value="">All Items</option>
                                <option value="1" {{ request('featured') == '1' ? 'selected' : '' }}>Featured Only</option>
                                <option value="0" {{ request('featured') == '0' ? 'selected' : '' }}>Not Featured</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Search</label>
                            <input type="text" name="search" class="form-control" placeholder="Title, Description..." value="{{ request('search') }}">
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary">Filter</button>
                            <a href="{{ route('gallery') }}" class="btn btn-secondary">Clear</a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Gallery Grid -->
            <div class="card shadow">
                <div class="card-body">
                    @if($galleries->count() > 0)
                        <div class="row">
                            @foreach($galleries as $gallery)
                            <div class="col-lg-6 col-md-12 mb-4">
                                <div class="card h-100">
                                    <!-- Before/After Image Container -->
                                    <div class="position-relative">
                                        <div class="row g-0">
                                            <!-- Before Image -->
                                            <div class="col-6">
                                                <div class="position-relative">
                                                    @if($gallery->before_image)
                                                    <img src="{{ asset('asset/image/' . $gallery->before_image) }}"  class="img-fluid" alt="Before" style="height: 200px; width: 100%; object-fit: cover;">
                                                    @else
                                                    <div class="bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                                                        <i class="fas fa-image fa-2x text-muted"></i>
                                                    </div>
                                                    @endif
                                                    <div class="position-absolute bottom-0 start-0 w-100 bg-dark bg-opacity-75 text-white text-center py-1">
                                                        <small>BEFORE</small>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- After Image -->
                                            <div class="col-6">
                                                <div class="position-relative">
                                                    @if($gallery->after_image)
                                                    <img src="{{ asset('asset/image/' . $gallery->after_image) }}"  class="img-fluid" alt="After" style="height: 200px; width: 100%; object-fit: cover;">
                                                    @else
                                                    <div class="bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                                                        <i class="fas fa-image fa-2x text-muted"></i>
                                                    </div>
                                                    @endif
                                                    <div class="position-absolute bottom-0 start-0 w-100 bg-dark bg-opacity-75 text-white text-center py-1">
                                                        <small>AFTER</small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Status Badges -->
                                        <div class="position-absolute top-0 end-0 p-2">
                                            @if($gallery->featured)
                                            <span class="badge bg-warning mb-1 d-block"><i class="fas fa-star"></i> Featured</span>
                                            @endif
                                            <span class="badge {{ $gallery->status_badge }}">{{ ucfirst($gallery->status) }}</span>
                                        </div>
                                    </div>
                                    
                                    <div class="card-body">
                                        <h6 class="card-title">{{ $gallery->title }}</h6>
                                        <p class="card-text small text-muted">{{ Str::limit($gallery->description, 100) }}</p>
                                        
                                        <!-- Image Status Indicators -->
                                        <div class="row text-center mb-3">
                                            <div class="col-6">
                                                <small class="text-muted">Before Image</small>
                                                @if($gallery->before_image)
                                                <div class="text-success"><i class="fas fa-check"></i> Available</div>
                                                @else
                                                <div class="text-danger"><i class="fas fa-times"></i> Missing</div>
                                                @endif
                                            </div>
                                            <div class="col-6">
                                                <small class="text-muted">After Image</small>
                                                @if($gallery->after_image)
                                                <div class="text-success"><i class="fas fa-check"></i> Available</div>
                                                @else
                                                <div class="text-danger"><i class="fas fa-times"></i> Missing</div>
                                                @endif
                                            </div>
                                        </div>
                                        
                                        <!-- Details -->
                                        <div class="small text-muted mb-2">
                                            <div><i class="fas fa-tag me-1"></i>{{ $gallery->service_type }}</div>
                                            @if($gallery->customer)
                                            <div><i class="fas fa-user me-1"></i>{{ $gallery->customer->name }}</div>
                                            @endif
                                            @if($gallery->staff)
                                            <div><i class="fas fa-user-check me-1"></i>{{ $gallery->staff->name }}</div>
                                            @endif
                                        </div>
                                        
                                        <!-- Action Buttons -->
                                        <div class="btn-group w-100" role="group">
                                            <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#viewGalleryModal{{ $gallery->id }}">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button type="button" class="btn btn-sm btn-outline-success" data-bs-toggle="modal" data-bs-target="#editGalleryModal{{ $gallery->id }}">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button type="button" class="btn btn-sm btn-outline-info" onclick="toggleFeatured({{ $gallery->id }})">
                                                <i class="fas fa-star"></i>
                                            </button>
                                            <a href="{{route('gallery.destroy', ['id' =>$gallery->id])}}" onclick="return confirm('Delets this images in the gallery?')" class="btn btn-sm btn-outline-danger" onclick="deleteGallery({{ $gallery->id }})">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>

                        <!-- Pagination -->
                        <div class="d-flex justify-content-center mt-4">
                            {{ $galleries->links() }}
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-images fa-3x text-gray-300 mb-3"></i>
                            <h5 class="text-gray-500">No gallery items found</h5>
                            <p class="text-gray-400">There are no gallery items matching your criteria.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Add Gallery Modal -->
    <div class="modal fade" id="addGalleryModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Gallery Item</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST" action="{{route('gallery.store')}}" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Title *</label>
                                <input type="text" class="form-control" name="title" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Service Type *</label>
                                <select name="service_type" class="form-select" required>
                                    <option value="">Select Service</option>
                                    @foreach($bookings->pluck('service_name')->unique() as $serviceName)
                                    <option value="{{ $serviceName }}">{{ $serviceName }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea class="form-control" name="description" rows="3"></textarea>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Customer *</label>
                                <select name="customer_id" class="form-select" required>
                                    <option value="">Select Customer</option>
                                    @foreach($customers as $customer)
                                    <option value="{{ $customer->id }}">{{ $customer->name }} ({{ $customer->email }})</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Booking (Optional)</label>
                                <select name="booking_id" class="form-select">
                                    <option value="">Select Booking</option>
                                    @foreach($bookings as $booking)
                                    <option value="{{ $booking->id }}">{{ $booking->booking_reference }} - {{ $booking->service_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Staff (Optional)</label>
                                <select name="staff_id" class="form-select">
                                    <option value="">Select Staff</option>
                                    @foreach($staff as $member)
                                    <option value="{{ $member->id }}">{{ $member->name }} - {{ $member->position }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Status *</label>
                                <select name="status" class="form-select" required>
                                    <option value="draft">Draft</option>
                                    <option value="published">Published</option>
                                    <option value="archived">Archived</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Before Image *</label>
                                <input type="file" class="form-control" name="before_image" accept="image/*" required>
                                <small class="text-muted">Upload the "before" cleaning image</small>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">After Image *</label>
                                <input type="file" class="form-control" name="after_image" accept="image/*" required>
                                <small class="text-muted">Upload the "after" cleaning image</small>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="featured" id="featured">
                                <label class="form-check-label" for="featured">
                                    Mark as Featured
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Add Gallery Item</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Gallery Detail Modals -->
    @foreach($galleries as $gallery)
    <div class="modal fade" id="viewGalleryModal{{ $gallery->id }}" tabindex="-1">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ $gallery->title }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6>Before</h6>
                            @if($gallery->before_image)
                            <img src="{{ asset('storage/' . $gallery->before_image) }}" class="img-fluid rounded" alt="Before">
                            @else
                            <div class="bg-light rounded d-flex align-items-center justify-content-center" style="height: 300px;">
                                <div class="text-center">
                                    <i class="fas fa-image fa-3x text-muted mb-2"></i>
                                    <p class="text-muted">No before image available</p>
                                </div>
                            </div>
                            @endif
                        </div>
                        <div class="col-md-6">
                            <h6>After</h6>
                            @if($gallery->after_image)
                            <img src="{{ asset('storage/' . $gallery->after_image) }}" class="img-fluid rounded" alt="After">
                            @else
                            <div class="bg-light rounded d-flex align-items-center justify-content-center" style="height: 300px;">
                                <div class="text-center">
                                    <i class="fas fa-image fa-3x text-muted mb-2"></i>
                                    <p class="text-muted">No after image available</p>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                    
                    <div class="mt-4">
                        <h6>Details</h6>
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>Title:</strong> {{ $gallery->title }}</p>
                                <p><strong>Service Type:</strong> {{ $gallery->service_type }}</p>
                                <p><strong>Status:</strong> <span class="badge {{ $gallery->status_badge }}">{{ ucfirst($gallery->status) }}</span></p>
                                <p><strong>Featured:</strong> {{ $gallery->featured ? 'Yes' : 'No' }}</p>
                            </div>
                            <div class="col-md-6">
                                @if($gallery->customer)
                                <p><strong>Customer:</strong> {{ $gallery->customer->name }}</p>
                                @endif
                                @if($gallery->staff)
                                <p><strong>Staff:</strong> {{ $gallery->staff->name }}</p>
                                @endif
                                @if($gallery->booking)
                                <p><strong>Booking:</strong> {{ $gallery->booking->booking_reference }}</p>
                                @endif
                                <p><strong>Created:</strong> {{ $gallery->created_at->format('M j, Y') }}</p>
                            </div>
                        </div>
                        
                        @if($gallery->description)
                        <div class="mt-3">
                            <h6>Description</h6>
                            <p>{{ $gallery->description }}</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Gallery Modal -->
    <div class="modal fade" id="editGalleryModal{{ $gallery->id }}" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Gallery Item - {{ $gallery->title }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST" action="{{route('gallery.update', ['id' => $gallery->id])}}" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')

                    <div class="modal-body">
                        <!-- Current Images Preview -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <h6>Current Before Image</h6>
                                @if($gallery->before_image)
                                <img src="{{ asset('storage/' . $gallery->before_image) }}" class="img-fluid rounded" alt="Current Before" style="max-height: 150px;">
                                @else
                                <div class="bg-light rounded d-flex align-items-center justify-content-center" style="height: 150px;">
                                    <span class="text-muted">No image</span>
                                </div>
                                @endif
                            </div>
                            <div class="col-md-6">
                                <h6>Current After Image</h6>
                                @if($gallery->after_image)
                                <img src="{{ asset('storage/' . $gallery->after_image) }}" class="img-fluid rounded" alt="Current After" style="max-height: 150px;">
                                @else
                                <div class="bg-light rounded d-flex align-items-center justify-content-center" style="height: 150px;">
                                    <span class="text-muted">No image</span>
                                </div>
                                @endif
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Title *</label>
                                <input type="text" class="form-control" name="title" value="{{ $gallery->title }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Service Type *</label>
                                <select name="service_type" class="form-select" required>
                                    <option value="">Select Service</option>
                                    @foreach($bookings->pluck('service_name')->unique() as $serviceName)
                                    <option value="{{ $serviceName }}" {{ $gallery->service_type == $serviceName ? 'selected' : '' }}>{{ $serviceName }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea class="form-control" name="description" rows="3">{{ $gallery->description }}</textarea>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Customer *</label>
                                <select name="customer_id" class="form-select" required>
                                    <option value="">Select Customer</option>
                                    @foreach($customers as $customer)
                                    <option value="{{ $customer->id }}" {{ $gallery->customer_id == $customer->id ? 'selected' : '' }}>{{ $customer->name }} ({{ $customer->email }})</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Booking (Optional)</label>
                                <select name="booking_id" class="form-select">
                                    <option value="">Select Booking</option>
                                    @foreach($bookings as $booking)
                                    <option value="{{ $booking->id }}" {{ $gallery->booking_id == $booking->id ? 'selected' : '' }}>{{ $booking->booking_reference }} - {{ $booking->service_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Staff (Optional)</label>
                                <select name="staff_id" class="form-select">
                                    <option value="">Select Staff</option>
                                    @foreach($staff as $member)
                                    <option value="{{ $member->id }}" {{ $gallery->staff_id == $member->id ? 'selected' : '' }}>{{ $member->name }} - {{ $member->position }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Status *</label>
                                <select name="status" class="form-select" required>
                                    <option value="draft" {{ $gallery->status == 'draft' ? 'selected' : '' }}>Draft</option>
                                    <option value="published" {{ $gallery->status == 'published' ? 'selected' : '' }}>Published</option>
                                    <option value="archived" {{ $gallery->status == 'archived' ? 'selected' : '' }}>Archived</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">New Before Image</label>
                                <input type="file" class="form-control" name="before_image" accept="image/*">
                                <small class="text-muted">Leave empty to keep current image</small>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">New After Image</label>
                                <input type="file" class="form-control" name="after_image" accept="image/*">
                                <small class="text-muted">Leave empty to keep current image</small>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="featured" id="featured{{ $gallery->id }}" {{ $gallery->featured ? 'checked' : '' }}>
                                <label class="form-check-label" for="featured{{ $gallery->id }}">
                                    Mark as Featured
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Update Gallery Item</button>
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
                    <h5 class="modal-title">Export Gallery</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Export gallery data in various formats:</p>
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
        // Toggle featured status
        function toggleFeatured(galleryId) {
            fetch(`/admin/gallery/${galleryId}/toggle-featured`, {
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

        // Delete gallery item
        function deleteGallery(galleryId) {
            if (confirm('Are you sure you want to delete this gallery item? This action cannot be undone.')) {
                fetch(`/admin/gallery/${galleryId}`, {
                    method: 'DELETE',
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
        }
    </script>
</x-admin-layout>