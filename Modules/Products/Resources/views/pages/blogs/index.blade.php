@extends('base::layouts.master')
@section("breadcrumb")

@endsection
@section('content')
    <form method="get" class="form-inline">
        <input type="text" value="{{ form_query("id",$query) }}" name="id" placeholder="Nhập ID blog"
               class="form-control form-control-sm me-2">
        <input type="text" value="{{ form_query("title",$query) }}" name="title" placeholder="Nhập tên blog"
               class="form-control form-control-sm me-2">
        <select class="form-control form-control-sm me-2" name="blog_category_id">
            <option value="">--Chọn danh mục--</option>
            @foreach($blogCategories as $blogCategory)
                <option {{ selectedCompareValue($query["blog_category_id"] ?? [], $blogCategory->id) }}
                        value="{{ $blogCategory->id }}"> {{ $blogCategory->name }}
                </option>
            @endforeach
        </select>
        <select class="form-control form-control-sm me-2" name="admin_id">
            <option value="">--Chọn admin--</option>
            @foreach($admins as $admin)
                <option {{ selectedCompareValue($query["admin_id"] ?? [], $admin->id) }}
                        value="{{ $admin->id }}"> {{ $admin->name }}
                </option>
            @endforeach
        </select>
        <select class="form-control form-control-sm me-2" name="status">
            <option value="">--Chọn trạng thái--</option>
            @foreach(\Modules\Products\Enums\BLogEnum::ARR_STATUS as $index => $value)
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
            <a href="{{ route("get.blog.index") }}" class="btn btn-light ">Xóa lọc</a>
        </div>
    </form>
    <br>
    <img src="https://i.imgur.com/omJcZka.png" alt="">
    <a href="{{ route("get.blog.create") }}" class="btn btn-primary float-end mb-3">
        <i class="fa-solid fa-plus"></i>
        Thêm mới
    </a>
    <div class="">
        <table class="table" style="table-layout: fixed; width: 100%;">
            <thead class="table-light sticky-top top-0">
            <tr>
                <th scope="col" width="5%">ID</th>
                <th scope="col" width="5%" class="text-center">#</th>
                <th scope="col" width="30%">Bài viết</th>
                <th scope="col" width="15%" class="text-center">Ảnh</th>
                <th scope="col" width="15%">Danh mục</th>
                <th scope="col" class="text-center" width="15%">Trạng thái</th>
                <th scope="col" width="15%">Ngày cập nhật</th>
            </tr>
            </thead>
            <tbody>
            @if(count($items) > 0)
                @foreach($items as $item)
                    <tr>
                        <th scope="row">{{ $item->id }}</th>
                        <td class="text-center">
                            <div class="dropdown">
                                <button class="btn btn-sm  btn-secondary dropdown-toggle" type="button"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                </button>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a class="dropdown-item" href="{{ route("get.blog.edit", $item->id) }}">
                                            <i class="fa-regular fa-pen-to-square"></i>
                                            <span>Sửa</span>
                                        </a>
                                    </li>
                                    <li>
                                        <form method="post" action="{{ route("post.blog.delete") }}">
                                            @csrf
                                            <input type="hidden" name="id" value="{{ $item->id }}">
                                            <button type="submit"
                                                    onclick="return confirm('Bạn chắc chắn muốn xóa?')"
                                                    class="dropdown-item">
                                                <i class="fa-solid fa-trash-can"></i>
                                                <span>Xóa</span>
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </td>
                        <td>
                            <b class="d-block">
                                <a href="">{{ limit_text($item->title, 48) }}</a>
                            </b>
                            <small class="d-block mt-1">#Admin: {{ $item->admin->name  }}</small>
                        </td>
                        <td class="text-center">
                            <div class="avatar avatar-lg rounded-circle ">
                                <img alt="Image placeholder"
                                     onerror="this.onerror=null;this.src='http://admin.tglearning.xyz/images/image-default.jpg';"
                                     src="{{ render_url_upload($item->logo) }}">
                            </div>
                        </td>
                        <td>
                            {{ $item->blogCategory->name }}
                        </td>
                        <td class="text-center">
                            @if($item->status)
                                <span class="badge bg-success">Hiển thị</span>
                            @else
                                <span class="badge bg-danger">Không hiển thị</span>
                            @endif
                        </td>
                        <td>{{ date('d-m-Y H:i:s', strtotime($item->updated_at)) }}</td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="7">Không có dữ liệu</td>
                </tr>
            @endif
            </tbody>
        </table>
    </div>
    {!! \Modules\Base\Helpers\Classics\PaginateHelper::paginate($items, $query) !!}
@endsection
