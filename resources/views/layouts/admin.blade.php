<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Delvora</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="{{asset('assets/css/style.css')}}" rel="stylesheet">
</head>
<body>
    <!-- Admin Sidebar -->
    <div class="admin-sidebar">
        <div class="p-4">
            <h4 class="text-white mb-0">Delvora Admin</h4>
        </div>
        <nav class="nav flex-column">
            <a class="nav-link active" href="{{route('dashboard')}}">
                <i class="fas fa-chart-bar me-2"></i>
                Dashboard
            </a>
            <a class="nav-link" href="{{route('bookings')}}">
                <i class="fas fa-calendar me-2"></i>
                Bookings
            </a>
            <a class="nav-link" href="{{route('customers')}}">
                <i class="fas fa-users me-2"></i>
                Customers
            </a>
            <a class="nav-link" href="{{route('staff')}}">
                <i class="fas fa-user-check me-2"></i>
                Staff
            </a>
            <a class="nav-link" href="{{route('services')}}">
                <i class="fas fa-cogs me-2"></i>
                Services
            </a>
            <a class="nav-link" href="{{route('gallery')}}">
                <i class="fas fa-images me-2"></i>
                Gallery
            </a>
            <a class="nav-link" href="{{route('settings')}}">
                <i class="fas fa-cog me-2"></i>
                Settings
            </a>
            <hr class="text-muted">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-outline-light btn-sm w-100">
                    <i class="fas fa-power-off me-1"></i> Logout
                </button>
            </form>
        </nav>
    </div>

    {{$slot}}

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{asset('assets/js/admin.js')}}"></script>
    <script src="{{asset('assets/js/script.js')}}"></script>
</body>
</html>
