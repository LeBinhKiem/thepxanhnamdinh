@extends('base::layouts.master')
@section("breadcrumb")
    {!! \Diglactic\Breadcrumbs\Breadcrumbs::render("blog_categories::edit") !!}
@endsection
@section('content')
    @php
        $dataForm = [
            "action" => route("post.blog_categories.update"),
            "type" => "update",
         ];
    @endphp
    @include("products::pages.blog_categories.form", $dataForm)
@endsection
