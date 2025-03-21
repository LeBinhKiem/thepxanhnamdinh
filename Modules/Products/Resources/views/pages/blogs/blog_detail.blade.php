@extends('sell::layouts.master')
@section("title",$item->title)
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
    <div class="container content">
        <div class="row mt-4 mb-5">
            <div class="col-lg-10  mx-auto">
                <div class="shadow-lg">
                    <img src="{{ render_url_upload($item->logo) }}" alt="" class="w-100" height="446" style="vertical-align: middle;">
                    <div class="px-5 pb-5 pt-3 bg-white">
                        <h1 class="fw-bolder">{{ $item->title }}</h1>
                        <div class="d-flex justify-content-between align-items-center my-4">
                            <div class="d-flex">
                                <img
                                    src="{{ render_url_upload($item->admin->logo) }}"
                                    onerror="this.onerror=null;this.src='{{ asset("images/avatar-default.png") }}';"
                                    alt=""
                                    style="width: 45px; height: 45px; border-radius: 50%; object-fit: cover;" class="border">
                                <div class="ms-3">
                                    <b class="fs-14px">{{ $item->admin->name }} </b>
                                    <div class="fs-12px">
                                        {{ calculate_time($item->created_at) }} -
                                        {{ calculate_time_for_read($item->content) }} đọc

                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="my-4 fw-bolder" style="font-size: 18px,">
                            {!! $item->short_description !!}
                        </div>
                        <div class="">
                            {!! $item->content !!}
                        </div>
                        @php
                            $tags = explode("|",$item->tag);
                        @endphp
                        <div class="">
                            <span class="me-2">Tag:</span>
                            @foreach($tags as $tag)
                                <a href="{{ route("get.blog.search", ["tag" => strtolower($tag)]) }}"
                                class="tag-gray">{{ $tag }}</a>
                            @endforeach
                        </div>
                    </div>
                </div>
                
            </div>
        </div>

        @include("base::layouts.includes.inc_comment")

        <div class="my-5">
            <div class="fw-bold mb-3">Bài viết khác</div>
                @foreach($itemsNew as $item)
                    @include("products::pages.blogs.includes.inc_item_blog_detail", $item)
                @endforeach
            </div>
        </div>
@endsection

