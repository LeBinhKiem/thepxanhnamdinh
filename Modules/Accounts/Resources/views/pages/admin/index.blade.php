@extends('base::layouts.master')
@section("breadcrumb")
    {!! \Diglactic\Breadcrumbs\Breadcrumbs::render("admin") !!}
@endsection

@section('content')
    <form method="get" class="form-inline">
        <input type="text" value="{{ form_query("id",$query) }}" name="id" placeholder="Nhập ID"
               class="form-control form-control-sm me-2">
        <input type="text" value="{{ form_query("name",$query) }}" name="name" placeholder="Nhập họ tên"
               class="form-control form-control-sm me-2">
        <input type="text" value="{{ form_query("email",$query) }}" name="email" placeholder="Nhập email"
               class="form-control form-control-sm me-2">
        <input type="text" value="{{ form_query("email",$query) }}" name="phone_number" placeholder="Nhập số điện thoại"
               class="form-control form-control-sm me-2">
        <select class="form-control form-control-sm me-2" name="status">
            <option value="">--Chọn trạng thái--</option>
            @foreach(\Modules\Accounts\Models\Enums\AdminEnum::ARR_STATUS as $index => $value)
                <option {{ selectedCompareValue($query["status"] ?? [], $index) }}
                        value="{{ $index }}"> {{ $value }}
                </option>
            @endforeach
        </select>
        <div class="mt-3">
            <button type="submit" class="btn btn-success btn-md">
                <i class="fa-solid fa-filter"></i>
                Lọc
            </button>
            <a href="{{ route("get.admin.index") }}" class="btn btn-light ">Xóa lọc</a>
        </div>
    </form>

        <a href="{{ route("get.admin.create") }}" class="btn btn-primary float-end mb-3">
            <i class="fa-solid fa-plus"></i>
            Thêm mới
        </a>

        <br>
        
        <div class="">
            <table class="table" style="table-layout: fixed; width: 100%;">
                <thead class="table-light sticky-top top-0">
                <tr>
                    <th scope="col" width="5%">ID</th>
                    <th scope="col" width="5%" class="text-center">#</th>
                    <th scope="col" width="30%">Thông tin</th>
                    <th scope="col" width="15%" class="text-center">Ảnh</th>
                    <th scope="col" width="15%">Thông tin liên hệ</th>
                    <th scope="col" class="text-center" width="15%">Trạng thái</th>
                    <th scope="col" width="15%">Ngày cập nhật</th>
                </tr>
                </thead>
                <tbody>
                @if(count($items) > 0)
                    @foreach($items as $item)
                        <tr class="{{ $item->id == get_admin()->id ? 'highlight-admin' : '' }}">
                            <th scope="row">{{ $item->id }}</th>
                            <td class="text-center">
                                <div class="dropdown">


                                    @if($isSuperAdmin)
                                        <button class="btn btn-sm  btn-secondary dropdown-toggle" type="button"
                                            data-bs-toggle="dropdown" aria-expanded="false">
                                        </button>
                                        <ul class="dropdown-menu">
                                            @if($item->permission == \Modules\Accounts\Models\Enums\AdminEnum::NORMAL_ADMIN)
                                                <li>
                                                    <a class="dropdown-item"
                                                        href="{{ route("get.admin.edit", $item->id) }}">
                                                        <i class="fa-regular fa-pen-to-square"></i>
                                                        <span>Sửa</span>
                                                    </a>
                                                </li>
                                            @endif
                                                <li>
                                                    <a class="dropdown-item"
                                                        href="{{ route("get.admin.updatePassword", $item->id) }}">
                                                        <i class="fa-solid fa-user-gear"></i>
                                                        <span>Thay đổi mật khẩu</span>
                                                    </a>
                                                </li>
                                        </ul>
                                    @endif

                                    @if($isNomarAdmin)
                                        @if($item->permission == \Modules\Accounts\Models\Enums\AdminEnum::SUPER_ADMIN || $item->id != get_admin()->id)
                                            <button class="btn btn-sm  btn-secondary dropdown-toggle" type="button"
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li>
                                                    <a class="dropdown-item"
                                                        href="{{ route("get.admin.edit", $item->id) }}">
                                                        <i class="fa-regular fa-pen-to-square"></i>
                                                        <span>Sửa</span>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item"
                                                        href="{{ route("get.admin.updatePassword", $item->id) }}">
                                                        <i class="fa-solid fa-user-gear"></i>
                                                        <span>Thay đổi mật khẩu</span>
                                                    </a>
                                                </li>
                                            </ul>
                                        @endif
                                    @endif

                                    
                                </div>
                            </td>
                            <td width="30%">
                                <div class="d-flex align-items-center">
                                    <b>{{ $item->name }}</b>
                                    {!! $item->permission == 0 ? "<span class='badge bg-info ms-2'>Super Admin</span>" : "" !!}
                                </div>
                                <div class="mt-2">
                                    <i class="fa-regular fa-envelope"></i> Email: {{ $item->email }}
                                </div>
                                <div>
                                    <i class="fa-solid fa-mars-and-venus"></i> Giới
                                    tính: {{ \Modules\Accounts\Models\Enums\AdminEnum::ARR_SEX[$item->sex] }}
                                </div>
                            </td>
                            <td class="text-center">
                            <span class="avatar avatar-lg rounded-circle me-2 border">
                                    <img alt="Image placeholder"
                                         onerror="this.onerror=null;this.src='{{ asset("images/avatar-default.png") }}';"
                                         src="{{ \Dinhthang\FileUploader\Services\FileUploaderService::getInstance()->renderUrl($item->logo) }}">
                                 </span>
                            </td>
                            <td width="30%">
                                <div>
                                    SĐT: {{ $item->phone_number ?? "Đang cập nhật" }}
                                </div>
                                <div>
                                    Skype: {{ $item->skype ?? "Đang cập nhật" }}
                                </div>
                            </td>
                            <td class="text-center">
                                @if($item->status)
                                    <span class="badge bg-success">Hoạt động</span>
                                @else
                                    <span class="badge bg-danger">Dừng hoạt động</span>
                                @endif
                            </td>
                            <td>{{ date('d-m-Y H:i:s', strtotime($item->updated_at)) }}</td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="8">Không có dữ liệu</td>
                    </tr>
                @endif
                </tbody>
            </table>
        </div>
        {!! \Modules\Base\Helpers\Classics\PaginateHelper::paginate($items, $query) !!}
        @endsection
