@extends('base::layouts.master')
@section("breadcrumb")
    {!! \Diglactic\Breadcrumbs\Breadcrumbs::render("admin") !!}
@endsection
@section('content')
    <form method="get" class="form-inline">
        <input type="text" value="{{ form_query("id",$query) }}" name="id" placeholder="Nhập ID"
               class="form-control form-control-sm me-2">
        <input type="text" value="{{ form_query("email",$query) }}" name="email" placeholder="Nhập email"
               class="form-control form-control-sm me-2">
        <input type="text" value="{{ form_query("name",$query) }}" name="name" placeholder="Nhập tên tài khoản"
               class="form-control form-control-sm me-2">
        <select class="form-control form-control-sm me-2" name="status">
            <option value="">--Chọn trạng thái--</option>
            @foreach(\Modules\Accounts\Models\Enums\UserEnum::ARR_STATUS as $index => $value)
                <option {{ selectedCompareValue($query["status"] ?? [], $index) }}
                        value="{{ $index }}"> {{ $value }}
                </option>
            @endforeach
        </select>
        <div class="">
            <button type="submit" class="btn btn-success btn-md">
                <i class="fa-solid fa-filter"></i>
                Lọc
            </button>
            <a href="{{ route("get.user.index") }}" class="btn btn-light ">Xóa lọc</a>
        </div>
    </form>
    <div class="mt-3">
        <table class="table" style="table-layout: fixed; width: 100%;">
            <thead class="table-light sticky-top top-0">
            <tr>
                <th scope="col" width="5%">ID</th>
                <th scope="col" width="5%" class="text-center">#</th>
                <th scope="col" width="30%">Thông tin cơ bản</th>
                <th scope="col" width="30%" class="text-center">Ảnh</th>
                <th scope="col" class="text-center" width="15%">Trạng thái</th>
                <th scope="col" width="15%">Ngày cập nhật</th>
            </tr>
            </thead>
            <tbody>
            @if(count($items) > 0)
                @foreach($items as $item)
                    @include("accounts::pages.user.includes._inc_modal_lock",["item" => $item])
                    <tr>
                        <th scope="row">{{ $item->id }}</th>
                        <td class="text-center">
                            <div class="dropdown">
                                <button class="btn btn-sm  btn-secondary dropdown-toggle" type="button"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                </button>
                                <ul class="dropdown-menu">
                                    @if($item->status == \Modules\Accounts\Models\Enums\UserEnum::STATUS_ACTIVE)
                                        <li>
                                            <button class="dropdown-item" data-bs-toggle="modal"
                                                    data-bs-target="#lock-{{ $item->id }}">
                                                <i class="fa-solid fa-user-gear"></i>
                                                <span>Khóa</span>
                                            </button>
                                        </li>
                                    @else
                                        <li>
                                            <form action="{{ route("post.user.unLock") }}" method="post">
                                                @csrf
                                                <input type="hidden" name="id" value="{{ $item->id }}">
                                                <button class="dropdown-item" type="submit">
                                                    <i class="fa-solid fa-user-gear"></i>
                                                    <span>Mở khóa</span>
                                                </button>
                                            </form>
                                        </li>
                                    @endif
                                </ul>
                            </div>
                        </td>
                        <td width="30%">
                            <div class="d-flex align-items-center">
                                <b>{{ $item->full_name }}</b>
                            </div>
                            <div class="mt-2">
                                <i class="fa-regular fa-envelope"></i> Email: {{ $item->email }}
                            </div>
                            <div class="mt-2">
                                <i class="fa-solid fa-user"></i> Tài khoản: {{ $item->name }}
                            </div>
                            @if($item->status == \Modules\Accounts\Models\Enums\UserEnum::STATUS_UN_ACTIVE)
                                <div class="mt-3">
                                    <span class="fw-bold text-danger">Lý do khóa:</span> {{ $item->reasonLock->reason ?? "Đang cập nhật" }}
                                </div>
                            @endif
                        </td>
                        <td class="text-center">
                                        <span class="avatar avatar-lg rounded-circle me-2 border">
                                                <img alt="Image placeholder"
                                                     onerror="this.onerror=null;this.src='{{ asset("images/avatar-default.png") }}';"
                                                     src="{{ \Dinhthang\FileUploader\Services\FileUploaderService::getInstance()->renderUrl($item->logo) }}">
                                             </span>
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
