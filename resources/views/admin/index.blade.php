<x-admin-layout>
    <!-- Admin Header -->
    <div class="admin-header">
        <div class="d-flex justify-content-between align-items-center">
            <button class="btn btn-outline-secondary d-md-none" id="sidebarToggle">
                <i class="fas fa-bars"></i>
            </button>
            <h1 class="h4 mb-0">Dashboard</h1>
            <a href="" class="btn btn-outline-primary btn-sm">View Site</a>
        </div>
    </div>

    <!-- Admin Content -->
    <div class="admin-content">
        <div class="admin-main">
            <!-- Stats Cards -->
            <div class="row g-4 mb-5">
                <div class="col-md-6 col-lg-3">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-muted mb-1">Total Bookings</h6>
                                    <h3 class="mb-0">127</h3>
                                    <small class="text-success">
                                        <i class="fas fa-arrow-up me-1"></i>
                                        12% from last month
                                    </small>
                                </div>
                                <div class="bg-primary bg-opacity-10 rounded p-3">
                                    <i class="fas fa-calendar fa-2x text-primary"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-3">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-muted mb-1">Customers</h6>
                                    <h3 class="mb-0">89</h3>
                                    <small class="text-success">
                                        <i class="fas fa-arrow-up me-1"></i>
                                        8% from last month
                                    </small>
                                </div>
                                <div class="bg-success bg-opacity-10 rounded p-3">
                                    <i class="fas fa-users fa-2x text-success"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-3">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-muted mb-1">Active Staff</h6>
                                    <h3 class="mb-0">12</h3>
                                    <small class="text-muted">
                                        No change
                                    </small>
                                </div>
                                <div class="bg-warning bg-opacity-10 rounded p-3">
                                    <i class="fas fa-user-check fa-2x text-warning"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-3">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-muted mb-1">Revenue</h6>
                                    <h3 class="mb-0">$18,420</h3>
                                    <small class="text-success">
                                        <i class="fas fa-arrow-up me-1"></i>
                                        15% from last month
                                    </small>
                                </div>
                                <div class="bg-info bg-opacity-10 rounded p-3">
                                    <i class="fas fa-dollar-sign fa-2x text-info"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Bookings -->
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Recent Bookings</h5>
                        <a href="bookings.html" class="btn btn-outline-primary btn-sm">View All</a>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Customer</th>
                                    <th>Service</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                    <th>Amount</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <div>
                                            <div class="fw-medium">Sarah Johnson</div>
                                            <small class="text-muted">sarah@example.com</small>
                                        </div>
                                    </td>
                                    <td>Deep Cleaning</td>
                                    <td>Dec 15, 2024</td>
                                    <td>
                                        <span class="badge status-pending">Pending</span>
                                    </td>
                                    <td>$200</td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-primary">View</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div>
                                            <div class="fw-medium">Mike Rodriguez</div>
                                            <small class="text-muted">mike@example.com</small>
                                        </div>
                                    </td>
                                    <td>Standard Cleaning</td>
                                    <td>Dec 14, 2024</td>
                                    <td>
                                        <span class="badge status-confirmed">Confirmed</span>
                                    </td>
                                    <td>$120</td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-primary">View</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div>
                                            <div class="fw-medium">Emma Davis</div>
                                            <small class="text-muted">emma@example.com</small>
                                        </div>
                                    </td>
                                    <td>Office Cleaning</td>
                                    <td>Dec 13, 2024</td>
                                    <td>
                                        <span class="badge status-completed">Completed</span>
                                    </td>
                                    <td>$80</td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-primary">View</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div>
                                            <div class="fw-medium">John Smith</div>
                                            <small class="text-muted">john@example.com</small>
                                        </div>
                                    </td>
                                    <td>Move-out Cleaning</td>
                                    <td>Dec 12, 2024</td>
                                    <td>
                                        <span class="badge status-in-progress">In Progress</span>
                                    </td>
                                    <td>$250</td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-primary">View</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>