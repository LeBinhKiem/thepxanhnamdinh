@extends('base::layouts.master')
@section("breadcrumb")
{{--    {!! \Diglactic\Breadcrumbs\Breadcrumbs::render("books::edit") !!}--}}
@endsection
@section('content')
    @php
        $dataForm = [
            "action" => route("post.coaches.update"),
            "type" => "update",
         ];
    @endphp
    @include("products::pages.coaches.form", $dataForm)
@endsection
