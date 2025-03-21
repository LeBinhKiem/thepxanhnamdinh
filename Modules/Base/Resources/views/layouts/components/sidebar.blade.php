@php
    $sidebars = config("settings.sidebar",[]);
    $routeNameCurrent = request()->route()->getName();
@endphp
<nav class="navbar navbar-vertical fixed-left navbar-expand-md navbar-light bg-white" id="sidenav-main"
     style="z-index: 2">
    <div class="container-fluid">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#sidenav-collapse-main"
                aria-controls="sidenav-main" aria-expanded="false" aria-label="Toggle navigation">
            <i class="fa-solid fa-bars"></i>
        </button>
        <a class="navbar-brand pt-0 fw-bold" href="/admin">
            TXND Administrator
        </a>
                <ul class="nav align-items-center d-md-none">
                    <li class="nav-item dropdown">
                        <a class="nav-link" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true"
                           aria-expanded="false">
                            <div class="media align-items-center">
                                <span class="avatar avatar-sm rounded-circle">
                                    <img alt="Image placeholder"
                                         onerror="this.onerror=null;this.src='{{ asset("images/avatar-default.png") }}';"
                                         src="{{ \Dinhthang\FileUploader\Services\FileUploaderService::getInstance()->renderUrl($admin->logo) }}">
                                </span>
                            </div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-end">
                            <a href="{{ route("get.admin.setting",["tab" =>"infor"])  }}"
                               class="dropdown-item">
                                <i class="fa-solid fa-gear"></i>
                                <span>Thông tin tài khoản</span>
                            </a>
                            <a href="{{ route("get.auth.logout") }}" class="dropdown-item">
                                <i class="fa-solid fa-person-walking-arrow-right"></i>
                                <span>Đăng xuất</span>
                            </a>
                        </div>
                    </li>
                </ul>
        <div class="collapse navbar-collapse" id="sidenav-collapse-main">
{{--            <h6 class="navbar-heading text-muted">Documentation</h6>--}}
            <ul class="navbar-nav mb-md-3">
                @foreach($sidebars as $index => $sidebar)
                    @if(isset($sidebar["sub"]))
                        @php
                            $active = array_search($routeNameCurrent, \Illuminate\Support\Arr::pluck($sidebar["sub"],"route"))  !== false;
                        @endphp
                        <li class="nav-item nav-parent {{ $active ? "active" : "" }}  pt-1 pb-1">
                            <a class="nav-link rounded-2 {{ $active ? "" : "collapsed" }}  " href="#navbar-{{ $index }}" data-bs-toggle="collapse"
                               role="button"
                               aria-expanded="true" aria-controls="navbar-examples">
                                <i class="{{ $sidebar["icon"] }}"></i>
                                <span class="">{{ $sidebar["name"] }}</span>
                                <span class="icon-arrow ms-2">
                                <i class="fa-solid fa-chevron-up" style="font-size: 11px"></i>
                                </span>
                            </a>
                            <div class="collapse {{ $active ? "show" : "" }}" id="navbar-{{ $index }}">
                                <ul class="nav nav-sm flex-column">
                                    @foreach($sidebar["sub"] as $sub)
                                        @php
                                            $active = $routeNameCurrent == $sub["route"];
                                        @endphp
                                        <li class="nav-item nav-child {{ $active ? "active" : "" }}">
                                            <a class="nav-link rounded-2" style="font-size: 14px;"
                                               href="{{ empty($sub["route"]) ? "" : route($sub["route"]) }}">
                                                {{ $sub["name"] }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </li>
                    @else
                        @php
                            $active = $routeNameCurrent == $sidebar["route"];
                        @endphp
                        <li class="nav-item nav-parent {{ $active ? "active" : "" }} pt-1 pb-1">
                            <a class="nav-link rounded-2"
                               href="{{ empty($sidebar["route"]) ? "" : route($sidebar["route"]) }}">
                                    <i class="{{ $sidebar["icon"] }}"></i>
                                    {{ $sidebar["name"] }}
                            </a>
                        </li>
                    @endif
                @endforeach
            </ul>
        </div>
    </div>
</nav>
