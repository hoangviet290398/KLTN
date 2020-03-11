<!DOCTYPE html>
<html class="h-100">
<head>
    @include('layout.css')
    @yield('css')
    <title>@yield('title')</title>
</head>
<body background="{{ asset('images/resource/sky.jpg') }}" style="height: 100%;background-repeat: no-repeat;background-attachment: fixed;background-size: 100% 100%">

    @yield('content')

    @include('layout.js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js"></script>
    @yield('js')
</body>

</html>
