@extends('base::layouts.master')
@section("breadcrumb")
{{--    {!! \Diglactic\Breadcrumbs\Breadcrumbs::render("books::create") !!}--}}
@endsection
@section('content')
    @php
        $dataForm = [
            "action" => route("post.products.store"),
            "type" => "create",
         ];
    @endphp
    @include("products::pages.products.form", $dataForm)
@endsection
