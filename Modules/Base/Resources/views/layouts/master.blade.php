<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/png" href="{{ asset("images/logo/logo_icon.png") }}">
    <title>Admin</title>
    <link rel="stylesheet" href='{{ asset("vendor/base/css/base.css") }}'>
    <link rel="stylesheet" href='{{ asset("plugins/font-awesome/all.min.css") }}'>
    <link rel="stylesheet" href='{{ asset("plugins/toastr/toastr.min.css") }}'>
    @yield('css')
</head>
@php
    $admin = get_admin();
@endphp
<body>
<div class="container-admin">
    @include("base::layouts.components.sidebar")
    <div class="content">
        @include("base::layouts.components.header")
        <div class="container-md mt-4 mb-4">
            @yield('breadcrumb')
            <div class="bg-white bg-custom p-4 rounded-1 container-fluid" style="min-height: 800px">
                @yield('content')
            </div>
        </div>
        @include("base::layouts.components.footer")
    </div>
</div>
</body>
<script src="{{ asset("/plugins/jquery/jquery.js") }}"></script>
<script src="{{ asset("vendor/base/js/base.js") }}"></script>
<script src="{{ asset("/plugins/bootstrap/popper.min.js") }}"></script>
<script src="{{ asset("/plugins/bootstrap/bootstrap.bundle.min.js") }}"></script>
<script src="{{ asset("plugins/toastr/toastr.min.js") }}"></script>

<script type="text/javascript">
    $(document).ready(function () {
        $("body").tooltip({selector: '[data-bs-toggle=tooltip]'});
        $(".content").click(function (e) {
            let sibarMobile = $("#sidenav-collapse-main");
            if (sibarMobile.hasClass("show")) {
                sibarMobile.removeClass("show")
            }
        })
    });
</script>

@yield('script')
</html>
