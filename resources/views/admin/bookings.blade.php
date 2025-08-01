<x-admin-layout>
    <!-- Admin Header -->
    <div class="admin-header">
        <div class="d-flex justify-content-between align-items-center">
            <button class="btn btn-outline-secondary d-md-none" id="sidebarToggle">
                <i class="fas fa-bars"></i>
            </button>
            <h1 class="h4 mb-0">Bookings Management</h1>
            <a href="../index.html" class="btn btn-outline-primary btn-sm">View Site</a>
        </div>
    </div>

    <!-- Admin Content -->
    <div class="admin-content">
        <div class="admin-main">
            <!-- Filter Controls -->
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <select class="form-select" id="statusFilter">
                                <option value="">All Statuses</option>
                                <option value="pending">Pending</option>
                                <option value="confirmed">Confirmed</option>
                                <option value="in-progress">In Progress</option>
                                <option value="completed">Completed</option>
                                <option value="cancelled">Cancelled</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <input type="date" class="form-control" id="dateFilter">
                        </div>
                        <div class="col-md-3">
                            <input type="text" class="form-control" placeholder="Search customer..." id="searchFilter">
                        </div>
                        <div class="col-md-3">
                            <button class="btn btn-primary w-100" onclick="applyFilters()">
                                <i class="fas fa-filter me-2"></i>
                                Apply Filters
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bookings List -->
            <div id="bookingsList">
                <!-- Booking Item 1 -->
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-white">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="mb-0">Booking #001</h6>
                                <small class="text-muted">Created Dec 10, 2024</small>
                            </div>
                            <span class="badge status-pending">Pending</span>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row g-4">
                            <div class="col-md-6">
                                <h6 class="mb-2">
                                    <i class="fas fa-user me-2"></i>
                                    Customer Information
                                </h6>
                                <div class="small">
                                    <p class="mb-1"><strong>Name:</strong> Sarah Johnson</p>
                                    <p class="mb-1"><strong>Email:</strong> sarah@example.com</p>
                                    <p class="mb-1"><strong>Phone:</strong> (555) 123-4567</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <h6 class="mb-2">
                                    <i class="fas fa-calendar me-2"></i>
                                    Service Details
                                </h6>
                                <div class="small">
                                    <p class="mb-1"><strong>Service:</strong> Deep Cleaning</p>
                                    <p class="mb-1"><strong>Date:</strong> Dec 15, 2024</p>
                                    <p class="mb-1"><strong>Time:</strong> 10:00 AM</p>
                                    <p class="mb-1"><strong>Amount:</strong> $200</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mt-3">
                            <h6 class="mb-2">
                                <i class="fas fa-map-marker-alt me-2"></i>
                                Service Address
                            </h6>
                            <p class="small mb-0">123 Main Street, Anytown, ST 12345</p>
                        </div>
                        
                        <div class="mt-3">
                            <h6 class="mb-2">Special Instructions</h6>
                            <p class="small bg-light p-2 rounded">Please focus on the kitchen area, especially the oven and refrigerator.</p>
                        </div>

                        <div class="d-flex flex-wrap gap-2 mt-4 pt-3 border-top">
                            <button class="btn btn-success btn-sm" onclick="updateBookingStatus(1, 'confirmed')">
                                <i class="fas fa-check me-1"></i>
                                Confirm
                            </button>
                            <select class="form-select form-select-sm" style="width: auto;" onchange="assignStaff(1, this.value)">
                                <option value="">Assign to staff</option>
                                <option value="1">Sarah Johnson</option>
                                <option value="2">Mike Rodriguez</option>
                                <option value="3">Emma Davis</option>
                            </select>
                            <button class="btn btn-outline-primary btn-sm" onclick="viewBookingDetails(1)">
                                <i class="fas fa-eye me-1"></i>
                                View Details
                            </button>
                            <button class="btn btn-outline-danger btn-sm" onclick="updateBookingStatus(1, 'cancelled')">
                                <i class="fas fa-times me-1"></i>
                                Cancel
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Booking Item 2 -->
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-white">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="mb-0">Booking #002</h6>
                                <small class="text-muted">Created Dec 9, 2024</small>
                            </div>
                            <span class="badge status-confirmed">Confirmed</span>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row g-4">
                            <div class="col-md-6">
                                <h6 class="mb-2">
                                    <i class="fas fa-user me-2"></i>
                                    Customer Information
                                </h6>
                                <div class="small">
                                    <p class="mb-1"><strong>Name:</strong> Mike Rodriguez</p>
                                    <p class="mb-1"><strong>Email:</strong> mike@example.com</p>
                                    <p class="mb-1"><strong>Phone:</strong> (555) 987-6543</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <h6 class="mb-2">
                                    <i class="fas fa-calendar me-2"></i>
                                    Service Details
                                </h6>
                                <div class="small">
                                    <p class="mb-1"><strong>Service:</strong> Standard House Cleaning</p>
                                    <p class="mb-1"><strong>Date:</strong> Dec 14, 2024</p>
                                    <p class="mb-1"><strong>Time:</strong> 2:00 PM</p>
                                    <p class="mb-1"><strong>Amount:</strong> $120</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mt-3">
                            <h6 class="mb-2">
                                <i class="fas fa-map-marker-alt me-2"></i>
                                Service Address
                            </h6>
                            <p class="small mb-0">456 Oak Avenue, Somewhere, ST 12346</p>
                        </div>
                        
                        <div class="mt-3">
                            <h6 class="mb-2">Assigned Staff</h6>
                            <p class="small mb-0">Emma Davis</p>
                        </div>

                        <div class="d-flex flex-wrap gap-2 mt-4 pt-3 border-top">
                            <button class="btn btn-primary btn-sm" onclick="updateBookingStatus(2, 'in-progress')">
                                <i class="fas fa-play me-1"></i>
                                Start Service
                            </button>
                            <button class="btn btn-outline-primary btn-sm" onclick="viewBookingDetails(2)">
                                <i class="fas fa-eye me-1"></i>
                                View Details
                            </button>
                            <button class="btn btn-outline-danger btn-sm" onclick="updateBookingStatus(2, 'cancelled')">
                                <i class="fas fa-times me-1"></i>
                                Cancel
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Booking Item 3 -->
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-white">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="mb-0">Booking #003</h6>
                                <small class="text-muted">Created Dec 8, 2024</small>
                            </div>
                            <span class="badge status-completed">Completed</span>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row g-4">
                            <div class="col-md-6">
                                <h6 class="mb-2">
                                    <i class="fas fa-user me-2"></i>
                                    Customer Information
                                </h6>
                                <div class="small">
                                    <p class="mb-1"><strong>Name:</strong> Emma Davis</p>
                                    <p class="mb-1"><strong>Email:</strong> emma@example.com</p>
                                    <p class="mb-1"><strong>Phone:</strong> (555) 456-7890</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <h6 class="mb-2">
                                    <i class="fas fa-calendar me-2"></i>
                                    Service Details
                                </h6>
                                <div class="small">
                                    <p class="mb-1"><strong>Service:</strong> Office Cleaning</p>
                                    <p class="mb-1"><strong>Date:</strong> Dec 13, 2024</p>
                                    <p class="mb-1"><strong>Time:</strong> 9:00 AM</p>
                                    <p class="mb-1"><strong>Amount:</strong> $80</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mt-3">
                            <h6 class="mb-2">
                                <i class="fas fa-map-marker-alt me-2"></i>
                                Service Address
                            </h6>
                            <p class="small mb-0">789 Business Blvd, Corporate City, ST 12347</p>
                        </div>
                        
                        <div class="mt-3">
                            <h6 class="mb-2">Assigned Staff</h6>
                            <p class="small mb-0">Sarah Johnson</p>
                        </div>

                        <div class="d-flex flex-wrap gap-2 mt-4 pt-3 border-top">
                            <button class="btn btn-outline-success btn-sm" disabled>
                                <i class="fas fa-check me-1"></i>
                                Completed
                            </button>
                            <button class="btn btn-outline-primary btn-sm" onclick="viewBookingDetails(3)">
                                <i class="fas fa-eye me-1"></i>
                                View Details
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>