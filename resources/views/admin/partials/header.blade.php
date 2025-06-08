<!-- Bootstrap CSS & FontAwesome -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top shadow-sm px-3">
    <button class="btn btn-outline-light me-3" id="sidebarToggle">
        <i class="fas fa-bars"></i>
    </button>

    <a class="navbar-brand fw-bold" href="#">AdminPanel</a>

    <ul class="navbar-nav ms-auto d-flex align-items-center">
        <!-- Notification Icon -->
        <li class="nav-item dropdown me-3">
            <a class="nav-link position-relative" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fas fa-bell"></i>
                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                    3
                </span>
            </a>
            <ul class="dropdown-menu dropdown-menu-end p-2" style="width: 300px;">
                <li><strong class="dropdown-header">Notifications</strong></li>
                <li>
                    <hr class="dropdown-divider">
                </li>
                <li><a class="dropdown-item" href="#">New Order Received</a></li>
                <li><a class="dropdown-item" href="#">User Signed Up</a></li>
                <li><a class="dropdown-item" href="#">Server Alert: High CPU</a></li>
            </ul>
        </li>

        <!-- Admin User Dropdown -->
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="adminDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <img src="admin-avatar.png" alt="Admin" class="rounded-circle me-2" width="32" height="32" />
                <span>Admin</span>
            </a>
            <ul class="dropdown-menu dropdown-menu-end text-dark">
                <li><a class="dropdown-item text-info" href="#">Profile</a></li>
                <li><a class="dropdown-item text-info" href="#">Settings</a></li>
                <li>
                    <hr class="dropdown-divider">
                </li>
                <li><a class="dropdown-item text-danger" href="{{route('logout')}}">Logout</a></li>
            </ul>
        </li>
    </ul>
</nav>