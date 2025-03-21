@extends('base::layouts.master')
@section("breadcrumb")
    {!! \Diglactic\Breadcrumbs\Breadcrumbs::render("categories::create") !!}
@endsection
@section('content')
    @php
        $dataForm = [
            "action" => route("post.categories.store"),
            "type" => "create",
         ];
    @endphp
    @include("products::pages.categories.form", $dataForm)
@endsection
