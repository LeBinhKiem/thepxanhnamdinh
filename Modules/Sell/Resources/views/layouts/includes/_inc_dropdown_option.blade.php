@php
    $user = get_user();
@endphp
<div class="d-flex align-items-center">
    <div class="pe-3 ps-3 js-open-search-mobile w-ssm-37px h-ssm-37px hide"><i class="fa-solid fa-magnifying-glass fs-ssm-12px"></i></div>
    <div class="d-flex align-items-center header-option ">
        @if(empty($user))
            <div class="d-flex login-account">
                <a href="{{ route("get.auth_user.login") }}" class="text-white fs-20px menu"><i class="fa-solid fa-right-to-bracket"></i></a>
                {{-- <a href="{{ route("get.auth_user.register") }}" class="text-white fs-13px menu">Đăng ký</a> --}}
            </div>
        @else
            <div id="info" class="ms-2">
                <div class="avatar d-flex align-items-center justify-content-center bg-white w-ssm-36px h-ssm-36px"
                     style="width: 48px; height: 48px; overflow: hidden; border-radius: 50%; border: 2px solid #ccc">
                     
                    <img style="width: 55px;"
                         data-bs-toggle="dropdown" aria-expanded="false"
                         class="dropdown-toggle w-ssm-37px h-ssm-37px"
                         onerror="this.onerror=null;this.src='{{ asset("images/avatar-default.png") }}';"
                         src="{{ render_url_upload($user->logo) }}">
                    <ul class="dropdown-menu p-3" aria-labelledby="dropdownMenuButton1">
                        <li class="border-bottom">
                            <a href="{{ route("get.user.profile") }}"
                               class="d-flex p-3 dropdown-item justify-content-between me-1 align-items-center">
                                    <span style="width: 50px; height: 50px; border-radius: 50%"
                                          class="overflow-hidden border bg-white d-flex justify-content-center align-items-center border-1">
                                        <img style="width: 55px; "
                                             data-bs-toggle="dropdown" aria-expanded="false"
                                             class="dropdown-toggle"
                                             onerror="this.onerror=null;this.src='{{ asset("images/avatar-default.png") }}';"
                                             src="{{ render_url_upload($user->logo) }}">
                                    </span>
                                <b class="ms-2">
                                    <div href="" class="text-brown">{{ limit_text($user->full_name, 15) }}</div>
                                    <div href="" class="fs-12px">Thiết lập tài khoản</div>
                                </b>
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item pt-2 pb-2 border-bottom" href="{{ route("get.sell.order") }}">
                                <i class="fa-solid fa-bag-shopping p-2 "></i>
                                Quản lý đơn hàng
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item pt-2 pb-2" href="{{ route("get.auth_user.logout") }}">
                                <i class="fa-solid fa-right-from-bracket p-2 "></i>
                                Đăng xuất
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        @endif
    </div>
</div>
