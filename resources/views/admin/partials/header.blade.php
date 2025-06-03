<nav class="navbar fixed-top p-3 custom-navbar d-flex align-items-center">
    <!-- Sidebar Toggle Button -->
    <button id="sidebarToggle" class="btn btn-outline-secondary me-3">
        <i class="fas fa-arrow-left"></i>
    </button>
    <span> Welcome to my Dashboard </span>
    <a class="navbar-brand ms-auto" href="#">
        <img src="logo.png" alt="Logo" width="40" />
    </a>
    <div class="d-flex align-items-center ms-auto">
        <span class="me-3 theme-toggle" onclick="toggleTheme()">
            <img src="theme-icon.png" alt="Theme Toggle" width="25" />
        </span>
        <div class="dropdown">
            <span class="text-info dropdown-toggle" id="settingsDropdown" data-bs-toggle="dropdown">
                <img src="settings-icon.png" alt="Settings" width="25" />
            </span>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="settingsDropdown">
                <li><a class="dropdown-item" href="#">Profile</a></li>
                <li>
                    <a class="dropdown-item" data-bs-toggle="offcanvas" href="#notificationCanvas" role="button" aria-controls="notificationCanvas">
                        Notifications
                    </a>
                </li>

                <li><a class="dropdown-item" href="#">Logout</a></li>
            </ul>
        </div>
    </div>
</nav>
<!-- Notification Offcanvas -->
<div class="offcanvas offcanvas-end" tabindex="-1" id="notificationCanvas" aria-labelledby="notificationCanvasLabel">
    <div class="offcanvas-header">
        <h5 id="notificationCanvasLabel">Notifications</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <p>No new notifications.</p>
        <!-- You can load dynamic notification content here -->
    </div>
</div>