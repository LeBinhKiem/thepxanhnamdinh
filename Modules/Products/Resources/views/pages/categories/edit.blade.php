@extends('base::layouts.master')
@section("breadcrumb")
    {!! \Diglactic\Breadcrumbs\Breadcrumbs::render("categories::edit") !!}
@endsection
@section('content')
    @php
        $dataForm = [
            "action" => route("post.categories.update"),
            "type" => "update",
         ];
    @endphp
    @include("products::pages.categories.form", $dataForm)
@endsection
