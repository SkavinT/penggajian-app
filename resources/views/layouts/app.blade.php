<!-- filepath: resources/views/layouts/app.blade.php -->
<!DOCTYPE html>
<html lang="id">
    @include('layouts.head')
<body id="page-top" class="bg-light">

    <div id="wrapper" class="d-flex">
        {{-- Sidebar --}}
        @include('layouts.sidebar')

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column w-100">
            <!-- Main Content -->
            <div id="content">
                {{-- Topbar --}}
                @include('layouts.topbar')

                <!-- Begin Page Content -->
                <main class="container-fluid py-4">
                    @yield('content')
                </main>
                <!-- End Page Content -->
            </div>
            {{-- Footer --}}
            @include('layouts.footer')
        </div>
    </div>

    @include('layouts.script')
    @stack('scripts')
</body>
</html>