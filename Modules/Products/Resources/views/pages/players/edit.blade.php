@extends('base::layouts.master')
@section("breadcrumb")

@endsection
@section('content')
    @php
        $dataForm = [
            "action" => route("post.players.update"),
            "type" => "update",
         ];
    @endphp
    @include("products::pages.players.form", $dataForm)
@endsection
