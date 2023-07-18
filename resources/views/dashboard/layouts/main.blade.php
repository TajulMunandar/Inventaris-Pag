<!DOCTYPE html>
<html lang="en">

<head>
    @include('dashboard.layouts.head')
    <title>Inventaris | Dashboard</title>
    <link rel="icon" href="{{ asset('images/logos/logo.png') }}" >
</head>

<body>

    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <!-- Sidebar -->
            @include('dashboard.layouts.sidebar')
            <!-- / Sidebar -->

            <!-- Layout container -->
            <div class="layout-page">
                <!-- Navbar -->
                @include('dashboard.layouts.navbar')
                <!-- / Navbar -->

                <!-- Content wrapper -->
                <div class="content-wrapper">
                    <div class="container-xxl flex-grow-1 container-p-y">
                        <div class="row">
                            <div class="col">
                                <h1 class="fw-bold fs-2 ">{{ $title }}</h1>
                            </div>
                        </div>

                        <!-- Content -->
                        <main>
                            @yield('content')
                        </main>
                    </div>
                    <!-- / Content -->
                    <div class="content-backdrop fade"></div>
                </div>
                <!-- / Content wrapper -->
            </div>
            <!-- / Layout page -->
        </div>

        <!-- Overlay -->
        <div class="layout-overlay layout-menu-toggle"></div>
    </div>
    <!-- / Layout wrapper -->

    @include('dashboard.layouts.script')
</body>

</html>
