<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
    <link rel="stylesheet" href='{{ asset("vendor/base/css/base.css") }}'>
    <link rel="stylesheet" href='{{ asset("vendor/auth/css/auth.css") }}'>
    <link rel="stylesheet" href='{{ asset("plugins/font-awesome/all.min.css") }}'>
    @yield("css")
</head>
<body class="vh-100 body-auth d-flex align-items-center justify-content-center">
<div class="bg-white container w-25 d-flex rounded-3 shadow-sm">
    <div class="login-left">
        <p class="fs-6 login-left__header text-center mt-4">ADMIN</p>
        @yield("content")

    </div>
   {{-- <div class="login-right d-flex align-content-center">
       <img class="img-login rounded-end-3" src="{{ asset("images/auth-login.png") }}" alt="">
   </div> --}}
</div>
<script src="{{ asset("/plugins/jquery/jquery.js") }}"></script>
@yield("script")
</body>
</html>
