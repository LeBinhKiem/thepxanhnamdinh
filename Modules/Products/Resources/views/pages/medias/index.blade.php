@extends('base::layouts.master')
@section("breadcrumb")
    {{--    {!! \Diglactic\Breadcrumbs\Breadcrumbs::render("books") !!}--}}
@endsection
@section('content')
    <form method="get" class="form-inline">
        <input type="text" value="{{ form_query("id",$query) }}" name="id" placeholder="Nhập ID"
               class="form-control form-control-sm me-2">
        <input type="text" value="{{ form_query("name",$query) }}" name="title" placeholder="Nhập tiêu đề"
               class="form-control form-control-sm me-2">
        {{--        <select class="form-control form-control-sm me-2" name="book_cate_id">--}}
        {{--            <option value="">--Chọn danh mục--</option>--}}
        {{--            @foreach($categories as $category)--}}
        {{--                <option {{ selectedCompareValue($query["category_id"] ?? [], $category->id) }}--}}
        {{--                        value="{{ $category->id }}"> {{ $category->name }}--}}
        {{--                </option>--}}
        {{--            @endforeach--}}
        {{--        </select>--}}
        <br>
        <div class="">
            <button type="submit" class="btn btn-success btn-md">
                <i class="fa-solid fa-filter"></i>
                Lọc
            </button>
            <a href="{{ route("get.medias.index") }}" class="btn btn-light ">Xóa lọc</a>
        </div>
    </form>
    <br>
    <a href="{{ route("get.medias.create") }}" class="btn btn-primary float-end mb-3">
        <i class="fa-solid fa-plus"></i>
        Thêm mới
    </a>
    <div class="">
        <table class="table" style="table-layout: fixed; width: 100%;">
            <thead class="table-light sticky-top top-0">
            <tr>
                <th scope="col" width="5%">ID</th>
                <th scope="col" width="5%" class="text-center">#</th>
                <th scope="col" width="30%">Tiêu đề</th>
                <th scope="col" width="20%">Hình ảnh</th>
                <th scope="col" width="25%">Youtube</th>
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
                                        <a class="dropdown-item" href="{{ route("get.medias.edit", $item->id) }}">
                                            <i class="fa-regular fa-pen-to-square"></i>
                                            <span>Sửa</span>
                                        </a>
                                    </li>
                                    <li>
                                        <form method="post" action="{{ route("post.medias.delete") }}">
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
                        <td style="text-wrap: wrap">
                            {{ $item->title }}
                        </td>

                        <td>
                            <div class="image image-lg rounded-circle mt-2 me-2">
                                <img alt="Image placeholder" style="width: 150px; height: 100px"
                                     onerror="this.onerror=null;this.src='{{ asset("images/image-default.jpg") }}';"
                                     src="{{ render_url_upload($item->image) }}">
                            </div>
                        </td>
                        <td>
                            @if(!empty($item->youtube))
                                <iframe width="250" height="150"
                                        src="{{ $item->youtube }}"
                                        title="YouTube video player" frameborder="0"
                                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                        referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
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
