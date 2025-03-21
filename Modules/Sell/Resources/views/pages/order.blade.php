@extends("sell::layouts.master")
@section("css")

@stop
@section("content")
    <div class="container">
        <div class="row">
            <div class="my-5">
                <h1 class="text-center mb-3">Đơn hàng đã đặt</h1>
                @foreach ($items as $item)
                    <table class="table m-0">
                        <thead class="table-light sticky-top top-0">
                        <tr>
                            <th scope="col" width="25%">Thông tin</th>
                            <th scope="col" width="25%">Phương thức</th>
                            <th scope="col" width="30%">Tổng tiền</th>
                            <th scope="col" class="text-center" width="15%">Trạng thái</th>
                            <th scope="col" width="20%">Ngày tạo đơn</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(count($items) > 0)
                            @php
                                $status = \Modules\Products\Enums\OrderEnum::ARR_STATUS;
                            @endphp
                                <tr>
                                    <td>
                                        <div class="">
                                            {{ $item->name  }}
                                        </div>
                                        <div class="fs-12px">
                                            #Số điện thoại: {{ $item->number_phone }}
                                        </div>
                                        <div class="fs-12px">
                                            #Địa chỉ: {{ $item->address }}
                                        </div>
                                    </td>
                                    <td>
                                        {{ $item->payment }}
                                    </td>
                                    <td>
                                        {{ number_format($item->total) }} VNĐ
                                    </td>
                                    <td class="text-center">
                                        <span class="{{ $status[$item->status]["class"] }}">{{ $status[$item->status]["text"] }}</span>
                                    </td>
                                    <td>{{ date('d/m/Y H:i:s', strtotime($item->updated_at)) }}</td>
                                </tr>
                            @else
                                <tr>
                                    <td colspan="7">Không có dữ liệu</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                    <table class="table ">
                        <thead class="table-light sticky-top top-0">
                        <tr>
                            <th scope="col" width="25%">Sản phẩm</th>
                            <th scope="col" width="10%">Hình ảnh</th>
                            <th scope="col" width="20%">Giá</th>
                            <th scope="col" width="20%">Số lượng</th>
                            <th scope="col" width="20%">Thành tiền</th>
                        </tr>
                        </thead>
                        <tbody>
                        @php
                            $products = json_decode($item->product_json, true); 
                        @endphp
                        @if(count($products) > 0)
                            @foreach($products as $product)
                                <tr>
                                    <td>
                                        <b class="d-block">
                                            <a>{{ $product['name'] }}</a>
                                        </b>
                                    </td>
                                    <td>
                                        <div class="avatar  mt-2  me-2">
                                            <img alt="Image placeholder"
                                                 onerror="this.onerror=null;this.src='{{ asset("images/image-default.jpg") }}';"
                                                 src="{{ render_url_upload($product['image']) }}">
                                        </div>
                                    </td>
                                    <td>
                                         {{ number_format((int) $product['price']) }} VNĐ
                                    </td>
                                    <td>
                                         {{ number_format($product['amount']) }}
                                    </td>
                                    <td>
                                         {{ number_format((int) $product['price'] * $product['amount']) }} VNĐ
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
                    <br>
                @endforeach
            </div>
        </div>
    </div>
@stop
@section("script")
    
@stop
