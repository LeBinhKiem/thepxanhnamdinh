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
            <div class="mt-5">
                <form action="" method="get">
                    <div class="row">
                        <div class="col-lg-4 col-md-6">
                            <div class="form-group">
                                <label class="form-label fw-bold">Tìm kiếm theo tên</label>
                                <input type="text" class="form-control form-control-sm" name="name" placeholder="Tìm kiếm theo tên"
                                       value="{{ old('name', $query['name'] ?? '') }}">
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <div class="form-group">
                                <label class="form-label fw-bold">Tìm kiếm theo danh mục</label>
                                <select class="form-select form-select-sm py-2" name="category_id">
                                    <option value="">Chọn danh mục</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ selectedCompareValue($query["category_id"] ?? [], $category->id) }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary-web">Tìm kiếm</button>
                    <a href="{{ route("get.sell.search") }}" class="btn btn-secondary">Xóa lọc</a>
                </form>
                
            </div>
            <div class="mt-5">
                <h1 class="mb-3 text-center">Sản phẩm</h1>
                <div class="row">
                    @if(count($items) > 0)
                        @foreach($items as $item)
                            @include("sell::items.item_product", ["item" => $item])
                        @endforeach
                    @else
                        <div class="col-12 text-center">
                            Không có sản phẩm
                        </div>
                    @endif
                </div>
                <div class="mb-5 d-flex justify-content-center">
                    {{-- {!! \Modules\Base\Helpers\Classics\PaginateHelper::paginate($items, $query) !!} --}}
                    {{ $items->appends(request()->input())->links() }}
                </div>
                
            </div>
        </div>

    </div>
@stop
@section("script")

@stop
