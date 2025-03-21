@extends('base::layouts.master')
@section("breadcrumb")
    {!! \Diglactic\Breadcrumbs\Breadcrumbs::render("blog_categories::create") !!}
@endsection
@section('content')
    @php
        $dataForm = [
            "action" => route("post.blog_categories.store"),
            "type" => "create",
         ];
    @endphp
    @include("products::pages.blog_categories.form", $dataForm)
@endsection
