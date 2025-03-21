@extends('base::layouts.master')
@section("breadcrumb")
{{--    {!! \Diglactic\Breadcrumbs\Breadcrumbs::render("books") !!}--}}
@endsection
@section('content')
    <form method="get" class="form-inline">
        <input type="text" value="{{ form_query("id",$query) }}" name="id" placeholder="Nhập ID"
               class="form-control form-control-sm me-2">
        <input type="text" value="{{ form_query("name",$query) }}" name="name" placeholder="Nhập tên"
               class="form-control form-control-sm me-2">
        <select class="form-control form-control-sm me-2" name="category_id">
            <option value="">--Chọn danh mục--</option>
            @foreach($categories as $category)
                <option {{ selectedCompareValue($query["category_id"] ?? [], $category->id) }}
                        value="{{ $category->id }}"> {{ $category->name }}
                </option>
            @endforeach
        </select>
        <select class="form-control form-control-sm me-2" name="status">
            <option value="">--Chọn trạng thái--</option>
            @foreach(\Modules\Products\Enums\ProductEnum::ARR_STATUS as $index => $value)
                <option {{ selectedCompareValue($query["status"] ?? [], $index) }}
                        value="{{ $index }}"> {{ $value }}
                </option>
            @endforeach
        </select>
        <br>
        <div class="">
            <button type="submit" class="btn btn-success btn-md">
                <i class="fa-solid fa-filter"></i>
                Lọc
            </button>
            <a href="{{ route("get.products.index") }}" class="btn btn-light ">Xóa lọc</a>
        </div>
    </form>
    <br>
    <a href="{{ route("get.products.create") }}" class="btn btn-primary float-end mb-3">
        <i class="fa-solid fa-plus"></i>
        Thêm mới
    </a>
    <div class="">
        <table class="table" style="table-layout: fixed; width: 100%;">
            <thead class="table-light sticky-top top-0">
            <tr>
                <th scope="col" width="5%">ID</th>
                <th scope="col" width="5%" class="text-center">#</th>
                <th scope="col" width="25%">Sản phẩm</th>
                <th scope="col" width="15%">Giá</th>
                <th scope="col" width="25%">Mô tả</th>
                <th scope="col" class="text-center" width="10%">Trạng thái</th>
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
                                        <a class="dropdown-item" href="{{ route("get.products.edit", $item->id) }}">
                                            <i class="fa-regular fa-pen-to-square"></i>
                                            <span>Sửa</span>
                                        </a>
                                    </li>
                                    <li>
                                        <form method="post" action="{{ route("post.products.delete") }}">
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
                        <td style="word-wrap: break-word; white-space: normal;">
                            <b class="d-block">
                                <a href="">{{ $item->name }}</a>
                            </b>
                            <div class="badge badge-info mt-1 fw-bold">
                                {{ $item->category->name  }}
                            </div>
                            <br>
                            <div class="avatar avatar-lg rounded-circle mt-2  me-2">
                                <img alt="Image placeholder"
                                     onerror="this.onerror=null;this.src='{{ asset("images/image-default.jpg") }}';"
                                     src="{{ render_url_upload($item->image) }}">
                            </div>
                        </td>
                        <td>
                            <div class="" >
                                #Giá gốc: {{ number_format($item->price) }} đ
                            </div>
                            <div class="">
                                #Khuyến mãi: {{ $item->percent_sale }} %
                            </div>
                        </td>
                        <td style="white-space: break-spaces !important;">{{ limit_text($item->description, 200) }}</td>
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
