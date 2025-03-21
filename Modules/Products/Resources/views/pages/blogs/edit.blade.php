@extends('base::layouts.master')
@section("breadcrumb")
{{--    {!! \Diglactic\Breadcrumbs\Breadcrumbs::render("books::edit") !!}--}}
@endsection
@section('content')
    @php
        $dataForm = [
            "action" => route("post.blog.update"),
            "type" => "update",
         ];
    @endphp
    @include("products::pages.blogs.form", $dataForm)
@endsection
