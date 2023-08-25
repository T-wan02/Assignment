<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

    {{-- Bootstrap --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css">

    {{-- Css link --}}
    @yield('style')
</head>

<body>

    @yield('content')

    {{-- Font-Awesome --}}
    <script src="https://kit.fontawesome.com/9d8e63c428.js" crossorigin="anonymous"></script>
    {{-- Bootstrap js --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
    {{-- Axios link --}}
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    <script>
        // Check if token exists in localStorage
        const accessToken = JSON.parse(localStorage.getItem('access_token'));
        console.log(accessToken);

        if (!accessToken) {
            window.location.href = '/login';
        }
    </script>

    {{-- Script Link --}}
    @yield('script')
</body>

</html>
