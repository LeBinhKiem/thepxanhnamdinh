@extends('base::layouts.master')
@section("breadcrumb")
    {!! \Diglactic\Breadcrumbs\Breadcrumbs::render("blog_categories") !!}
@endsection
@section('content')
    <form method="get" class="form-inline">
        <div class="row">
            <div class="col-lg-3 col-sm-6 col-md-12 p-2">
                <input type="text" value="{{ form_query("id",$query) }}" name="id" placeholder="Nhập ID"
                       class="form-control form-control-sm w-100">
            </div>
            <div class="col-lg-3 col-sm-6 col-md-12 p-2">
                <input type="text" value="{{ form_query("name",$query) }}" name="name" placeholder="Nhập tên danh mục"
                       class="form-control form-control-sm w-100">
            </div>
            <div class="col-lg-3 col-sm-12 col-md-12 p-2">
                <select class="form-control form-control-sm w-100" name="status">
                    <option value="">--Chọn trạng thái--</option>
                    @foreach(\Modules\Products\Enums\BlogCategoriesEnum::ARR_STATUS as $index => $value)
                        <option {{ selectedCompareValue($query["status"] ?? [], $index) }}
                                value="{{ $index }}"> {{ $value }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-lg-3 col-sm-12 col-md-12 p-2">
                <button type="submit" class="btn btn-success btn-md">
                    <i class="fa-solid fa-filter"></i>
                    Lọc
                </button>
                <a href="{{ route("get.blog_categories.index") }}" class="btn btn-light ">Xóa lọc</a>
            </div>
        </div>

    </form>
    <a href="{{ route("get.blog_categories.create") }}" class="btn btn-primary float-end mb-3">
        <i class="fa-solid fa-plus"></i>
        Thêm mới
    </a>
    <div class="container-table">
        <table class="table" style="table-layout: fixed; width: 100%;">
            <thead class="table-light sticky-top top-0">
            <tr>
                <th scope="col" width="5%">ID</th>
                <th scope="col" class="text-center" width="5%">#</th>
                <th scope="col" width="30%">Tên danh mục</th>
                <th scope="col" width="30%">Danh mục cha</th>
                <th scope="col" width="15%">Trạng thái</th>
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
                                        <a class="dropdown-item"
                                           href="{{ route("get.blog_categories.edit", $item->id) }}">
                                            <i class="fa-regular fa-pen-to-square"></i>
                                            <span>Sửa</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </td>
                        <td>
                            {{ $item->name  }}
                        </td>
                        <td>
                            @if(!empty($item->parent))
                                <div>
                                    #ID: {{ $item->parent->id }}
                                </div>

                                <div>
                                    {{ $item->parent->name  }}
                                </div>
                            @else
                                N/A
                            @endif
                        </td>
                        <td>
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
                    <td colspan="6">Không có dữ liệu</td>
                </tr>
            @endif
            </tbody>
        </table>
    </div>
        {!! \Modules\Base\Helpers\Classics\PaginateHelper::paginate($items, $query) !!}
@endsection
