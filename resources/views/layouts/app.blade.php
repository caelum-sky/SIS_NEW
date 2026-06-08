<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@mdi/font/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="assets/css/custom-style.css">
   
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>

</head>


<body class="bg-dark">

    <div class="container-scroller">
        <nav class="navbar navbar-expand-lg bg-black text-white shadow-sm">
            <div class="container-fluid">
                <a class="navbar-brand fw-bold text-white" href="/dashboard">@yield('title')</a>
                <div class="d-flex align-items-center">
                    <h5 class="me-3 m-0">Hello, {{ auth()->user()->name }}</h5>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn btn-outline-light">Logout</button>
                    </form>
                </div>
            </div>
        </nav>

        <div class="d-flex">
            <nav class="sidebar bg-black text-white p-3" style="width: 250px; min-height: 100vh;">
                <ul class="nav flex-column">
                    <li class="nav-item my-2">
                        <a class="nav-link text-white" href="/students">
                            <i class="bi bi-person-lines-fill"></i> Student List
                        </a>
                    </li>
                    <li class="nav-item my-2">
                        <a class="nav-link text-white" href="/subjects">
                            <i class="bi bi-book"></i> Subject List
                        </a>
                    </li>
                    <li class="nav-item my-2">
                        <a class="nav-link text-white" href="{{ route('profile.edit') }}">
                            <i class="bi bi-person-circle"></i> Edit Profile
                        </a>
                    </li>
                </ul>
            </nav>

        <!-- Page Content -->
        <div class="content container-fluid p-4">
            {{ $slot }}
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#triggerModal').on('show.bs.modal', function (event) {
                let button = $(event.relatedTarget);  // Button that triggered the modal
                let modal = $(this);

                // Extract data attributes
                modal.find('.modal-title').text('Edit Student - ' + button.data('name'));
                modal.find('form').attr('action', button.data('action'));
                modal.find('[name="name"]').val(button.data('name'));
                modal.find('[name="email"]').val(button.data('email'));
                modal.find('[name="address"]').val(button.data('address'));
                modal.find('[name="course"]').val(button.data('course'));
            });
        });
    </script>
</body>
