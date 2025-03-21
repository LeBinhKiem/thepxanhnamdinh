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

    </style>
@stop
@section("content")
    <div class="bg-white">
        <div class="container">
            <div class="row mt-5">
                <div class="col-lg-6">
                    <img src="{{ render_url_upload($item->image) }}" class="w-100">
                </div>
                <div class="col-lg-6">
                    <div class="text-primary-web mb-2">
                        {{ $item->category->name }}
                    </div>
                    <div class="fw-bold mb-2">
                        {{ $item->name }}
                    </div>
                    <div class="fw-bold text-body mb-2">
                        @if($item->percent_sale > 0)
                        <span class="strikethrough text-gray me-1 fs-12px">
                            {{ number_format($item->price) }} VNĐ
                        </span>
                        @endif
                        {{ number_format($item->price * (100 - $item->percent_sale) / 100) }} VNĐ
                    </div>
                    <div class="mb-3">
                        Số lượng: {{ $item->amount }}
                    </div>
                    <form action="{{ route("post.sell.insertCart") }}" method="post">
                        <div class="row">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $item->id }}">
                            <div class="input-group mb-3 col-lg-4">
                                <div class="input-group-prepend">
                                    <button class="btn btn-white" type="button" id="button-minus">-</button>
                                </div>
                                <input type="number" name="amount" class="border-0 text-center" style="outline: none;
                         width: 60px;
                         box-shadow: 0 4px 6px rgba(50, 50, 93, 0.11), 0 1px 3px rgba(0, 0, 0, 0.08);"
                                       id="number-input" value="1" min="1" max="{{ $item->amount }}">
                                <div class="input-group-append">
                                    <button class="btn btn-white" type="button" id="button-plus">+</button>
                                </div>
                            </div>
                            <div class="col-lg-8">
                                <button class="btn btn-primary-web">Thêm vào giỏ hàng</button>
                            </div>
                        </div>
                    </form>
                    <div class="border border-1 rounded-2 p-3 mt-1">
                        <div class="text-center fw-bold fs-14px">Các phương thức thanh toán</div>
                        <div class="d-flex justify-content-center align-items-center mt-3">
                            <span class="d-flex flex-column align-items-center me-3" data-toggle="tooltip"
                                  data-placement="top" title="Tiền mặt">
                                 <i class="fa-solid fa-money-bill text-blue fs-30px"></i>
                                <span class="fs-14px mt-1">Tiền mặt</span>
                            </span>
                            <span class="d-flex flex-column align-items-center" data-toggle="tooltip"
                                  data-placement="top" title="Chuyển khoản">
                                <i class="fa-regular fa-credit-card text-success fs-28px"></i>
                                <span class="fs-14px mt-1">Chuyển khoản</span>
                            </span>
                        </div>
                    </div> 
                </div>
            </div>
            <ul class="nav nav-tabs mt-5" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#description"
                            type="button" role="tab" aria-controls="home" aria-selected="true">Mô tả
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#review"
                            type="button" role="tab" aria-controls="profile" aria-selected="false">Đánh giá
                    </button>
                </li>
            </ul>
            <div class="tab-content mt-4" id="myTabContent">
                <div class="tab-pane fade show active" id="description" role="tabpanel" aria-labelledby="home-tab">
                    {{ $item->description  }}
                </div>
                <div class="tab-pane fade" id="review" role="tabpanel" aria-labelledby="profile-tab">
                    @include("base::layouts.includes.inc_vote", $vote)
                </div>
            </div>
            <div class="mt-5">
                <h1 class="mb-3">Sản phẩm tương tự</h1>
                <div class="row">
                    @foreach($productsOther as $product)
                        @include("sell::items.item_product", ["item" => $product])
                    @endforeach
                </div>
            </div>
        </div>

    </div>
@stop
@section("script")
    <script>
        $("#number-input").change(function () {
            check($(this));
        });

        function check($element) {
            let min = $element.attr("min");
            let max = $element.attr("max");

            min = parseInt(min);
            max = parseInt(max);

            let value = $element.val();
            if (value < min) {
                $element.val(1);
                alert("Số lượng phải lớn hơn 0")
                return false;
            }
            if (value > max) {
                $element.val(1);
                alert("Không đủ số lượng đơn trong kho")
                return false;
            }
            return true;
        }

        $("#button-plus").click(function () {
            let $element = $("#number-input");
            $element.val(parseInt($element.val()) + 1);
            check($element);
        })
        $("#button-minus").click(function () {
            let $element = $("#number-input");
            $element.val(parseInt($element.val()) - 1);
            check($element);
        })

    </script>
@stop
