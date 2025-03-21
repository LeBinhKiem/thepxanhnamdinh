@extends('base::layouts.master')
@section("breadcrumb")
    {!! \Diglactic\Breadcrumbs\Breadcrumbs::render("admin::edit") !!}
@endsection
@section('content')
    @php
        $dataForm = [
            "action" => route("post.admin.updateRegister"),
            "type" => "update",
         ];
    @endphp
    @include("accounts::pages.admin.includes.form", $dataForm)
@endsection
@section("script")

@stop
