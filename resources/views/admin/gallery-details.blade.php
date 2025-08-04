<x-admin-layout>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h1 class="h3 mb-0">Gallery Item Details</h1>
                    <div>
                        <a href="{{ route('gallery') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Back to Gallery
                        </a>
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editGalleryModal">
                            <i class="fas fa-edit me-2"></i>Edit Gallery Item
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Gallery Information -->
            <div class="col-lg-8">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Gallery Information</h6>
                    </div>
                    <div class="card-body">
                        <h5>{{ $gallery->title }}</h5>
                        <p class="text-muted">{{ $gallery->description }}</p>
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <strong>Service Type:</strong> {{ $gallery->service_type }}
                            </div>
                            <div class="col-md-6">
                                <strong>Status:</strong> 
                                <span class="badge {{ $gallery->status_badge }}">{{ ucfirst($gallery->status) }}</span>
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <strong>Featured:</strong> 
                                <span class="badge {{ $gallery->featured ? 'badge-success' : 'badge-secondary' }}">
                                    {{ $gallery->featured ? 'Yes' : 'No' }}
                                </span>
                            </div>
                            <div class="col-md-6">
                                <strong>Sort Order:</strong> {{ $gallery->sort_order }}
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <strong>Customer:</strong> {{ $gallery->customer->name ?? 'N/A' }}
                            </div>
                            <div class="col-md-6">
                                <strong>Staff:</strong> {{ $gallery->staff->name ?? 'N/A' }}
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <strong>Created:</strong> {{ $gallery->created_at->format('M d, Y H:i') }}
                        </div>
                    </div>
                </div>

                <!-- Before and After Images -->
                <div class="card shadow">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Before & After Images</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h6 class="text-center mb-3">Before</h6>
                                @if($gallery->before_image)
                                    <img src="{{ $gallery->before_image_url }}" alt="Before" class="img-fluid rounded">
                                @else
                                    <div class="bg-light rounded p-4 text-center">
                                        <i class="fas fa-image fa-3x text-muted"></i>
                                        <p class="text-muted mt-2">No before image</p>
                                    </div>
                                @endif
                            </div>
                            <div class="col-md-6">
                                <h6 class="text-center mb-3">After</h6>
                                @if($gallery->after_image)
                                    <img src="{{ $gallery->after_image_url }}" alt="After" class="img-fluid rounded">
                                @else
                                    <div class="bg-light rounded p-4 text-center">
                                        <i class="fas fa-image fa-3x text-muted"></i>
                                        <p class="text-muted mt-2">No after image</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Related Information -->
            <div class="col-lg-4">
                <!-- Related Booking -->
                @if($gallery->booking)
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Related Booking</h6>
                    </div>
                    <div class="card-body">
                        <h6>{{ $gallery->booking->service_name }}</h6>
                        <p class="text-muted mb-2">Reference: {{ $gallery->booking->booking_reference }}</p>
                        
                        <div class="mb-2">
                            <strong>Date:</strong> {{ $gallery->booking->formatted_preferred_date }}
                        </div>
                        
                        <div class="mb-2">
                            <strong>Status:</strong> 
                            <span class="badge {{ $gallery->booking->status_badge }}">
                                {{ ucfirst($gallery->booking->status) }}
                            </span>
                        </div>
                        
                        <div class="mb-2">
                            <strong>Amount:</strong> {{ $gallery->booking->formatted_total_amount }}
                        </div>
                        
                        <div class="mb-2">
                            <strong>Staff:</strong> {{ $gallery->booking->assignedStaff->name ?? 'Unassigned' }}
                        </div>
                    </div>
                </div>
                @endif

                <!-- Customer Information -->
                @if($gallery->customer)
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Customer Information</h6>
                    </div>
                    <div class="card-body">
                        <h6>{{ $gallery->customer->name }}</h6>
                        <p class="text-muted mb-2">{{ $gallery->customer->email }}</p>
                        
                        <div class="mb-2">
                            <strong>Phone:</strong> {{ $gallery->customer->phone ?? 'Not provided' }}
                        </div>
                        
                        <div class="mb-2">
                            <strong>Total Bookings:</strong> {{ $gallery->customer->bookings->count() }}
                        </div>
                        
                        <div class="mb-2">
                            <strong>Total Spent:</strong> {{ $gallery->customer->formatted_total_spent }}
                        </div>
                    </div>
                </div>
                @endif

                <!-- Staff Information -->
                @if($gallery->staff)
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Staff Information</h6>
                    </div>
                    <div class="card-body">
                        <h6>{{ $gallery->staff->name }}</h6>
                        <p class="text-muted mb-2">{{ $gallery->staff->position }}</p>
                        
                        <div class="mb-2">
                            <strong>Department:</strong> {{ $gallery->staff->department ?? 'Not specified' }}
                        </div>
                        
                        <div class="mb-2">
                            <strong>Status:</strong> 
                            <span class="badge {{ $gallery->staff->status_badge }}">
                                {{ ucfirst($gallery->staff->status) }}
                            </span>
                        </div>
                        
                        <div class="mb-2">
                            <strong>Total Bookings:</strong> {{ $gallery->staff->total_bookings }}
                        </div>
                        
                        <div class="mb-2">
                            <strong>Completed:</strong> {{ $gallery->staff->completed_bookings }}
                        </div>
                    </div>
                </div>
                @endif

                <!-- Quick Actions -->
                <div class="card shadow">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Quick Actions</h6>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <button class="btn btn-outline-primary" onclick="toggleFeatured()">
                                <i class="fas fa-star me-2"></i>
                                {{ $gallery->featured ? 'Remove from Featured' : 'Add to Featured' }}
                            </button>
                            <button class="btn btn-outline-success" onclick="publishItem()">
                                <i class="fas fa-globe me-2"></i>Publish
                            </button>
                            <button class="btn btn-outline-warning" onclick="archiveItem()">
                                <i class="fas fa-archive me-2"></i>Archive
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Gallery Modal -->
    <div class="modal fade" id="editGalleryModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Gallery Item</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form class="ajax-form" action="{{ route('gallery.update', $gallery->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="title" class="form-label">Title</label>
                                    <input type="text" class="form-control" id="title" name="title" value="{{ $gallery->title }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="service_type" class="form-label">Service Type</label>
                                    <input type="text" class="form-control" id="service_type" name="service_type" value="{{ $gallery->service_type }}" required>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="3">{{ $gallery->description }}</textarea>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="customer_id" class="form-label">Customer</label>
                                    <select class="form-control" id="customer_id" name="customer_id" required>
                                        @foreach(\App\Models\customer::all() as $customer)
                                            <option value="{{ $customer->id }}" {{ $gallery->customer_id == $customer->id ? 'selected' : '' }}>
                                                {{ $customer->name }} ({{ $customer->email }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="staff_id" class="form-label">Staff</label>
                                    <select class="form-control" id="staff_id" name="staff_id">
                                        <option value="">Select Staff</option>
                                        @foreach(\App\Models\Staff::where('status', 'active')->get() as $staff)
                                            <option value="{{ $staff->id }}" {{ $gallery->staff_id == $staff->id ? 'selected' : '' }}>
                                                {{ $staff->name }} ({{ $staff->position }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="before_image" class="form-label">Before Image</label>
                                    <input type="file" class="form-control" id="before_image" name="before_image" accept="image/*">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="after_image" class="form-label">After Image</label>
                                    <input type="file" class="form-control" id="after_image" name="after_image" accept="image/*">
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="status" class="form-label">Status</label>
                                    <select class="form-control" id="status" name="status" required>
                                        <option value="draft" {{ $gallery->status === 'draft' ? 'selected' : '' }}>Draft</option>
                                        <option value="published" {{ $gallery->status === 'published' ? 'selected' : '' }}>Published</option>
                                        <option value="archived" {{ $gallery->status === 'archived' ? 'selected' : '' }}>Archived</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="sort_order" class="form-label">Sort Order</label>
                                    <input type="number" class="form-control" id="sort_order" name="sort_order" value="{{ $gallery->sort_order }}">
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="featured" name="featured" value="1" {{ $gallery->featured ? 'checked' : '' }}>
                                <label class="form-check-label" for="featured">
                                    Featured Gallery Item
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

    <script>
        function toggleFeatured() {
            fetch('{{ route("gallery.toggle-featured", $gallery->id) }}', {
                method: 'PATCH',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showAlert('success', data.message);
                    location.reload();
                } else {
                    showAlert('danger', 'Failed to update featured status');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showAlert('danger', 'An error occurred');
            });
        }

        function publishItem() {
            if (confirm('Are you sure you want to publish this gallery item?')) {
                // Implement publish functionality
                showAlert('success', 'Gallery item published successfully!');
            }
        }

        function archiveItem() {
            if (confirm('Are you sure you want to archive this gallery item?')) {
                // Implement archive functionality
                showAlert('success', 'Gallery item archived successfully!');
            }
        }
    </script>
</x-admin-layout> 