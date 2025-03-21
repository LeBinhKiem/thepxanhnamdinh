@extends("sell::layouts.master")
@section("css")
    <style>
        input[type="number"]::-webkit-outer-spin-button,
        input[type="number"]::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        input[type="number"] {
            -moz-appearance: textfield;
        }

        .table-cart td {
            vertical-align: middle
        }
    </style>
@stop
@section("content")
    <div class="container">
        <div class="row mt-5 flex-row-reverse">
            <div class="col-lg-6">
                <b>Đơn hàng của bạn</b>
                <table class="table border-end table-cart border-start mt-3">
                    <thead class="table-success">
                    <tr>
                        <th scope="col">Sản phẩm</th>
                        <th scope="col">Giá</th>
                        <th scope="col">Số lượng</th>
                        <th scope="col">Thành tiền</th>
                    </tr>
                    </thead>
                    <tbody>
                    @php
                        $total = 0;
                        $jsonProduct = [];
                    @endphp
                    @foreach($carts as $cart)
                        @php
                            $product = $cart->product;
                            if (!$product)
                            {
                                continue;
                            }

                            $totalItem = $product->price * (100 - $product->percent_sale) / 100;
                            $jsonProduct[] = [
                                "user_id" => get_user_id(),
                                "id" => $product->id,
                                "name" => $product->name,
                                "price" => $totalItem,
                                "image" => $product->image,
                                "amount" => $cart->amount,
                                ];
                            $totalItem = $totalItem * $cart->amount ;
                            $total += $totalItem;
                        @endphp
                        <tr>
                            <td>
                                <img src="{{ render_url_upload($product->image) }}"
                                     style="width: 80px; height: 80px; object-fit: contain">
                                <a class="ms-2" href="
                            {{ route("get.sell.detail", $product->id) }}
                            ">{{ limit_text($product->name,30) }}</a>
                            </td>
                            <td>{{ number_format($product->price * (100 - $product->percent_sale) / 100) }} VNĐ</td>
                            <td class="text-center">
                                {{ $cart->amount }}
                            </td>
                            <td>{{ number_format($totalItem)  }} VNĐ</td>
                        </tr>
                    @endforeach
                    <tr class="fw-bold">
                        <td style="background-color: #c4f1de" colspan="3">Tổng tiền:</td>
                        <td style="background-color: #c4f1de">{{ number_format($total) }} VNĐ</td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-lg-6">
                <form action="{{ route("post.sell.payment") }}" method="post">
                    @csrf
                    <div class="">
                        <b>Thông tin khách hàng</b>
                        <div class="row mt-3">
                            <div class="col-lg-6">
                                <div class="mb-3 form-group {{ has_error($errors, "name") }}">
                                    <label for="" class="form-label">Họ và tên</label>
                                    <input type="text" name="name" value="{{ old("name", $user->full_name ?? "") }}"
                                           class="form-control" placeholder="Họ tên">
                                    {!! get_error($errors, "name") !!}
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3 form-group {{ has_error($errors, "number_phone") }}">
                                    <label for="" class="form-label">Số điện thoại</label>
                                    <input type="text" name="number_phone"
                                           value="{{ old_input("number_phone", $user) }}" class="form-control"
                                           placeholder="Số điện thoại">
                                    {!! get_error($errors, "number_phone") !!}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mt-2">
                        <b>Địa điểm nhận hàng</b>
                        <div class="row mt-3">
                            <div class="col-12 form-group {{ has_error($errors, "address") }}">
                            <textarea class="form-control" name="address" id="" cols="30" rows="5"
                                      placeholder="Nhập địa chỉ nhận hàng">{{ old("address", $user->short_desc ?? "") }}</textarea>
                                {!! get_error($errors, "address") !!}
                            </div>
                        </div>
                    </div>
                    <div class="mt-2">
                        <b>Phương thức thanh toán</b>
                        <div class="row mt-2 {{ has_error($errors, "payment") }} form-group">
                            <ul class="nav nav-tabs border-0" id="myTab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <div class="d-flex" style="cursor: pointer">
                                        <input class="nav-link active ms-3" id="direct-input" data-bs-toggle="tab"
                                               data-bs-target="#direct" checked
                                               name="payment" value="Tiền mặt"
                                               type="radio" role="tab" aria-controls="home" aria-selected="true">
                                        <label style="cursor: pointer" class="mb-0 ms-2" for="direct-input">Tiền
                                            mặt</label>
                                    </div>
                                </li>
                               <li class="nav-item" role="presentation">
                                   <div class="d-flex ms-3" style="cursor: pointer">
                                       <input class="nav-link" id="banking-input" data-bs-toggle="tab" 
                                              data-bs-target="#banking"
                                              name="payment" value="Chuyển khoản"
                                              type="radio" role="tab" aria-controls="home" aria-selected="true">
                                       <label style="cursor: pointer" class="mb-0 ms-2" for="banking-input">Chuyển khoản</label>
                                   </div>
                               </li>
                            </ul>
                            
                            <div class="tab-content mt-3" id="myTabContent">
                                <div class="tab-pane fade show active" id="direct" role="tabpanel"
                                     aria-labelledby="home-tab">
                                    <div class="alert alert-success text-center" role="alert">
                                        Bạn sẽ phải thanh toán ngay khi đơn hàng được giao
                                    </div>
                                </div>
                                <div class="tab-pane" id="banking" role="tabpanel" aria-labelledby="profile-tab">
                                    <div class="alert alert-success text-center" role="alert">
                                        Bạn sẽ thanh toán bằng thẻ visa
                                    </div>
                                </div>
                            </div>
                            {!! get_error($errors, "payment") !!}
                        </div>
                    </div>
                    <div class="mt-2">
                        <input type="hidden" name="total" value="{{ $total }}">
                        <input type="hidden" name="product_json" value="{{ json_encode($jsonProduct) }}">
                        <button id="order-button" type="submit" class="btn btn-primary-web w-100">Đặt hàng</button>
                        <a id="banking-link" class="btn btn-primary-web w-100 d-none" href="{{route('get.sell.stripe',$total)}}">Thanh toán</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const directInput = document.getElementById("direct-input");
            const bankingInput = document.getElementById("banking-input");
            const orderButton = document.getElementById("order-button");
            const bankingLink = document.getElementById("banking-link");

            directInput.addEventListener("change", function() {
                orderButton.classList.remove("d-none");
                bankingLink.classList.add("d-none");
            });

            bankingInput.addEventListener("change", function() {
                orderButton.classList.add("d-none");
                bankingLink.classList.remove("d-none");
            });
        });
    </script>
@stop
