@extends('base::layouts.master')
@section("breadcrumb")
    {!! \Diglactic\Breadcrumbs\Breadcrumbs::render("admin::create") !!}
@endsection
@section('content')
    @php
        $dataForm = [
            "action" => route("post.admin.store"),
            "type" => "create",
         ];
    @endphp
    @include("accounts::pages.admin.includes.form", $dataForm)
@endsection
@section("script")

@stop
