@extends('sell::layouts.master')
@section("title","Blog")
@section("css")
    <link rel="stylesheet" href='{{ asset("plugins/nice-select2/nice-select2.css") }}'>
    <style>

    </style>
@stop
@section("script")
    <script src="{{ asset("plugins/nice-select2/nice-select2.js") }}"></script>
    <script>
        var options = {searchable: true};
        NiceSelect.bind(document.getElementById("seachable-select"), options);
    </script>
@stop
@section('content')
    <div class="container content mt-4">
        {!! \Diglactic\Breadcrumbs\Breadcrumbs::render("blog") !!}
        <div class="row justify-content-center flex-wrap-reverse">
            <div class="col-lg-8 mt-3 col-sm-12">
                <div class="bg-white shadow rounded-3 p-4 mb-5">
                    <h3 class="text-brown fw-bold">Bài viết mới nhất</h3>
                    <div class="mb-3 fs-14px">Tổng hợp các bài viết, thông tin về câu lạc bộ bóng đá Thép Xanh Nam Định
                    </div>
                    <div class="mb-3">
                        Có <span class="text-danger  fw-bold">{{ $items->total() }}</span> kết quả được tìm thấy
                    </div>
                    @foreach($items as $item)
                        @include("products::pages.blogs.includes.inc_item_blog", $item)
                    @endforeach
                    @if(count($items) > 0)
                        {!! \Modules\Base\Helpers\Classics\PaginateHelper::paginate($items, $query) !!}
                    @endif

                </div>
            </div>
            <div class="col-lg-4 mt-3 col-sm-12 ">
                <div class="p-4 bg-white rounded-3 shadow">
                    <a class="fw-bold" href="{{route('get.blog.search')}}">Tất cả chuyên mục</a>
                    <ul class="mt-3">
                        @foreach($blogCategories as $category)
                            <li class="mb-1" style="list-style-type: none">
                                <a href="{{ route("get.blog.search", ["blog_category_id" => $category["id"]]) }}" class="link-dark {{ form_query("blog_category_id", $query) == $category["id"] ? "fw-bold" : "" }} " href="">{{ $category["name"] }}</a>
                            </li>
                            @if(isset($category["child"]) && count($category["child"]))
                                @foreach($category["child"] as $child)
                                    <li class="ms-5 mb-1">
                                        <a class="link-dark {{ form_query("blog_category_id", $query) == $child["id"] ? "fw-bold" : "" }}" href="{{ route("get.blog.search", ["blog_category_id" => $child["id"]]) }}">{{ $child["name"] }}</a>
                                    </li>
                                @endforeach
                                @endif
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection

