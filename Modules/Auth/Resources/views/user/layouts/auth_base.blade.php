<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
    <link rel="stylesheet" href='{{ asset("plugins/font-awesome/all.min.css") }}'>
    <link rel="stylesheet" href='{{ asset("plugins/bootstrap/bootstrap.min.css") }}'>
    <link rel="stylesheet" href='{{ asset("vendor/base/css/base.min.css") }}'>
    <link rel="stylesheet" href='{{ asset("vendor/auth/css/auth.css") }}'>
    @yield("css")
</head>
<body class="vh-100 body-auth d-flex align-items-center justify-content-center">
<div class="col-4 bg-white container-auth d-flex rounded-3 shadow-sm">
    <div class="login-left">
        <p class="fs-6 text-center mt-5">NGƯỜI DÙNG</p>
        @yield("content")
    </div>
</div>
</body>
<script src="{{ asset("plugins/jquery/jquery.js") }}"></script>
@yield("script")
<script>
    $(".show-password").click(function () {
        if ($(this).hasClass("active")) {
            $(this).removeClass("active")
            $("#password").attr("type", "password")
        } else {
            $(this).addClass("active")
            $("#password").attr("type", "text")
        }
    })
</script>
</html>
