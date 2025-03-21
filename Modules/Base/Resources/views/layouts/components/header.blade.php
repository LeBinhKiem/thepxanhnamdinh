<div class="header bg-white d-flex justify-content-end align-content-center fixed">
    <ul class="navbar-nav align-items-center d-flex justify-content-center me-3">
        <li class="nav-item dropdown">
            <a class="nav-link pr-0 " href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true"
               aria-expanded="false">
                <div class="media align-items-center">
                    <span class="avatar avatar-sm rounded-circle me-2">
                        <img alt="Image placeholder"
                             onerror="this.onerror=null;this.src='{{ asset("images/avatar-default.png") }}';"
                             src="{{ \Dinhthang\FileUploader\Services\FileUploaderService::getInstance()->renderUrl($admin->logo) }}">
                    </span>
                    <div class="media-body ml-2 d-none d-lg-block">
                        <span class="mb-0 text-sm  font-weight-bold">{{ $admin->name }}</span>
                    </div>
                    <i class="fa-solid fa-chevron-down ms-2" style="font-size: 11px"></i>
                </div>
            </a>
            <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-right">
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
</div>