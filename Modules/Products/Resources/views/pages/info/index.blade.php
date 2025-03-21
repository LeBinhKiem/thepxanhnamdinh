@extends('base::layouts.master')
@section("breadcrumb")
{{--    {!! \Diglactic\Breadcrumbs\Breadcrumbs::render("books") !!}--}}
@endsection
@section('content')
    @php
        $dataForm = [
            "action" => route("post.info.update"),
            "type" => "update",
         ];
    @endphp
    @include("products::pages.info.form", $dataForm)
@endsection
