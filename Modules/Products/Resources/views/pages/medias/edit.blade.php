@extends('base::layouts.master')
@section("breadcrumb")
{{--    {!! \Diglactic\Breadcrumbs\Breadcrumbs::render("books::edit") !!}--}}
@endsection
@section('content')
    @php
        $dataForm = [
            "action" => route("post.medias.update"),
            "type" => "update",
         ];
    @endphp
    @include("products::pages.medias.form", $dataForm)
@endsection
