<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <title>Website</title>
    <link rel="stylesheet" href='{{ asset("vendor/base/css/base.css") }}'>
    <link rel="stylesheet" href='{{ asset("plugins/font-awesome/all.min.css") }}'>
    <link rel="stylesheet" href='{{ asset("plugins/toastr/toastr.min.css") }}'>
    @yield('css')
    <style>
        .btn-primary-web {
            background-color: rgb(50 113 181);
            color: white;
        }

        .btn-primary-web:hover {
            background-color: rgb(50 113 181);
            color: white;
        }

        .text-primary-web {
            color: rgb(50 113 181) !important;
        }

        .strikethrough {
            text-decoration: line-through;
        }

        .bg-primary-web {
            background-color: rgb(50 113 181)
        }

        .header-content .menu:hover {
            color: white !important;
            font-weight: bold;
        }

        .content {
            min-height: 800px;
        }
        .second-row-dot {
            -webkit-box-orient: vertical;
            -webkit-line-clamp: 2;
            display: -webkit-box;
            overflow: hidden;
        }
    </style>
    
</head>
<body>
@php
    $info = \Illuminate\Support\Facades\DB::table("info")->first();
@endphp
<div class="header-content d-flex flex-column">

    @include("sell::layouts.includes.header")

    <div class="content bg-white" style="margin-top: 86px">
        @yield("content")
    </div>
    
    @include("sell::layouts.includes.footer")
</div>
<script src="{{ asset("/plugins/jquery/jquery.js") }}"></script>
<script src="{{ asset("vendor/base/js/base.js") }}"></script>
<script src="{{ asset("/plugins/bootstrap/popper.min.js") }}"></script>
<script src="{{ asset("/plugins/bootstrap/bootstrap.bundle.min.js") }}"></script>
<script src="{{ asset("plugins/toastr/toastr.min.js") }}"></script>
<script src="{{ asset("vendor/base/js/vote.js") }}"></script>

<script>
    $(document).ready(function () {
        $("body").tooltip({selector: '[data-toggle=tooltip]', placement: 'top'});
    });
</script>
@yield('script')
</body>
</html>