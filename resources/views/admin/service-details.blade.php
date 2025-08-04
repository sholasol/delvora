<x-admin-layout>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h1 class="h3 mb-0">Service Details</h1>
                    <div>
                        <a href="{{ route('services') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Back to Services
                        </a>
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editServiceModal">
                            <i class="fas fa-edit me-2"></i>Edit Service
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Service Information -->
            <div class="col-lg-8">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Service Information</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h5>{{ $service->name }}</h5>
                                <p class="text-muted">{{ $service->description }}</p>
                                
                                <div class="mb-3">
                                    <strong>Category:</strong> {{ $service->category ?? 'Uncategorized' }}
                                </div>
                                
                                <div class="mb-3">
                                    <strong>Duration:</strong> {{ $service->duration ?? 'Not specified' }}
                                </div>
                                
                                <div class="mb-3">
                                    <strong>Price:</strong> <span class="text-success fw-bold">{{ $service->formatted_price }}</span>
                                </div>
                                
                                <div class="mb-3">
                                    <strong>Status:</strong> 
                                    <span class="badge {{ $service->status_badge }}">{{ ucfirst($service->status) }}</span>
                                </div>
                                
                                <div class="mb-3">
                                    <strong>Featured:</strong> 
                                    <span class="badge {{ $service->featured ? 'badge-success' : 'badge-secondary' }}">
                                        {{ $service->featured ? 'Yes' : 'No' }}
                                    </span>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                @if($service->image)
                                    <img src="{{ $service->image_url }}" alt="{{ $service->name }}" class="img-fluid rounded mb-3">
                                @else
                                    <div class="bg-light rounded p-4 text-center">
                                        <i class="fas fa-image fa-3x text-muted"></i>
                                        <p class="text-muted mt-2">No image available</p>
                                    </div>
                                @endif
                            </div>
                        </div>

                        @if($service->include)
                        <div class="mt-4">
                            <h6><strong>What's Included:</strong></h6>
                            <p>{{ $service->include }}</p>
                        </div>
                        @endif

                        @if($service->exclude)
                        <div class="mt-3">
                            <h6><strong>What's Not Included:</strong></h6>
                            <p>{{ $service->exclude }}</p>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Service Statistics -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Service Statistics</h6>
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
                                    <h4 class="text-success">{{ $stats['completed_bookings'] }}</h4>
                                    <p class="text-muted mb-0">Completed</p>
                                </div>
                            </div>
                            <div class="col-md-3 text-center mb-3">
                                <div class="border rounded p-3">
                                    <h4 class="text-warning">${{ number_format($stats['total_revenue'], 2) }}</h4>
                                    <p class="text-muted mb-0">Total Revenue</p>
                                </div>
                            </div>
                            <div class="col-md-3 text-center mb-3">
                                <div class="border rounded p-3">
                                    <h4 class="text-info">{{ $stats['gallery_items'] }}</h4>
                                    <p class="text-muted mb-0">Gallery Items</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Bookings -->
            <div class="col-lg-4">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Recent Bookings</h6>
                    </div>
                    <div class="card-body">
                        @if($service->bookings->count() > 0)
                            @foreach($service->bookings->take(5) as $booking)
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <div>
                                        <h6 class="mb-0">{{ $booking->customer->name ?? 'N/A' }}</h6>
                                        <small class="text-muted">{{ $booking->formatted_preferred_date }}</small>
                                    </div>
                                    <span class="badge {{ $booking->status_badge }}">{{ ucfirst($booking->status) }}</span>
                                </div>
                            @endforeach
                        @else
                            <p class="text-muted">No bookings for this service yet.</p>
                        @endif
                    </div>
                </div>

                <!-- Gallery Items -->
                <div class="card shadow">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Gallery Items</h6>
                    </div>
                    <div class="card-body">
                        @if($service->galleries->count() > 0)
                            @foreach($service->galleries->take(3) as $gallery)
                                <div class="mb-3">
                                    <h6 class="mb-1">{{ $gallery->title }}</h6>
                                    <small class="text-muted">{{ $gallery->short_description }}</small>
                                </div>
                            @endforeach
                        @else
                            <p class="text-muted">No gallery items for this service yet.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Service Modal -->
    <div class="modal fade" id="editServiceModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Service</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form class="ajax-form" action="{{ route('services.update', $service->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Service Name</label>
                                    <input type="text" class="form-control" id="name" name="name" value="{{ $service->name }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="category" class="form-label">Category</label>
                                    <input type="text" class="form-control" id="category" name="category" value="{{ $service->category }}">
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="3" required>{{ $service->description }}</textarea>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="price" class="form-label">Price</label>
                                    <input type="number" class="form-control" id="price" name="price" value="{{ $service->price }}" step="0.01" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="duration" class="form-label">Duration</label>
                                    <input type="text" class="form-control" id="duration" name="duration" value="{{ $service->duration }}">
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="status" class="form-label">Status</label>
                                    <select class="form-control" id="status" name="status" required>
                                        <option value="active" {{ $service->status === 'active' ? 'selected' : '' }}>Active</option>
                                        <option value="inactive" {{ $service->status === 'inactive' ? 'selected' : '' }}>Inactive</option>
                                        <option value="draft" {{ $service->status === 'draft' ? 'selected' : '' }}>Draft</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="image" class="form-label">Image</label>
                                    <input type="file" class="form-control" id="image" name="image" accept="image/*">
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="featured" name="featured" value="1" {{ $service->featured ? 'checked' : '' }}>
                                <label class="form-check-label" for="featured">
                                    Featured Service
                                </label>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="include" class="form-label">What's Included</label>
                            <textarea class="form-control" id="include" name="include" rows="2">{{ $service->include }}</textarea>
                        </div>
                        
                        <div class="mb-3">
                            <label for="exclude" class="form-label">What's Not Included</label>
                            <textarea class="form-control" id="exclude" name="exclude" rows="2">{{ $service->exclude }}</textarea>
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
</x-admin-layout> 