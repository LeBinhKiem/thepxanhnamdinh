@extends('base::layouts.master')
@section("breadcrumb")
    {!! \Diglactic\Breadcrumbs\Breadcrumbs::render("blog::create") !!}
@endsection
@section('content')
    @php
        $dataForm = [
            "action" => route("post.blog.store"),
            "type" => "create",
         ];
    @endphp
    @include("products::pages.blogs.form", $dataForm)
@endsection
@section('script')
@endsection
