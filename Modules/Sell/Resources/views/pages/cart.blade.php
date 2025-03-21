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
    <div class="bg-white">
        <div class="container">
            <div class="row mt-5">
                <div class="col-lg-8">
                    <table class="table border-end table-cart border-start">
                        <thead class="table-success">
                        <tr>
                            <th scope="col"></th>
                            <th scope="col" >Sản phẩm</th>
                            <th scope="col">Giá</th>
                            <th scope="col">Thành tiền</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(count($carts) < 1)
                            <tr>
                                <td colspan="4" class="text-center fw-bold" >Không có sản phẩm trong giỏ hàng</td>
                            </tr>
                        @endif
                        @foreach($carts as $cart)
                            @php
                                $product = $cart->product;
                                if (!$product) {
                                    continue;
                                }
                            @endphp

                            <tr data-id="{{ $product->id }}">
                                <td>
                                    <div class="border-1  border d-flex justify-content-center align-items-center js-remove-item"
                                         data-id="{{ $product->id }}"
                                         style="width: 30px;height: 30px;border-radius:50%; cursor: pointer">
                                        <i class=" fa-solid fa-xmark"></i>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img src="{{ render_url_upload($product->image) }}"
                                             style="width: 80px; height: 80px; object-fit: contain">
                                        <div class="ms-2">
                                            <a class=""
                                               href="{{ route("get.sell.detail", $product->id) }}"
                                            >{{ limit_text($product->name,35) }}</a>
                                            <div class="mb-1">
                                                #Số lượng: <span>{{ $product->amount }}</span>
                                            </div>
                                            <div class="input-group d-flex flex-wrap">
                                                <div class="input-group-prepend">
                                                    <button class="btn btn-white js-button-minus" type="button">-</button>
                                                </div>
                                                <input type="number" class="border-0 text-center" style="outline: none;
                         width: 60px;
                         box-shadow: 0 4px 6px rgba(50, 50, 93, 0.11), 0 1px 3px rgba(0, 0, 0, 0.08);"
                                                       value="{{ ($cart->amount > $product->amount) ? $product->amount : $cart->amount }}"
                                                       min="0" max="{{ $product->amount }}">
                                                <div class="input-group-append">
                                                    <button class="btn btn-white js-button-plus" type="button">+</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ number_format($product->price * (100 - $product->percent_sale) / 100) }} VNĐ</td>
                                <td class="total"
                                    data-total-root="{{ $product->price * (100 - $product->percent_sale) / 100 }}">
                                    {{ number_format($product->price * (100 - $product->percent_sale) / 100 * $cart->amount)  }}
                                    VNĐ
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="col-lg-4">
                    <table class="table border-end border-start">
                      <thead class="table-success">
                        <tr>
                            <th scope="col">Tổng tiền</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr class="text-center">
                            <td>
                                <div class="fw-bold fs-24px js-show-total">0 VNĐ</div>
                            </td>
                        </tr>
                        <tr>
                            @if(count($carts) > 0)
                                <th scope="row">
                                    <a href="{{ route("get.sell.checkout") }}" class="btn btn-primary-web w-100">Thanh
                                        toán</a>
                                </th>
                            @else

                            @endif
                        </tr>
                      </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @csrf
@stop
@section("script")
    <script>
        const URL_UPDATE_CART = '{{ route("post.sell.updateCart") }}'

        loadTotalAll();

        function check($element) {
            let min = $element.attr("min");
            let max = $element.attr("max");

            min = parseInt(min);
            max = parseInt(max);

            let value = $element.val();

            if (value < min) {
                $element.val(1);
                alert("Số lượng phải lớn hơn 0")
            }
            if (value > max) {
                $element.val(1);
                alert("Không đủ số lượng đơn trong kho")
            }
            loadTotalItem($element);
            loadTotalAll();

            return true;
        }

        function loadTotalItem($element) {
            $parent = $element.closest('tr');
            let id = $parent.data("id");
            let amount = $element.val()
            let money = $parent.find(".total").data("total-root");
            $parent.find(".total").text((parseInt(amount) * parseInt(money)).toLocaleString('vi-VN') + " VNĐ")
            let _token = $('input[name=_token').val();

            $.ajax({
                url: URL_UPDATE_CART,
                type: 'POST',
                data: {
                    product_id: id,
                    amount: amount,
                    type: "update",
                    _token: _token,
                },
                success: function (reponse) {

                }
            })
        }

        function loadTotalAll() {
            let total = 0;
            $(".total").each(function () {
                let value = $(this).text();
                value = value.replaceAll("VNĐ", "");
                value = value.replaceAll(",", "");
                value = value.replaceAll(".", "");
                total += parseInt(value);
            })
            $(".js-show-total").text((total).toLocaleString('vi-VN') + " VNĐ");
        }

        $("input[type='number']").change(function () {
            check($(this));
        });

        $(".js-button-plus").click(function () {
            let $input = $(this).closest(".input-group").find("input").first();
            $input.val(parseInt($input.val()) + 1);
            check($input);
        });
        $(".js-button-minus").click(function () {
            let $input = $(this).closest(".input-group").find("input").first();
            $input.val(Math.max(1, parseInt($input.val()) - 1));
            check($input);
        });
        $(".js-remove-item").click(function () {
            let confirmRemove = confirm("Bạn có chắc chắn muốn xóa");
            if (!confirmRemove) {
                return;
            }
            let id = $(this).data("id");
            let _token = $('input[name=_token').val();

            $(this).closest("tr").remove();
            $.ajax({
                url: URL_UPDATE_CART,
                type: 'POST',
                data: {
                    product_id: id,
                    _token: _token,
                },
                success: function (response) {
                    loadTotalAll();
                    checkCartEmpty(); // Kiểm tra lại giỏ hàng
                }
            });
        });

        function checkCartEmpty() {
            if ($(".table-cart tbody tr").length == 0) {
                $(".btn-primary-web").closest("tr").hide(); // Ẩn cả dòng chứa nút Thanh toán
                $(".table-cart tbody").html('<tr><td colspan="4" class="text-center fw-bold">Không có sản phẩm trong giỏ hàng</td></tr>');
            }
        }
    </script>
@stop
