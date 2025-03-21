<header class="fixed-top" style="background-color: rgb(50 113 181); box-shadow: 0 .5rem 1rem rgba(0, 0, 0, .15);">
    <div class="container d-flex justify-content-between align-items-center py-3">
        <div class="">
            <a class="text-white fw-bold fs-24px" href="/">
                <img src="{{ render_url_upload($info->logo) }}" alt="" style="width: 50px;">
            </a>
        </div>
        <div class="d-flex">
            <a class="me-4 text-white fs-13px menu" href="/">Trang chủ</a>
            <a class="me-4 text-white fs-13px  menu" href="{{ route("get.introduce.index") }}">Giới thiệu</a>
            <a class="me-4 text-white fs-13px  menu" href="{{ route("get.formation.coaches") }}">Đội hình</a>
            <a class="me-4 text-white fs-13px  menu" href="{{ route("get.match.schedule") }}">Trận đấu</a>
            <a class="me-4 text-white fs-13px  menu" href="https://datve.clbnamdinh.vn/" target="_blank">Mua vé</a>
            <a class="me-4 text-white fs-13px  menu" href="{{ route("get.media.index") }}">Media</a>
            <a class="me-4 text-white fs-13px  menu" href="{{ route("get.sell.search") }}">Cửa hàng</a>
            <a class="me-4 text-white fs-13px  menu" href="{{ route("get.blog.search") }}">Tin tức</a>
            <a class="me-4 text-white fs-13px  menu" href="">Liên Hệ</a>
        </div>
        <div class="d-flex align-items-center">
            <a class="me-4" href="{{ route("get.sell.cart") }}">
                <i class="fa-solid text-white fa-cart-shopping"></i>
            </a>
            @include("sell::layouts.includes._inc_dropdown_option")
        </div>
    </div>
</header>
