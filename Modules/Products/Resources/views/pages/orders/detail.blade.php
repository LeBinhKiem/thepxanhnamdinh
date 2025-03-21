@extends('base::layouts.master')
@section("breadcrumb")
    {{--    {!! \Diglactic\Breadcrumbs\Breadcrumbs::render("books") !!}--}}
@endsection
@section('content')
    <div class="">
        <table class="table ">
            <thead class="table-light sticky-top top-0">
            <tr>
                <th scope="col" width="5%">ID</th>
                <th scope="col" width="25%">Sản phẩm</th>
                <th scope="col" width="10%">Hình ảnh</th>
                <th scope="col" width="20%">Giá</th>
                <th scope="col" width="20%">Số lượng</th>
                <th scope="col" width="20%">Tổng</th>
            </tr>
            </thead>
            <tbody>
            @php
                $items = json_decode($order->product_json);
            @endphp
            @if(count($items) > 0)
                @foreach($items as $item)
                    <tr>
                        <th scope="row">{{ $item->id }}</th>
                        <td>
                            <b class="d-block">
                                <a>{{ $item->name }}</a>
                            </b>
                        </td>
                        <td>
                            <div class="avatar avatar-lg rounded-circle mt-2  me-2">
                                <img alt="Image placeholder"
                                     onerror="this.onerror=null;this.src='{{ asset("images/image-default.jpg") }}';"
                                     src="{{ render_url_upload($item->image) }}">
                            </div>
                        </td>
                        <td>
                             {{ number_format((int) $item->price) }} VNĐ
                        </td>
                        <td>
                             {{ number_format($item->amount) }}
                        </td>
                        <td>
                             {{ number_format((int) $item->price * $item->amount) }} VNĐ
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="7">Không có dữ liệu</td>
                </tr>
            @endif
            </tbody>
        </table>
    </div>
@endsection
