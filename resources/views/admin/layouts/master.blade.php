<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('admin/css/style.css') }}">
    <!-- DataTables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <!-- Add SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    <!-- Add SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>



</head>

<body>
    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script>
        function toggleTheme() {
            document.body.classList.toggle("dark-mode");
        }
    </script>

    <script>
        const sidebarToggle = document.getElementById("sidebarToggle");
        const sidebar = document.getElementById("sidebar");
        const mainContent = document.getElementById("mainContent");

        sidebarToggle.addEventListener("click", function() {
            if (window.innerWidth < 992) {
                // For mobile devices, slide the sidebar in/out
                sidebar.classList.toggle("active");
            } else {
                // For larger screens, collapse/expand the sidebar
                sidebar.classList.toggle("collapsed");
                mainContent.classList.toggle("collapsed");
            }
        });

        // Placeholder function for theme toggle
        function toggleTheme() {
            document.body.classList.toggle("dark-theme");
        }
    </script>




    <div class="wrapper d-flex">
        @include('admin.partials.header')
        @include('admin.pages.leftsidebar')



        <div class="main-content flex-grow-1 p-3">

            @yield('content')
        </div>
    </div>

    @include('admin.partials.footer')
    <!-- Footer -->
    @stack('script')
</body>

</html>