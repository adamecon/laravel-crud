<!DOCTYPE html>
<html lang="en">

<head>
    @include('admin.css')
</head>

<body>
    <div class="container-scroller">
        @include('admin.sidebar');

        <!-- partial -->
        @include('admin.navbar');
        <!-- partial -->
        @include('admin.body');
        <!-- plugins:js -->
        @include('admin.script')
</body>

</html>